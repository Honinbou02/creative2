<?php

namespace App\Services\ClaudeAi;

use Anthropic\Laravel\Facades\Anthropic;
use Illuminate\Support\Facades\Log;
use App\Traits\Api\ApiResponseTrait;
use App\Traits\File\FileUploadTrait;
use App\Services\AiData\AiDataService;
use App\Services\Core\AiConfigService;
use App\Services\Prompt\PromptService;

class ClaudeAiService
{
    use ApiResponseTrait;
    use FileUploadTrait;

    public function initClaudeAi()
    {
    }

    /**
     * @incomingParams $request is a request object
     * @incomingParams $platform will receive a string value claudeAi
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
        $prompt        = (new PromptService())->setPrompt($request->content_purpose, $platform);
        $result        = Anthropic::messages()->create([
                            'model'     => $usingModel,
                            'max_tokens' => 4096,
                            'messages' => [
                                ['role' => 'user', 'content' => $prompt],
                            ],
                        ]);
        $decodedResult = $this->claudeAiUsage($result);
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

        return response()->stream(function () use ($contentPurpose, $prompt, $aiConfigService, $usingModel){
            $text = '';

            $stream  = Anthropic::messages()->createStreamed([
                'model' => $usingModel,
                'max_tokens' => request()->max_tokens ?? 4096,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);
            
            file_put_contents('template_data_claude.txt', $stream, FILE_APPEND);

            foreach($stream as $response){
                $result = $response->toArray();
                if ($result['type'] === 'content_block_delta') {
                    $textData = $result['delta']['text'] ?? '';

                    $text .= $textData;
                    $aiConfigService->setCompletionDataInSession($text ?? ' ' , $contentPurpose);
                    $responseData = json_encode([
                        "choices" => [
                            [
                                "delta" => [
                                    "content" => $textData,
                                ]
                            ]
                        ]
                    ]);
                    file_put_contents('template_text_claude.txt', $textData, FILE_APPEND);

                    echo "data: {$responseData} \n\n";
                    ob_flush();
                    flush();
                }
            }
            wLog("Claude AI Text = ", [$text], \logService()::LOG_OPEN_AI);

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
     * 1 => "ClaudeAi",
     * 2 => "Stable Diffusion(SD)",
     * 3 => "ElevenLabs",
     * 4 => "Azure TTS",
     * 5 => "Google TTS"
     * 8 => "CLAUDE AI"
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
    public function claudeAiExceptionThrow($message)
    {
        info("I am from ClaudeAi Exception Throw. Message = {$message}");

        session([sessionLab()::SESSION_OPEN_AI_ERROR => $message]);

        throw_if(!is_null($message), new \Exception($message));
    }
 

    private function claudeAiUsage($claudeAiResponse)
    {
        $outputContents     = '';
        $result["usage"]    = [];

        $promptsToken       = $claudeAiResponse->usage->inputTokens;
        $completionToken    = $claudeAiResponse->usage->outputTokens;

        $result["usage"]['prompt_tokens']       = $promptsToken;
        $result["usage"]['completion_tokens']   = $completionToken;
        $result["usage"]['total_tokens']        = $completionToken + $promptsToken;
        $result["text"]                         = $claudeAiResponse->content[0]->text;
        $result["claudeAi"]                     = $outputContents;
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
