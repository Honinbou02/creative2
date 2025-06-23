<?php

namespace App\Services\Google;

use App\Services\Core\GoogleCore;
use App\Services\Core\AiConfigService;
use App\Traits\Language\LanguageTrait;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Illuminate\Support\Facades\Log;

/**
 * Class GoogleService.
 */
class GoogleService
{
    use LanguageTrait;
    protected $access_key;

    public function __construct()
    {
        $this->access_key = googleAccessKey();
    }

    public function initGoogle()
    {
        return new GoogleCore($this->access_key);
    }
    public function generateTextToSpeech($request)
    {
        $aiConfigService = new AiConfigService();
        $platform        = $aiConfigService->setPlatForm(appStatic()::ENGINE_GOOGLE_TTS);
        $aiConfig        = $aiConfigService->setConfiguration($platform, appStatic()::PURPOSE_TEXT_TO_VOICE);
        $google          = $this->initGoogle();
        $tts             = $google->textToSpeech($aiConfig);
        $tts             = json_decode($tts);
        Log::info("Something", [$tts]);
        // Alternative Way of Storing Audio to a File
        $audioContent = base64_decode($tts['audioContent']);

        # Name and extension of the result audio file
        $name      = str_replace(' ', '_', strtolower(user()->name)) . randomStringNumberGenerator(10);
        $file_name = $name . '.' . fileExtension('mp3');

        Storage::disk('audio')->put($file_name, $audioContent);
        file_put_contents($file_name, $audioContent);
        $file_path = 'voice/audio/'.$file_name;
        if (activeStorage('aws')) {
            Storage::disk('s3')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
            $file_path  = Storage::disk('s3')->url($file_name);
            Storage::disk('audio')->delete($file_name);
        }
        $data['file_path'] = $file_path;
        $data['audioName'] = $file_name;
        return $data; 
    }
    public function setUpData():array
    {
        $data['google_languages']        = $this->googleLanguageList();
        $data['google_languages_voices'] = $this->googleVoiceDetails();
        return $data;
    }
}
