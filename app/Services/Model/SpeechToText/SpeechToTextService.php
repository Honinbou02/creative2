<?php

namespace App\Services\Model\SpeechToText;

use App\Models\TextToSpeech;
use App\Models\GeneratedContent;
use App\Services\Azure\AzureService;
use App\Services\AiData\AiDataService;
use App\Services\Google\GoogleService;
use App\Traits\Language\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use App\Services\ElevenLab\ElevenLabsService;
use App\Services\Integration\IntegrationService;
use App\Services\Model\GeneratedContent\GeneratedContentService;

/**
 * Class TextToSpeechService.
 */
class SpeechToTextService
{
    use LanguageTrait;
    public function getData()
    {
        $request = request()->merge([
            'content_type'=>appStatic()::PURPOSE_VOICE_TO_TEXT
        ]);
        $data = [];
        $data['list'] = (new GeneratedContentService())->getAll();
        return $data;
    }

}
 