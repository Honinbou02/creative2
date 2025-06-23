<?php

namespace App\Services\Integration;

/**
 * Class IntegrationService.
 */

use App\Services\Azure\AzureService;
use App\Services\ClaudeAi\ClaudeAiService;
use App\Services\DeepSeekAi\DeepSeekAiService;
use App\Services\Google\GoogleService;
use App\Services\OpenAi\OpenAiService;
use App\Services\GeminiAi\GeminiAiService;
use App\Services\Gowinston\GowinstonService;
use App\Services\ElevenLab\ElevenLabsService;
use App\Services\StableDiffusion\StableDiffusionService;

class IntegrationService
{
    /**
     * @incomingParams $connectType will receive a string value
     *
     * $connectType will contain "openai", "azure","googleTTS","elevenLabs", "geminiai, claudeai, deepseekai"
     * */
    public function contentGenerator($connectType, $request)
    {
        $appStatic = appStatic();
        session([sessionLab()::SESSION_CONNECT_TYPE => $connectType]);
        return match ($connectType){
            $appStatic::ENGINE_OPEN_AI      => (new OpenAiService())->contentGenerator($request, $connectType),
            $appStatic::ENGINE_GEMINI_AI    => (new GeminiAiService())->contentGenerator($request, $connectType),
            $appStatic::ENGINE_CLAUDE_AI    => (new ClaudeAiService())->contentGenerator($request, $connectType),
            $appStatic::ENGINE_DEEPSEEK_AI  => (new DeepSeekAiService())->contentGenerator($request, $connectType),
            $appStatic::ENGINE_GOWINSTON_AI => (new GowinstonService())->scanContent($request, $connectType),
        };
    }


    public function voiceGenerator($connectType, $request)
    {
        $appStatic = appStatic();

        return match ($connectType){
            $appStatic::ENGINE_OPEN_AI          => (new OpenAiService())->generateTextToSpeech($request),
            $appStatic::ENGINE_AZURE            => (new AzureService())->generateTextToSpeech($request),
            $appStatic::ENGINE_GOOGLE_TTS       => (new GoogleService())->generateTextToSpeech($request),
            $appStatic::ENGINE_ELEVEN_LAB       => (new ElevenLabsService())->generateTextToSpeech($request),
        };
    }
    public function audio2TextGenerator($connectType, $request)
    {
        $appStatic = appStatic();
        return match ($connectType){
            $appStatic::ENGINE_OPEN_AI          => (new OpenAiService())->generateAudio2Text($request),
        };
    }


    public function imageGenerator($connectType, $request)
    {
        $appStatic = appStatic();

        return match ($connectType){
            $appStatic::ENGINE_OPEN_AI          => (new OpenAiService())->imageGenerate($request,$connectType),
            $appStatic::ENGINE_STABLE_DIFFUSION => (new StableDiffusionService())->generateContent($request),
        };
    }


    public function setPlatform(string $platForm)
    {
        return match ($platForm){
            appStatic()::ENGINE_OPEN_AI          => 1,
            appStatic()::ENGINE_STABLE_DIFFUSION => 2,
        };
    }

    /**
     * @incomingParams $contentType will receive a string value
     *
     * @incomingParam $contentType will contain "stable-diffusion", "clip-drop"
     * */
    public function generateVideo($contentType, $request)
    {
        $appStatic = appStatic();

        return match($contentType){
            $appStatic::ENGINE_STABLE_DIFFUSION => (new StableDiffusionService())->generateVideo($request),
        };
    }
    /**
     * @incomingParams $contentType will receive a string value
     *
     * @incomingParam $contentType will contain "stable-diffusion", "clip-drop"
     * */
    public function prepareVideo($contentType, $request)
    {
        $appStatic    = appStatic();
        $generationId = $request->generationId;
        return match($contentType){
            $appStatic::ENGINE_STABLE_DIFFUSION => (new StableDiffusionService())->prepareVideo($generationId),
        };
    }

}
