<?php

namespace App\Services\ElevenLab;

use App\Traits\Api\ApiResponseTrait;
use App\Services\Core\ElevenLabsCore;
use App\Services\Core\AiConfigService;
use Illuminate\Support\Facades\Storage;

/**
 * Class ElevenLabService.
 */
class ElevenLabsService
{
    use ApiResponseTrait;

    public $elevenLabsKey;
    public function __construct()
    {
        $this->elevenLabsKey = elevenLabsKey();
    }

    public function initElevenLabs(): ElevenLabsCore
    {
        return new ElevenLabsCore($this->elevenLabsKey);
    }
    public function generateTextToSpeech($request)
    {
        $voice_id        = $request->voice;  
        $aiConfigService = new AiConfigService();
        $platform        = $aiConfigService->setPlatForm(appStatic()::ENGINE_ELEVEN_LAB);
        $aiConfig        = $aiConfigService->setConfiguration($platform, appStatic()::PURPOSE_TEXT_TO_VOICE);
        
        $opts            = [
            'model'      => $request->model,
        ];

        $opts       += $aiConfig;
        $elevenLabs  = $this->initElevenLabs();
        $tts         = $elevenLabs->tts($opts, $voice_id);
        
        # Name and extension of the result audio file
        $name      = str_replace(' ', '_', strtolower(user()->name)).randomStringNumberGenerator(10);
        $file_name = $name .'.'. fileExtension('mp3');
       
        Storage::disk('audio')->put($file_name, $tts);
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
    public function setUpData(): array
    {
        $data                        = [];       
        $elevenLabs                  = $this->initElevenLabs();
        $data['user_info']           = json_decode($elevenLabs->userInfo());     
        $data['eleven_labs_models']  = json_decode($elevenLabs->models());   
        $data['eleven_labs_voices']  = json_decode($elevenLabs->voices());   
        $data['defaultVoiceSetting'] = json_decode($elevenLabs->defaultVoiceSetting());       
        return $data;
    }
}
