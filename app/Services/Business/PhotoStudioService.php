<?php

namespace App\Services\Business;

use App\Models\GeneratedImage;
use App\Traits\File\FileUploadTrait;
use App\Utils\AppIntegrationUrlKey;
use Illuminate\Support\Facades\Http;

/**
 * Class PhotoStudioService.
 */
class PhotoStudioService
{
    use FileUploadTrait;
    private $appIntegrationUrlKey;

    public function __construct()
    {
        $this->appIntegrationUrlKey = new AppIntegrationUrlKey();
    }

    /**
     * Dynamically resolve method name based on the action.
     *
     * @param int $action
     * @return string
     */
    public function getActionMethodName(int $action): string
    {
        $appStatic = appStatic();

        return match ($action) {
            $appStatic::PHOTO_STUDIO_REIMAGINE => 'handleReimagine',
            $appStatic::PHOTO_STUDIO_REMOVE_BACKGROUND => 'handleRemoveBackground',
            $appStatic::PHOTO_STUDIO_REPLACE_BACKGROUND => 'handleReplaceBackground',
            $appStatic::PHOTO_STUDIO_REMOVE_TEXT => 'handleRemoveText',
            $appStatic::PHOTO_STUDIO_TEXT_TO_IMAGE => 'handleTextToImage',
            $appStatic::PHOTO_STUDIO_SKETCH_TO_IMAGE => 'handleSketchToImage',
            $appStatic::PHOTO_STUDIO_UPSCALE => 'handleUpscale',
            default => new \Exception("Invalid action: {$action}",404),
        };
    }

    /**
     * Handle 'Reimagine' action.
     */
    public function handleReimagine(array $payload)
    {
        if(!photoStudioTextToImage($payload["action"])){
            $fileRealPath                  = $this->getFileRealPath($payload["image_file"]);
            $payload["file_original_name"] = $payload["image_file"]->getClientOriginalName();
            $payload["filePath"]           = $fileRealPath;
        }

        return $this->sendApiRequest($this->appIntegrationUrlKey::REIMAGINE_URL, $payload);
    }


    /**
     * Handle 'Remove Background' action.
     */
    public function handleRemoveBackground(array $payload)
    {
        $fileRealPath                  = $this->getFileRealPath($payload["image_file"]);
        $payload["file_original_name"] = $payload["image_file"]->getClientOriginalName();
        $payload["filePath"]           = $fileRealPath;

        return $this->sendApiRequest($this->appIntegrationUrlKey::REMOVE_BACKGROUND_URL, $payload);
    }

    /**
     * Handle 'Replace Background' action.
     */
    public function handleReplaceBackground(array $payload)
    {
        $fileRealPath                  = $this->getFileRealPath($payload["image_file"]);
        $payload["file_original_name"] = $payload["image_file"]->getClientOriginalName();
        $payload["filePath"]           = $fileRealPath;

        return $this->sendApiRequest($this->appIntegrationUrlKey::REPLACE_BACKGROUND_URL, $payload);
    }

    /**
     * Handle 'Remove Text' action.
     */
    public function handleRemoveText(array $payload)
    {
        $fileRealPath                  = $this->getFileRealPath($payload["image_file"]);
        $payload["file_original_name"] = $payload["image_file"]->getClientOriginalName();
        $payload["filePath"]           = $fileRealPath;

        return $this->sendApiRequest($this->appIntegrationUrlKey::REMOVE_TEXT_URL, $payload);
    }

    /**
     * Handle 'Text to Image' action.
     */
    public function handleTextToImage(array $payload)
    {
        return $this->sendApiRequest($this->appIntegrationUrlKey::TEXT_TO_IMAGE_URL, $payload);
    }

    /**
     * Handle 'Sketch to Image' action.
     */
    public function handleSketchToImage(array $payload)
    {
        $fileRealPath                  = $this->getFileRealPath($payload["image_file"]);
        $payload["file_original_name"] = $payload["image_file"]->getClientOriginalName();
        $payload["filePath"]           = $fileRealPath;

        if(photoStudioSketchToImage($payload["action"])) {
            $payload["sketch_file"] = $payload["image_file"];
        }

        return $this->sendApiRequest($this->appIntegrationUrlKey::SKETCH_TO_IMAGE_URL, $payload);
    }

    /**
     * Handle 'Upscale' action.
     */
    public function handleUpscale(array $payload)
    {
        $fileRealPath                  = $this->getFileRealPath($payload["image_file"]);
        $base64EncodedFile             = $this->getBase64EncodedFile($fileRealPath);
        $payload["file_original_name"] = $payload["image_file"]->getClientOriginalName();
        $payload["filePath"]           = $fileRealPath;



        return $this->sendApiRequest($this->appIntegrationUrlKey::UPSCALE_URL, $payload);
    }

    public function unsetUnWantedKeys(
        array $payload,
        array $unwantedKeys
    )
    {
        foreach ($unwantedKeys as $key) {
            unset($payload[$key]);
        }

        return $payload;
    }

    /**
     * Send API request to ClipDrop.
     *
     * @param string $endpoint
     * @param array $payload
     * @return mixed
     */
    private function sendApiRequest(string $endpoint, array $payload)
    {
        $appStatic       = appStatic();
        $fileName        = "image_file";

        $isPhotoStudioText2ImageAction = photoStudioTextToImage($payload["action"]);

        $dataArr = ["prompt" => $payload["prompt"] ?? null];


        if(!$isPhotoStudioText2ImageAction) {
            $fileGetContents = file_get_contents($payload["filePath"]);
            $originalName    = $payload["file_original_name"];

            if(isset($payload["sketch_file"])) {
                $fileName               = "sketch_file";
                $payload["sketch_file"] = $payload["image_file"];
            }
        }

        $bodyParamsRequiredActions = [
            $appStatic::PHOTO_STUDIO_REPLACE_BACKGROUND,
            $appStatic::PHOTO_STUDIO_TEXT_TO_IMAGE,
            $appStatic::PHOTO_STUDIO_SKETCH_TO_IMAGE,
            $appStatic::PHOTO_STUDIO_UPSCALE,
        ];

        $clipDropApiKey = $this->appIntegrationUrlKey->getClipDropApiKey();

        // When action is not sketch to image
        if(in_array($payload["action"], $bodyParamsRequiredActions)) {

            // When action is Text to Image
            if($isPhotoStudioText2ImageAction) {


                $response = Http::withHeaders([
                    'x-api-key' => $clipDropApiKey,
                ])->asMultipart()->post($endpoint, $dataArr);
            }else{
                $response = Http::withHeaders([
                    'x-api-key' => $clipDropApiKey,
                ])->attach(
                    $fileName,
                    $fileGetContents,
                    $originalName
                )->post($endpoint, $dataArr);
            }
        }
        else{
            $response = Http::withHeaders([
                'x-api-key' => $clipDropApiKey,
            ])->attach(
                $fileName,
                $fileGetContents,
                $originalName
            )->post($endpoint);
        }

        switch ($response->status()) {
            case 200:
                // Success
                return $response->body();

            case 400:
                // Bad Request
                throw new \Exception('ClipDrop API Error (400): Request is malformed or incomplete. Possible causes: 
                - Missing image_file in request
                - Input image format is not valid
                - Image resolution is too big.');

            case 401:
                // Unauthorized
                throw new \Exception('ClipDrop API Error (401): Missing API key.');

            case 402:
                // No Credit Left
                throw new \Exception('Your account has no remaining credits, you can buy more in your account page.',402);

            case 403:
                // API Key Revoked
                throw new \Exception('Invalid or revocated api key.',403);

            case 429:
                // Too Many Requests
                throw new \Exception('Too many requests, blocked by the rate limiter.
You should space out your requests in time or contact us to increase your quota.',429);
            case 500:
                // ClipDrop Internal Server Error
                throw new \Exception('This may be a bug on our side.
Please contact us at contact@clipdrop.co so that we can investigate.',500);

            default:
                // Other errors
                throw new \Exception('ClipDrop API Error (' . $response->status() . '): ' . $response->body());
        }
    }

    public function saveGeneratedBase64EncodedImage($encodedFile,$action)
    {
        // Action Prefix Ex: Reimagine
        $actionPrefix = slugMaker($this->getActionPrefixByAction($action), true);

        // Dir preparing to upload
        $uploadDir = fileService()::DIR_CLIPDROP."/{$actionPrefix}/";

        // Directory creating if not exists.
        createDynamicDir(public_path($uploadDir));

        // Generate File Name
        $fileName = $this->getClipDropFileName($action);

        // Destination of the file
        $uploadingDirName = "{$uploadDir}/{$fileName}";
        $finalDestination  = public_path($uploadingDirName);

        $this->saveBase64EncodedFile($encodedFile, $finalDestination);

        return $uploadingDirName;
    }

    public function getClipDropFileName($action): string
    {
        $actionPrefix = slugMaker($this->getActionPrefixByAction($action), true);

        return "{$actionPrefix}_clip_drop_" .Date("Y-m-d")."_".time()."_".randomStringNumberGenerator(6,true,true).".jpg";
    }

    public function getActionPrefixByAction($action)
    {
        return appStatic()::PHOTO_STUDIO_ACTION_ARR[$action] ?? "not_found";
    }

    public function saveGeneratedImage($imageFilePath, array $payloads, $userId)
    {
        $actionPrefix = $this->getActionPrefixByAction($payloads["action"]);
        $title        = "Clip-drop {$actionPrefix}";

        $data = [
            "title"                 => $title,
            "slug"                  => slugMaker($title),
            "model_name"            => $title,
            "prompt"                => $payloads["prompt"] ?? null,
            "generated_image_path"  => $imageFilePath,
            "file_path"             => $imageFilePath,
            "article_content_type"  => appStatic()::PURPOSE_REIMAGINE,
            "content_type"          => $title,
            "platform"              => 6, //TODO: Change to 6 for ClipDrop
            "user_id"               => $userId
        ];

        return GeneratedImage::query()->create($data);
    }
}
