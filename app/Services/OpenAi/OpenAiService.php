<?php

namespace App\Services\OpenAi;

use App\Services\Core\OpenAiCore;
use App\Traits\Api\ApiResponseTrait;
use App\Traits\File\FileUploadTrait;
use App\Services\AiData\AiDataService;
use App\Services\Core\AiConfigService;
use App\Services\Prompt\PromptService;
use Illuminate\Support\Facades\Storage;
use App\Services\Balance\BalanceService;

/**
 * Class OpenAiService.
 */
class OpenAiService
{
    use ApiResponseTrait;
    use FileUploadTrait;
    public $openAiKey;
    public function __construct()
    {
        $this->openAiKey = openAiKey();
    }

    public function rawPlayground(
        $purpose,
        $prompt,
        $model,
        $numberOfResults
    )
    {
        $aiConfigService = new AiConfigService();

        $openAi = $this->initOpenAi();

        $opts = [
            "model" => $model,
        ];

        $opts+= $aiConfigService->setConfiguration(1, $purpose, $prompt);

        $opts['n'] =  (int) $numberOfResults;

        $result         =  $openAi->chat($opts);
        $decodedResult  = convertJsonDecode($result);

        wLog("{$purpose} = Open AI Response Decoded Result", $decodedResult, \logService()::LOG_OPEN_AI);

        return $decodedResult;
    }

    public function initOpenAi(): OpenAiCore
    {
        return new OpenAiCore($this->openAiKey);
    }

    /**
     * @incomingParams $request is a request object
     * @incomingParams $platform will receive a string value openai/gemini
     * */
    public function contentGenerator($request, $platform)
    {
        // TODO :: For now raw completion. will use streamCompletion when we will receive stream = true as a request params
        return $request->has("stream") && $request->stream ? $this->streamCompletion($request, $platform) : $this->rawCompletion($request, $platform);
    }

    /**
     * @throws \JsonException
     * @throws \Throwable
     */
    public function rawCompletion($request, $platform): \Illuminate\Database\Eloquent\Model
    {
        $aiConfigService = new AiConfigService();

        $openAi     = $this->initOpenAi();
        $prompt     = (new PromptService())->setPrompt($request->content_purpose);
        $usingModel = $aiConfigService->getModelBasedOnPurpose($request->content_purpose);

        $opts = [
            "model" => $usingModel,
        ];

        $platform = $aiConfigService->setPlatForm($platform);

        $opts+= $aiConfigService->setConfiguration($platform, $request->content_purpose, $prompt);
        info("Raw Completion Final OPTS : ".json_encode($opts));

        $numberOfResults = 1;
        /**
         * Set Number of results
         * */
        if($request->has("number_of_results") && $request->number_of_results >= 2 ) {
            $numberOfResults = $request->number_of_results;
        }

        $opts['n'] =  (int) $numberOfResults;

        $result         =  $openAi->chat($opts);
        $decodedResult  = convertJsonDecode($result);
     
        wLog("{$request->content_purpose} = Open AI Response Decoded Result", $decodedResult, \logService()::LOG_OPEN_AI);

        /**
         * Check is Open ai raise an error.
         * If yes, then throw the exception
         *
         * Either Continue execution.
         * */
        $isErrorFree = $this->processResponse($decodedResult);

        /**
         * Save Data into Generated Contents
         * */
        return (new AiDataService())->storeGeneratedContents($decodedResult, $prompt, $request, $this->setPlatform($platform), $usingModel);
    }


    /**
     * @throws \JsonException
     */
    public function streamCompletion($request, $platform)
    {
        $contentPurpose  = $request->content_purpose;

        $aiConfigService = new AiConfigService();
        $platform        = $aiConfigService->setPlatForm($platform);
        $openAi          = $this->initOpenAi();
        $prompt          = (new PromptService())->setPrompt($contentPurpose);
        wLog(
            "prompt: ",
            ["text" => $prompt],
            \logService()::LOG_OPEN_AI
        );


        // Set prompt in session based on content purpose
        $aiConfigService->setPromptInSession($prompt, $contentPurpose);

        $usingModel = $aiConfigService->getModelBasedOnPurpose($contentPurpose);

        $opts = [
            "model" => $usingModel,
        ];

        $optional['temperature'] = (float)$request->creativity ?? 1;
        $optional['max_tokens']  = (int) $request->max_tokens ?? -1;
        $optional['max_completion_tokens']  = (int) $request->max_tokens ?? -1;

        $opts += $aiConfigService->setConfiguration($platform, $contentPurpose, $prompt, [], $optional);
        // info(currentRoute()." : Stream Completion Config : ".json_encode($opts));
        $streamNo = 0;

        return response()->stream(function () use ($openAi, $opts, $prompt, $aiConfigService, $contentPurpose, $streamNo) {
            $text = "";

            $openAi->chat($opts, function ($curl_info, $data) use (&$text, $aiConfigService, $contentPurpose, $streamNo) {
                file_put_contents('article_data.txt', $data, FILE_APPEND);

                if ($obj = json_decode($data) and $obj->error->message != "") {                  
                    session([sessionLab()::SESSION_OPEN_AI_ERROR => json_encode($obj->error->message)]);
                    session()->save();
                }else{
                    $chatResponse = explode("data:", $data);
                    file_put_contents('article_response.json', $chatResponse, FILE_APPEND);

                    if (!empty($chatResponse)) {
                        foreach ($chatResponse as $singleData) {
                            if (!empty($singleData)) {
                                $singleData = json_decode(trim($singleData), true);
    
                                if (isset($singleData["choices"][0]["delta"]["content"])) {
                                    $streamContent = $singleData["choices"][0]["delta"]["content"];
                                    $text         .= $streamContent;
                                    
                                    file_put_contents('article_text.txt', $streamContent, FILE_APPEND);

                                    $aiConfigService->setCompletionDataInSession($text ?? ' ' , $contentPurpose);
                                }
                            }
                        }
                    }
                }

                wLog("Article OpenAi = ", [$text], \logService()::LOG_OPEN_AI);
                echo $data;
                echo "\n\n";
                echo PHP_EOL;

                if (ob_get_level() < 1) {
                    ob_start();
                }

                ob_flush();
                flush();
                return strlen($data);
            });
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
        ]);
    }


    /**
     * 1 => "OpenAi",
     * 2 => "Stable Diffusion(SD)",
     * 3 => "ElevenLabs",
     * 4 => "Azure TTS",
     * 5 => "Google TTS"
     * */
    public function setPlatform(string $platform) : int
    {
        return (new AiConfigService())->setPlatForm($platform);
    }


    /**
     * @incomingParams $result received from Open AI API Response
     *
     * */
    public function processResponse($decodedResult)
    {
        /**
         * Is Open AI Thrown any Exception
         * */
        $isOpenAiRaiseError = isOpenAiRaiseError($decodedResult);

        /**
         * isOpenAiRaiseError helper function will return false either string.
         * Here false means there has no error exception from Open AI.
         * Either Throw the Exception to the user.
         *
         * */
        if (is_string($isOpenAiRaiseError)) {
            return $this->openAiExceptionThrow($isOpenAiRaiseError);
        }

        return true;
    }


    /**
     * @throws \Throwable
     */
    public function openAiExceptionThrow($message)
    {
         info("I am from OpenAi Exception Throw. Message = {$message}");

         session([sessionLab()::SESSION_OPEN_AI_ERROR => $message]);
     
         throw_if(!is_null($message), new \Exception($message));
   }

    public function getModelBasedOnPurpose($type)
    {
        return match ($type) {
            "code", "chat"                               => getSetting($type, appStatic()::OPEN_AI_CHAT_MODEL),
            "keywords", "titles", "outlines", "articles" => getSetting($type, appStatic()::OPEN_AI_ARTICLE_MODEL),
            "dall-e-2"                                   => getSetting($type, appStatic()::DALL_E_2),
            "dall-e-3"                                   => getSetting($type, appStatic()::DALL_E_3),
            default                                      => throw new \Exception("API AI Model Not Found"),
        };
    }


    public function imageGenerate($request, $contentPurpose)
    {
        //TODO:: Currently Dall-e-2 and Dall-e-3 are same code snippet. Because if there needs to update in future.
        // Image Generate with Dall-e-2
        if(isDallE2($request->content_purpose)){
            $images = $this->imageGenerateWithDallE2($request);
        }
        elseif(isDallE3($request->content_purpose)){
           $images = $this->imageGenerateWithDallE3($request);
        }
      
       return $images;
    }


    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function imageGenerateWithDallE2($request)
    {
        $aiConfigService = new AiConfigService();

        $contentPurpose = $request->content_purpose;
        $openAi         = $this->initOpenAi();
        $platform       = $aiConfigService->setPlatform(appStatic()::ENGINE_OPEN_AI);
        $prompt         = $request->ai_image_prompt ?? (new PromptService())->setPrompt($contentPurpose);
        $usingModel     = $aiConfigService->getModelBasedOnPurpose($contentPurpose);

        $opts = [
            "model" => $usingModel,
        ];

        $opts+= $aiConfigService->setConfiguration($platform, $contentPurpose, $prompt);
        $result = $openAi->image($opts);

        $decodedResult  = convertJsonDecode($result);
        wLog("{$request->content_purpose} =Dall-e-2 Open AI Response Decoded Result", $decodedResult, \logService()::LOG_OPEN_AI);

        /**
         * Check is Open AI raise an error.
         * If yes, then throw the exception
         *
         * Either Continue execution.
         * */
        $isErrorFree = $this->processResponse($decodedResult);


        // Save Data into Generated Images
        $data = (new AiDataService())->saveGeneratedImage($decodedResult, $prompt, $request, $platform, $usingModel);
       
        info("Data received from saveGeneratedImage ".json_encode($data));

        return $data;
    }

    
    /**
     * @throws \JsonException
     */
    public function imageGenerateWithDallE3($request)
    {
        $aiConfigService = new AiConfigService();

        $contentPurpose = $request->content_purpose;
        $openAi         = $this->initOpenAi();
        $platform       = $aiConfigService->setPlatForm(appStatic()::ENGINE_OPEN_AI);
        $prompt         = $request->ai_image_prompt ?? (new PromptService())->setPrompt($contentPurpose);
        $usingModel     = $aiConfigService->getModelBasedOnPurpose($contentPurpose);

        $opts = [
            "model" => $usingModel,
        ];

        $opts+= $aiConfigService->setConfiguration($platform, $contentPurpose, $prompt);

        info("Dall-e-3 Platform : ".$platform);
        info("Dall-e-3 Prompt : ".$prompt);
        info("Dall-e-3 Model : ".$usingModel);
        info("Dall-e-3 Options : ".json_encode($opts));

        $result = $openAi->image($opts);

        $decodedResult  = convertJsonDecode($result);
        wLog("{$request->content_purpose} =Dall-e-3 Open AI Response Decoded Result", $decodedResult, \logService()::LOG_OPEN_AI);

        /**
         * Check is Open AI raise an error.
         * If yes, then throw the exception
         *
         * Either Continue execution.
         * */
        $isErrorFree = $this->processResponse($decodedResult);


        // Save Data into Generated Images
        return (new AiDataService())->saveGeneratedImage($decodedResult, $prompt, $request, $platform, $usingModel);
    }
     /**
     * @throws \JsonException
     */
    public function generateTextToSpeech($request)
    {
        $openAi          = $this->initOpenAi();
        $aiConfigService = new AiConfigService();
        $platform        = $aiConfigService->setPlatForm(appStatic()::ENGINE_OPEN_AI);
        $aiConfig        = $aiConfigService->setConfiguration($platform, $request->model);
        $opts            = [
            'model'      => $request->model,
        ];

        $opts   += $aiConfig;
        $tts    =  $openAi->tts($opts); 
        

        # Name and extension of the result audio file
        // name
        $name = str_replace(' ', '_', strtolower(user()->name)).randomStringNumberGenerator(10);

        $file_name = $name .'.'. fileExtension($request->response_format);

        Storage::disk('audio')->put($file_name, $tts);
        $file_path = 'voice/audio/'.$file_name;

        if (activeStorage('aws')) {
            Storage::disk('s3')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
            $file_path = Storage::disk('s3')->url($file_name);
            Storage::disk('audio')->delete($file_name);
        }
        
        $data['file_path'] = $file_path;
        $data['audioName'] = $file_name;        
        $data['platform']  = $platform;        

        /**
         * Save Data into Generated Contents
         * */
        $generatedContent = (new AiDataService())->storeGeneratedContentForTextToSpeech($data, $request, $this->setPlatform($platform),$request->model);

        //TODO::User Balance Update
        (new BalanceService())->balanceUpdate($generatedContent);

        /**
         * Success Response
         **/
        return $generatedContent;

    }
    public function generateAudio2Text($request)
    {
        $openAi          = $this->initOpenAi();
        $aiConfigService = new AiConfigService();
        $usingModel      = $aiConfigService->getModelBasedOnPurpose(appStatic()::PURPOSE_VOICE_TO_TEXT);
        $platform        = $aiConfigService->setPlatForm(appStatic()::ENGINE_OPEN_AI);

        $audio      = $request->file('audio');
        $filePath   = $this->fileProcess($audio, fileService()::DIR_S2T);
        $audioPath  = public_path($filePath);

        $file = curl_file_create($audioPath);

        $opts            = [
            'model' => $usingModel,
            'file'  => $file,
        ];

        $result    =  $openAi->transcribe($opts);      
        fileDelete($filePath);
 
        $decodedResult  = convertJsonDecode($result);

        $decodedResult = $this->whisperUsage($decodedResult);
        /**
         * Save Data into Generated Contents
         * */
        $generatedContent = (new AiDataService())->storeGeneratedContents($decodedResult, $prompt = 'speech to text', $request, $this->setPlatform($platform), $usingModel);

        //TODO::User Balance Update
        (new BalanceService())->balanceUpdate($generatedContent);
        /**
         * Success Response
         **/
        return $generatedContent;

    }
    private function whisperUsage($decodedResult)
    {
        $outputContents = '';       
        $result["usage"] = [];
        if (isset($decodedResult['text'])) {
            $outputContents = $decodedResult['text'];
            $outputContents = str_replace(["\r\n", "\r", "\n"], "<br/>", $outputContents);
            $promptsToken = 0;
            $completionToken = count(explode(' ', $decodedResult['text']));
            $result["usage"][] = $promptsToken;
            $result["usage"][] = $completionToken;
            $result["usage"][] = $completionToken;
        }
        $result["text"] = $outputContents;
        return $result;
    }
}
