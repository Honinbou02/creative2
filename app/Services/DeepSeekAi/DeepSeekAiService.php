<?php

namespace App\Services\DeepSeekAi;

use Illuminate\Support\Facades\Log;
use App\Traits\Api\ApiResponseTrait;
use App\Traits\File\FileUploadTrait;
use App\Services\AiData\AiDataService;
use App\Services\Core\AiConfigService;
use App\Services\Prompt\PromptService;
use DeepSeek\DeepSeekClient;

class DeepSeekAiService
{
    use ApiResponseTrait;
    use FileUploadTrait;

    public function initDeepseekAi()
    {
        
        return app(DeepSeekClient::class);
    }

    /**
     * @incomingParams $request is a request object
     * @incomingParams $platform will receive a string value deepseekAi
     * */
    public function contentGenerator($request, $platform)
    {
        return $request->has("stream") && $request->stream ? $this->streamCompletion($request, $platform) : $this->rawCompletion($request, $platform);
    }


    /**
     * @throws \Throwable
     * @throws \JsonException
     */
    public function rawCompletion($request, $platform)
    {
        $aiConfigService = new AiConfigService();
        $usingModel      = $aiConfigService->getModelBasedOnPurpose($request->content_purpose);
        $prompt          = (new PromptService())->setPrompt($request->content_purpose, $platform);
        $deepseek        = $this->initDeepseekAi();
        // Another way, with customization
        $result = $deepseek
                ->query($prompt, 'user')
                ->withModel("deepseek-chat")
                ->setTemperature($request->temperature ? (double) $request->temperature : 1.5)
                ->run();
        $decodedResult = $this->deepseekAiUsage(json_decode($result));
        /**
         * Save Data into Generated Contents
         * */
        $generatedContent = (new AiDataService())->storeGeneratedContents($decodedResult, $prompt, $request, $this->setPlatform($platform), $usingModel);

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
        $usingModel      = $aiConfigService->getModelBasedOnPurpose($request->content_purpose);
        wLog("usingModel = ".$usingModel, [], \logService()::LOG_OPEN_AI);

        $contentPurpose  = $request->content_purpose;
        $prompt          = (new PromptService())->setPrompt($contentPurpose);
        $platform        = $aiConfigService->setPlatForm($platform);

        wLog("Prompt = ", [$prompt], \logService()::LOG_OPEN_AI);

        // Set prompt in session based on content purpose
        $aiConfigService->setPromptInSession($prompt, $contentPurpose);

        
        $deepseek   = $this->initDeepseekAi();

        return response()->stream(function () use ($deepseek, $request, $contentPurpose, $prompt, $aiConfigService, $usingModel) {
            $text = '';
        
            // Initialize the Deepseek stream
            $data = $deepseek
                ->query($prompt, 'user')
                ->withModel($usingModel)
                ->withStream(true)
                ->setTemperature($request->temperature ? (double) $request->temperature : 1.5)
                ->run();
                
                $chatResponse = explode("data: ", $data);
                if (!empty($chatResponse)) {
                    foreach ($chatResponse as $singleData) {
                        if (!empty($singleData)) {
                            $streamData = $singleData;
                            $singleData = json_decode(trim($singleData), true);

                            if (isset($singleData["choices"][0]["delta"]["content"])) {
                                $streamContent = $singleData["choices"][0]["delta"]["content"];
                                $text         .= $streamContent;
                                
                                file_put_contents('stream_response_deepseek.txt', $streamContent, FILE_APPEND);
                                if ($streamContent) {
                                    echo "data: {$streamData} \n\n";
                                    ob_flush();
                                    flush();
                                }
            
                                // sleep(1);

                                $aiConfigService->setCompletionDataInSession($text ?? ' ' , $contentPurpose);
                                
                            }
                        }
                    }
                }

            // Log the final text (optional)
            wLog("Deepseek AI Text = ", [$text], \logService()::LOG_OPEN_AI);
        
            // Indicate the end of the stream
            echo "data: [DONE]\n\n";
            ob_flush();
            flush();

        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type'  => 'text/event-stream',
            'Connection'    => 'keep-alive',
        ]);
    }




    /**
     * 1 => "DeepseekAi",
     * 2 => "Stable Diffusion(SD)",
     * 3 => "ElevenLabs",
     * 4 => "Azure TTS",
     * 5 => "Google TTS"
     * 8 => "CLAUDE AI"
     * 9 => "DeepSeek AI"
     * */
    public function setPlatform(string $platform): int
    {
        return (new AiConfigService())->setPlatForm($platform);
    }


    /**
     * @incomingParams $result received from CLAUDE API Response
     *
     * */
    public function processResponse($decodedResult)
    {
        // removed the code - by shohan

        // default true;
        return true;
    }


    /**
     * @throws \Throwable
     */
    public function deepseekAiExceptionThrow($message)
    {
        info("I am from DeepseekAi Exception Throw. Message = {$message}");

        session([sessionLab()::SESSION_OPEN_AI_ERROR => $message]);

        throw_if(!is_null($message), new \Exception($message));
    }
 

    private function deepseekAiUsage($deepseekAiResponse)
    {
        $outputContents     = '';
        $result["usage"]    = [];

        $promptsToken       = $deepseekAiResponse?->usage->prompt_tokens;
        $completionToken    = $deepseekAiResponse?->usage->completion_tokens;

        $result["usage"]['prompt_tokens']       = $promptsToken;
        $result["usage"]['completion_tokens']   = $completionToken;
        $result["usage"]['total_tokens']        = $completionToken + $promptsToken;
        $result["text"]                         = $deepseekAiResponse?->choices[0]?->message->content;
        $result["deepseekAi"]                   = $outputContents;
        $result["row_response"]                 ='';

        return $result;
    }
    public function countTokens($text)
    {
        if(empty($text)) return 0; 
        $token    = count(explode(' ', $text));
        return $token;

    }
}
