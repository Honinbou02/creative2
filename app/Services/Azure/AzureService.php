<?php

namespace App\Services\Azure;

use App\Services\Core\AzureCore;
use Illuminate\Support\Facades\Log;
use App\Services\Core\AiConfigService;
use App\Traits\Language\LanguageTrait;
use Illuminate\Support\Facades\Storage;

/**
 * Class AzureService.
 */
class AzureService
{
    use LanguageTrait;
    protected $access_key;

    public function __construct()
    {
        $this->access_key = azureAccessKey();
    }

    public function initAzure():AzureCore
    {
        return new AzureCore($this->access_key);
    }

    public function generateTextToSpeechTest($request)
    {
        $lang           = 'en-US';
        $voice          = $request->voice;
        $format         = 'mp3';
        $data           = [];
        $wordCount      = 0;
        $langsAndVoices = [];
        $azureKey       = azureAccessKey();
        $azureRegion    = azureRegion();
        $azureEndpoint  = 'https://' . $azureRegion . '.tts.speech.microsoft.com/cognitiveservices/v1';

        # Audio Format

        if ($format == 'mp3') {
            $audio_type = 'audio/mpeg';
        } elseif ($format == 'wav') {
            $audio_type = 'audio/wav';
        } elseif ($format == 'ogg') {
            $audio_type = 'audio/ogg';
        } elseif ($format == 'webm') {
            $audio_type = 'audio/webm';
        }
        # Name and extension of the result audio file
        $name      = str_replace(' ', '_', strtolower(user()->name)) . randomStringNumberGenerator(10);
        $file_name = $name . '.' . fileExtension('mp3');

        $format = 'mp3';


        if ($format == 'mp3') {
            $output_format = 'audio-24khz-48kbitrate-mono-mp3';
        } elseif ($format == 'ogg') {
            $output_format = 'ogg-24khz-16bit-mono-opus';
        } elseif ($format == 'webm') {
            $output_format = 'webm-24khz-16bit-mono-opus';
        }

        $text       = 'text to speech';
        $wordCount  = strlen($text);

        $text = preg_replace("/\&/", "&amp;", $text);
        $text = preg_replace("/(^|(?<=\s))<((?=\s)|$)/i", "&lt;", $text);
        $text = preg_replace("/(^|(?<=\s))>((?=\s)|$)/i", "&gt;", $text);


        $ssml_text = '<speak version="1.0" xmlns="http://www.w3.org/2001/10/synthesis" xmlns:mstts="http://www.w3.org/2001/mstts" xmlns:emo="http://www.w3.org/2009/10/emotionml" xml:lang="' . $lang . '"><voice name="' . $voice . '">' . $text . '</voice></speak>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $azureEndpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Ocp-Apim-Subscription-Key: ' . $azureKey,
            'Content-Type: application/ssml+xml',
            'X-Microsoft-OutputFormat:' . $output_format,
            'User-Agent: Berkine',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ssml_text);

        $audio_stream = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json(["error" => "Azure Synthesize Error. Please notify support team."], 422);
            Log::error(curl_error($ch) . ' ' . $audio_stream);
        }

        curl_close($ch);

        Storage::disk('audio')->put($file_name, $audio_stream);
        $file_path = Storage::url($file_name);
        if (activeStorage('aws')) {
            Storage::disk('s3')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
            $file_path = Storage::disk('s3')->url($file_name);
            Storage::disk('audio')->delete($file_name);
        }
        $data['file_path']      = $file_path;
        $data['audioName']      = $file_name;
        $data['text']           = $text;
        $data['langsAndVoices'] =  $langsAndVoices;
        $data['wordCount']      =  $wordCount;
        $data['storage_type']   =  activeStorage('aws') ? 'aws' : 'local';

        return $data;
    }

    public function generateTextToSpeech($request)
    {
        $aiConfigService = new AiConfigService();
        $platform        = $aiConfigService->setPlatForm(appStatic()::ENGINE_AZURE);
        $aiConfig        = $aiConfigService->setConfiguration($platform, appStatic()::PURPOSE_TEXT_TO_VOICE);
        $azure           = $this->initAzure();
        $audio_stream    = $azure->textToSpeech($aiConfig, azureRegion());


        # Name and extension of the result audio file
        $name      = str_replace(' ', '_', strtolower(user()->name)) . randomStringNumberGenerator(10);
        $file_name = $name . '.' . fileExtension('mp3');

        Storage::disk('audio')->put($file_name, $audio_stream);
        $file_path = 'voice/audio/'.$file_name;

        if (activeStorage('aws')) {
            Storage::disk('s3')->writeStream($file_name, Storage::disk('audio')->readStream($file_name));
            $file_path = Storage::disk('s3')->url($file_name);
            Storage::disk('audio')->delete($file_name);
        }

        $data['file_path'] = $file_path;
        $data['audioName'] = $file_name;

        return $data;
    }

    public function setUpData():array
    {
        $data['azure_languages']        = $this->azureLanguageList();
        $data['azure_languages_voices'] = $this->azureVoiceDetailList();

        return $data;
    }
}
