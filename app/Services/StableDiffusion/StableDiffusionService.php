<?php

namespace App\Services\StableDiffusion;

use App\Models\GeneratedImage;
use App\Services\Curl\CurlService;
use App\Traits\File\FileUploadTrait;
use App\Utils\AppIntegrationUrlKey;
use Illuminate\Support\Facades\Http;
use App\Services\AiData\AiDataService;
use App\Services\Core\AiConfigService;
use App\Services\Core\StableDiffusion;
use App\Services\Prompt\PromptService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\Balance\BalanceService;

/**
 * Class StableDiffusionService.
 */
class StableDiffusionService
{
    use FileUploadTrait;

    public function initSD(StableDiffusion $stableDiffusion)
    {

    }

    public function generateContent($request)
    {
        $appStatic = appStatic();
        $contentPurpose = $request->content_purpose;

        return match ($contentPurpose){
            $appStatic::SD_TEXT_2_IMAGE                 =>  $this->generateText2Image($request),
            $appStatic::SD_TEXT_2_IMAGE_MULTI_PROMPT    =>  $this->generateText2ImageMultiPrompt($request),
            $appStatic::SD_IMAGE_2_IMAGE_PROMPT         =>  $this->generateImage2ImagePrompt($request),
            $appStatic::SD_IMAGE_2_IMAGE_UPSCALING      =>  $this->generateImage2ImageUpScaling($request),
            $appStatic::SD_IMAGE_2_IMAGE_MASKING        =>  $this->generateImage2ImageMasking($request),
        };
    }

    /**
     * @throws \JsonException
     */
    public function generateText2Image($request)
    {
        $stableDiffusion = new StableDiffusion();
        $aiConfigService = new AiConfigService();

        $contentPurpose = $request->content_purpose;
        $platform       = $aiConfigService->setPlatform(appStatic()::ENGINE_STABLE_DIFFUSION);
        $prompt         = (new PromptService())->setPrompt($contentPurpose);
        $usingModel     = $aiConfigService->getModelBasedOnPurpose($contentPurpose);
        $size           = setSize();
        $explodeSize    = explode("x", $size);

        if(count($explodeSize) <= 0){
            throw new \Exception("Invalid SD size");
        }

        $height = (int) $explodeSize[0];
        $width  = (int) $explodeSize[1];


        $opts = $aiConfigService->setConfiguration(
            $platform, $contentPurpose, $prompt, [],
            [
                "height" => $height,
                'width'  => $width,
            ]
        );
        $curlService = new CurlService();
     
        $curlResponse = $curlService->handle(
            $stableDiffusion->setURLText2Image($usingModel),
            $opts, 5,'POST',$stableDiffusion->getAuthorization()
        );

        $resCode = $curlResponse["code"];
        $resBody = $curlResponse["body"];

        if($resCode != appStatic()::SUCCESS){
            throw new \RuntimeException($resBody->message);
        }


        return (new AiDataService())->saveGeneratedImage(
            $resBody, $prompt, $request, appStatic()::ENGINE_STABLE_DIFFUSION, $usingModel
        );
    }

    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function generateText2ImageMultiPrompt($request)
    {
        $stableDiffusion = new StableDiffusion();
        $aiConfigService = new AiConfigService();

        $contentPurpose = $request->content_purpose;
        $platform       = $aiConfigService->setPlatform(appStatic()::ENGINE_STABLE_DIFFUSION);
        $prompt         = (new PromptService())->setPrompt($contentPurpose);
        $usingModel     = $aiConfigService->getModelBasedOnPurpose($contentPurpose);
        $size           = setSize();
        $explodeSize    = explode("x", $size);

        if(count($explodeSize) <= 0){
            throw new \Exception("Invalid SD size");
        }

        $height = (int) $explodeSize[0];
        $width  = (int) $explodeSize[1];

        $opts = $aiConfigService->setConfiguration(
            $platform, $contentPurpose, $prompt, [],
            [
                "height" => $height,
                'width'  => $width,
            ]
        );


        $curlService = new CurlService();

        $curlResponse = $curlService->handle(
            $stableDiffusion->setURLText2Image($usingModel),
            $opts, 5,'POST',
            [], [], $stableDiffusion->getAuthorization()
        );

        $resBody= $curlResponse["body"];

        return (new AiDataService())->saveGeneratedImage(
            $resBody, $prompt, $request, appStatic()::ENGINE_STABLE_DIFFUSION, $usingModel
        );
    }


    /**
     * @throws \JsonException
     */
    public function generateImage2ImagePrompt($request)
    {
        $stableDiffusion = new StableDiffusion();
        $aiConfigService = new AiConfigService();

        $contentPurpose = $request->content_purpose;
        $platform       = $aiConfigService->setPlatform(appStatic()::ENGINE_STABLE_DIFFUSION);
        $prompt         = (new PromptService())->setPrompt($contentPurpose);
        $usingModel     = $aiConfigService->getModelBasedOnPurpose($contentPurpose);

        /**
         * Upload the image
         * */

        $image = $request->image;

        // Uploaded Image Path saved into $imagePath Params
        $imagePath = $this->uploadFile($image, fileService()::DIR_SD);

        $opts = $aiConfigService->setConfiguration(
            $platform, $contentPurpose, $prompt
        );

        $opts += ["init_image" => curl_file_create(public_path()."/".$imagePath)];

        info("img to img Prompt : ". json_encode($opts, JSON_THROW_ON_ERROR));

        $curlService = new CurlService();

        $curlHeaders = $stableDiffusion->getAuthorization(
            true,
            "Content-Type: multipart/form-data",
            ["Accept: application/json"]
        );


        $curlResponse = $curlService->handle(
            $stableDiffusion->setURLImage2Image($usingModel),
            $opts,
            5,
            false,
            [],
            [],
            $curlHeaders,
            false
        );

        $resBody= $curlResponse["body"];
        $resCode= $curlResponse["code"];

        if ($resCode != 200) {
            throw new \Exception("Bad Request : " . $resBody->message);
        }

        // DELETE Uploaded File
        unlinkFile($imagePath);

        info("Curl Response: ", $curlResponse);

        return (new AiDataService())->saveGeneratedImage(
            $resBody, $prompt, $request, appStatic()::ENGINE_STABLE_DIFFUSION, $usingModel
        );
    }

    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function generateImage2ImageUpScaling($request)
    {
        $stableDiffusion = new StableDiffusion();
        $aiConfigService = new AiConfigService();

        $contentPurpose = $request->content_purpose;
        $platform       = $aiConfigService->setPlatform(appStatic()::ENGINE_STABLE_DIFFUSION);
        $prompt         = (new PromptService())->setPrompt($contentPurpose);
        $usingModel     = $aiConfigService->getModelBasedOnPurpose($contentPurpose);

        /**
         * Upload the image
         * */

        $image = $request->image;

        // Uploaded Image Path saved into $imagePath Params
        $imagePath = $this->uploadFile($image, fileService()::DIR_SD);

        $opts = [
            "image" => curl_file_create(public_path()."/".$imagePath)
        ];

        wLog("img to img Up-Scaling : ". json_encode($opts, JSON_THROW_ON_ERROR),["errors" => $opts], logService()::LOG_SD);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.(new AppIntegrationUrlKey())->getStableDiffusionApiKey(),
            'Accept' => 'image/*',
        ])
            ->attach('image', file_get_contents(public_path()."/".$imagePath), $image->getClientOriginalName()) // Attach the image
            ->post($stableDiffusion->setURLImage2ImageUpscale($usingModel));

       if($response->failed()) {
           throw new \RuntimeException("Bad Request : " . $response->body(), $response->status());
       }

        // DELETE Uploaded File
        unlinkFile($imagePath);

        //TODO::Save for now, implement later

        // Save png file
        $fileName = env("APP_NAME","writerap") . "_sd_image_upscale_" . md5(time()) . ".png";

        $imagePath   = $this->savePngToDirectory($response->body(), fileService()::DIR_SD,$fileName);

        // Set the title to the request title if available, otherwise use the prompt
        $title = setTitle();

        // Prepare the payloads for database insertion
        $payloads = [
            "title"        => $title,
            "slug"         => slugMaker($title),
            "model_name"   => $usingModel,
            "prompt"       => $prompt,
            "storage_type" => !activeStorage() ? "local" : "s3",
            "content_type" => $contentPurpose,
            "platform"     => $platform,
            "article_id"   => $request->article_id,
            "file_path"    => $imagePath,
            "generated_image_path" => $imagePath,
            "is_active"       => 1
        ];

        return GeneratedImage::query()->create($payloads);
    }

    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function generateImage2ImageMasking($request)
    {
        $stableDiffusion = new StableDiffusion();
        $aiConfigService = new AiConfigService();

        $contentPurpose = $request->content_purpose;
        $platform       = $aiConfigService->setPlatform(appStatic()::ENGINE_STABLE_DIFFUSION);
        $prompt         = (new PromptService())->setPrompt($contentPurpose);
        $usingModel     = $aiConfigService->getModelBasedOnPurpose($contentPurpose);

        /**
         * Upload the image
         * */

        $image = $request->file("image");
        $imagePath = $this->uploadFile($image, fileService()::DIR_SD);


        $opts = $aiConfigService->setConfiguration(
            $platform, $contentPurpose, $prompt,[],["image" => $request->file("image")]
        );

//        return [
//            "uploadedFile" => $imagePath,
//            "opts"         => $opts,
//            "usingModel"   => $usingModel
//        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.(new AppIntegrationUrlKey())->getStableDiffusionApiKey(),
            'Accept' => 'image/*',
        ])
            ->attach('image', file_get_contents($image->getRealPath()), $image->getClientOriginalName()) // Attach the image
            ->post('https://api.stability.ai/v2beta/stable-image/generate/ultra', [
                'prompt'   => $prompt,
                'strength' => 0.75
            ]);

        if($response->failed()){

            throw new \Exception($response->body(), $response->status());
        }

        // Save png file
        $imagePath   = $this->savePngToDirectory($response->body(), fileService()::DIR_SD);

        // Set the title to the request title if available, otherwise use the prompt
        $title = setTitle();

        // Prepare the payloads for database insertion
        $payloads = [
            "title"        => $title,
            "slug"         => slugMaker($title),
            "model_name"   => $usingModel,
            "prompt"       => $prompt,
            "storage_type" => !activeStorage() ? "local" : "s3",
            "content_type" => $contentPurpose,
            "platform"     => $platform,
            "article_id"   => $request->article_id,
            "file_path"    => $imagePath,
            "generated_image_path" => $imagePath,
            "is_active"       => 1
        ];

        return GeneratedImage::query()->create($payloads);
    }

    public function sdArtifactsProcess($artifacts)
    {
        foreach ($artifacts as $key=>$artifact){
            $base64 = $artifact['base64'];


        }
    }


    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function generateVideo($request)
    {

        $stableDiffusion = new StableDiffusion();
        $aiConfigService = new AiConfigService();


        $contentPurpose = $request->content_purpose;
        $platform       = $aiConfigService->setPlatform(appStatic()::ENGINE_STABLE_DIFFUSION);
        $prompt         = "SD Image to Video";

        /**
         * Upload the image
         * */

        $image = $request->image;

        // Uploaded Image Path saved into $imagePath Params
        $imagePath = $this->uploadFile($image, fileService()::DIR_SD);

        $data = [
            "image" => curl_file_create(public_path()."/".$imagePath)
        ];

        $curlService = new CurlService();


        $curlHeaders = $stableDiffusion->getAuthorization(
            true,
            "Content-Type: multipart/form-data",
            ["Accept: application/json"]
        );

        $curlResponse = $curlService->handle(
            $stableDiffusion->setImage2VideoURL(),
            $data,
            5,
            'POST',
            [],
            [],
            $curlHeaders,
            false
        );

        $resBody= $curlResponse["body"];
        $resCode= $curlResponse["code"];
    
        if ($resCode != 200) {
            return $resBody;
            throw new \RuntimeException("Bad Request : " . $resBody->errors[0],400);
        }

        return (new AiDataService())->saveGeneratedVideo(
            $resBody, $prompt, $request, appStatic()::ENGINE_STABLE_DIFFUSION, "v2beta"
        );
    }
    public function prepareVideo($generationId):array
    {
        $apiKey       = config("services.stable-ai.key");
        $url          = "https://api.stability.ai/v2beta/image-to-video/result/{$generationId}";      
        $name         = slugMaker('image-to-video-').'output.mp4';
        $response     = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Accept' => 'video/*',
        ])->get($url);
        $data['response_code'] = $response->status();
        $data['message']       = '';
        $data['fileUrl']       = null;
        if($response->status() ==  202) {
            $data['message'] = localize('Still processing. Retrying in 10 seconds...');           
        }elseif($response->status() == 200){
            Storage::disk('video')->put($name, $response->body());
            $fileUrl = 'video/'.$name;          
            $data['fileUrl'] = $fileUrl;          
        }
        return $data;
    }

}
