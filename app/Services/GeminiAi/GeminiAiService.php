<?php

namespace App\Services\GeminiAi;

use Gemini;
use Illuminate\Support\Facades\Log;
use App\Traits\Api\ApiResponseTrait;
use App\Traits\File\FileUploadTrait;
use App\Services\AiData\AiDataService;
use App\Services\Core\AiConfigService;
use App\Services\Prompt\PromptService;
use Illuminate\Support\Facades\Storage;
use App\Services\Balance\BalanceService;

class GeminiAiService
{
    use ApiResponseTrait;
    use FileUploadTrait;
    public $geminiAiKey;
    public function __construct()
    {
        $this->geminiAiKey = geminiAiKey();
    }

    public function initGeminiAi()
    {
        return  Gemini::client(geminiAiKey());
    }

    /**
     * @incomingParams $request is a request object
     * @incomingParams $platform will receive a string value gemini
     * */
    public function contentGenerator($request, $platform)
    {
        // TODO :: For now raw completion. will use streamCompletion when we will receive stream = true as a request params
        return $request->has("stream") && $request->stream ? $this->streamCompletion($request, $platform) : $this->rawCompletion($request, $platform);
    }


    /**
     * @throws \Throwable
     * @throws \JsonException
     */
    public function rawCompletion($request, $platform)
    {

        $prompt        = (new PromptService())->setPrompt($request->content_purpose, $platform);
        $geminiAi      = $this->initGeminiAi();
        $result        = $geminiAi->geminiPro()->generateContent($prompt);
        $decodedResult = $this->geminiAiUsage($result, $prompt);
        $model         = "gemini-pro";
       
        /**
         * Save Data into Generated Contents
         * */
        $generatedContent = (new AiDataService())->storeGeneratedContents($decodedResult, $prompt, $request, $this->setPlatform($platform), $model);

        $purpose = $request->content_purpose;

        Log::info(aiEngine(). "- {$purpose} Generated Content is : " . json_encode($generatedContent, JSON_THROW_ON_ERROR));

        /**
         * Success Response
         **/
        return $generatedContent;
    }
    /**
     * @throws \JsonException
     */
    public function streamCompletion($request, $platform)
    {

        $aiConfigService = new AiConfigService();
        $geminiAi        = $this->initGeminiAi();
        $contentPurpose  = $request->content_purpose;
        $prompt          = (new PromptService())->setPrompt($contentPurpose);
        $platform        = $aiConfigService->setPlatForm($platform);

        wLog("Prompt = ", [$prompt], \logService()::LOG_OPEN_AI);

        // Set prompt in session based on content purpose
        $aiConfigService->setPromptInSession($prompt, $contentPurpose);

        if($contentPurpose == appStatic()::PURPOSE_VISION) {
            $opts = $aiConfigService->setConfiguration($platform, $contentPurpose, $prompt, []);    
        }else {
            $opts = $prompt;
        }

        return response()->stream(function () use ($geminiAi, $contentPurpose, $opts, $aiConfigService){
            $text = '';
            if($contentPurpose == appStatic()::PURPOSE_VISION){
                $result = $geminiAi->geminiFlash()->streamGenerateContent($opts);
            } else {
                $result = $geminiAi->geminiPro()->streamGenerateContent($opts);
            }
            file_put_contents('article_data_gemini.txt', $result, FILE_APPEND);

            foreach($result as $r){
                $text .= $r->text();
                $aiConfigService->setCompletionDataInSession($text ?? ' ' , $contentPurpose);
                $responseData = json_encode([
                    "choices" => [
                        [
                            "delta" => [
                                "content" => $r->text(),
                            ]
                        ]
                    ]
                ]);
                file_put_contents('article_text_gemini.txt', $r->text(), FILE_APPEND);

                if ($r->text()) {
                    echo "data: {$responseData} \n\n";
                    ob_flush();
                    flush();
                }

                sleep(1);
            }

            wLog("Gemini Text = ", [$text], \logService()::LOG_OPEN_AI);

            // Indicate the end of the stream
            echo "data: [DONE]\n\n";
            ob_flush();
            flush();

        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type'  => 'text/event-stream',
            'Connection'    => 'keep-alive'
        ]);
    }




    /**
     * 1 => "GeminiAi",
     * 2 => "Stable Diffusion(SD)",
     * 3 => "ElevenLabs",
     * 4 => "Azure TTS",
     * 5 => "Google TTS"
     * */
    public function setPlatform(string $platform): int
    {
        return (new AiConfigService())->setPlatForm($platform);
    }


    /**
     * @incomingParams $result received from Gemini AI API Response
     *
     * */
    public function processResponse($decodedResult)
    {
        /**
         * Is Gemini AI Thrown any Exception
         * */
        $isGeminiAiRaiseError = isGeminiAiRaiseError($decodedResult);

        /**
         * isGeminiAiRaiseError helper function will return false either string.
         * Here false means there has no error exception from Gemini AI.
         * Either Throw the Exception to the user.
         *
         * */
        if (is_string($isGeminiAiRaiseError)) {
            return $this->geminiAiExceptionThrow($isGeminiAiRaiseError);
        }

        return true;
    }


    /**
     * @throws \Throwable
     */
    public function geminiAiExceptionThrow($message)
    {
        info("I am from GeminiAi Exception Throw. Message = {$message}");

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



    /**
     * @throws \JsonException
     */
    public function generateTextToSpeech($request)
    {
        $geminiAi          = $this->initGeminiAi();
        $aiConfigService = new AiConfigService();
        $platform        = $aiConfigService->setPlatForm(appStatic()::ENGINE_OPEN_AI);
        $aiConfig        = $aiConfigService->setConfiguration($platform, $request->model);
        $opts            = [
            'model'      => $request->model,
        ];

        $opts   += $aiConfig;
        $tts    =  $geminiAi->tts($opts);
        $decodedResult  = convertJsonDecode($tts);

        wLog("{$request->content_purpose} = Gemini AI Response Text to Speech", $decodedResult, \logService()::LOG_OPEN_AI);

        /**
         * Check is Gemini AI raise an error.
         * If yes, then throw the exception
         *
         * Either Continue execution.
         * */
        $isErrorFree = $this->processResponse($decodedResult);
        # Name and extension of the result audio file
        // name
        $name = str_replace(' ', '_', strtolower(user()->name)) . randomStringNumberGenerator(10);

        $file_name = $name . '.' . fileExtension($request->response_format);

        Storage::disk('audio')->put($file_name, $tts);
        $file_path = 'voice/audio/' . $file_name;

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
        $generatedContent = (new AiDataService())->storeGeneratedContentForTextToSpeech($data, $request, $this->setPlatform($platform), $request->model);

        //TODO::User Balance Update
        (new BalanceService())->balanceUpdate($generatedContent);

        /**
         * Success Response
         **/
        return $generatedContent;
    }
    public function generateAudio2Text($request)
    {
        $geminiAi          = $this->initGeminiAi();
        $aiConfigService = new AiConfigService();
        $usingModel     = $aiConfigService->getModelBasedOnPurpose(appStatic()::PURPOSE_VOICE_TO_TEXT);
        $platform        = $aiConfigService->setPlatForm(appStatic()::ENGINE_OPEN_AI);

        $audio = $request->file('audio');
        $filePath = $this->fileProcess($audio, fileService()::DIR_S2T);
        $audioPath = public_path($filePath);

        $file = curl_file_create($audioPath);

        $opts            = [
            'model' => $usingModel,
            'file'  => $file,
        ];

        $result    =  $geminiAi->transcribe($opts);
        fileDelete($filePath);

        $decodedResult  = convertJsonDecode($result);

        /**
         * Save Data into Generated Contents
         * */
        $generatedContent = (new AiDataService())->storeGeneratedContents($decodedResult, $prompt = 'speech to text', $request, $this->setPlatform($platform), $usingModel);

        //TODO::User Balance Update

        /**
         * Success Response
         **/
        return $generatedContent;
    }

    private function geminiAiUsage($geminiAiResponse, $prompt)
    {
        $outputContents     = '';
        $result["usage"]    = [];           
        $promptsToken       = $this->countTokens($prompt);
        $completionToken    = $this->countTokens($geminiAiResponse->text());
        $result["usage"][]  = $promptsToken;
        $result["usage"][]  = $completionToken;
        $result["usage"][]  = $completionToken + $promptsToken;
        $result["text"]     = $geminiAiResponse->text();
        $result["geminiAi"] = $outputContents;
        $result["row_response"] ='';

        return $result;
    }
    public function countTokens($text)
    {
        if(empty($text)) return 0;
        $geminiAi = $this->initGeminiAi();
        $token    = $geminiAi->geminiPro()->countTokens($text);
        return $token->totalTokens;

    }
}
