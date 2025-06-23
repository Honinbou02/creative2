<?php

namespace App\Services\Model\TextToSpeech;

use App\Models\TextToSpeech;
use App\Models\GeneratedContent;
use App\Services\Azure\AzureService;
use App\Services\Google\GoogleService;
use App\Traits\Language\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use App\Services\Balance\BalanceService;
use App\Services\ElevenLab\ElevenLabsService;
use App\Services\Integration\IntegrationService;

/**
 * Class TextToSpeechService.
 */
class TextToSpeechService
{
    use LanguageTrait;
    public function getData()
    {
        $data = [];
        $data['text_to_speeches'] = $this->all();
        $data += $this->loadDataForOpenAi();
        $data += $this->loadDataForElevenLabs();
        $data += $this->loadDataForGoogleCloud();
        $data += $this->loadDataForAzureCloud();
        return $data;
    }
    public function all()
    {
        $request = request();
        $search  = $request->search;
        $engine  = $request->engine;

        $query   = TextToSpeech::query();

        if (!empty($search)) {
            $query = $query->search($search);
        }
        if (!empty($engine)) {
            $query = $query->engine($engine);
        }
       

        return $query->latest()->paginate(request('perPage', appStatic()::PER_PAGE_DEFAULT), "*", "page", request('page', 0))->withQueryString();
    }

    /**
     * TextToSpeech Store
     * */
    public function store($request): Model
    {
        $payloads = $this->formatParams($request);      
        $model    = TextToSpeech::query()->create($payloads);
        $payloads = [
            "article_id"        => $request->article_id ?? null,
            "title"             => $request->title,
            "slug"              => slugMaker($request->title),
            "model_name"        => $request->engine,
            "prompt"            => plainText($request->content),
            "response"          => $model->file_path,
            "storage_type"      => activeStorage('aws') ? 'aws' : 'local',           
            "content_type"      => appStatic()::PURPOSE_TEXT_TO_VOICE,
            "platform"          => $request->engine,
            "is_active"         => 1,
            
        ];
  
        return $model;
    }

    public  function formatParams($request):array
    {
        $engine = $request->engine;
        // Storing Platform into session for balance update
        session()->put(["engine" => $engine]);
        // store audio and get audio file path
        $textToSpeech             = (new IntegrationService())->voiceGenerator($engine, $request);
        $payloads                 = $request->getData();
        $payloads["file_path"]    = $textToSpeech["file_path"];
        $payloads["is_active"]    = 1;
        $payloads["audioName"]    = $textToSpeech["audioName"];
        $payloads["slug"]         = slugMaker($request->title);
        $payloads["text"]         = plainText($request->content);
        $payloads["type"]         = $request->engine;
        $payloads["storage_type"] = activeStorage('aws') ? 'aws' : 'local';
        $payloads["words"]        = strlen(plainText($request->content));
        return $payloads;
       
    }

    # render data for open ai text to speech
    public function loadDataForOpenAi(): array
    {
        $voices                   = appStatic()::open_ai_voices;
        $data                     = [];
        $data['speeds']           = appStatic()::open_ai_speeds;
        $data['models']           = appStatic()::open_ai_tts_models;
        $data['response_formats'] = appStatic()::open_ai_response_formats;
        $data['languages']        = $this->openAiTextToSpeechLanguage();
        $data['languages_voices'] = explode(',', $voices);
        $data['status']           = 'open_ai_tts';
        return $data;
    }
    # render data for elevenLabs text to speech
    public function loadDataForElevenLabs():array
    {
        return (new  ElevenLabsService())->setUpData();
    }
    # render data for google cloud text to speech
    public function loadDataForGoogleCloud():array
    {     
        return (new GoogleService())->setUpData();
    }
    # render data for azure text to speech
    public function loadDataForAzureCloud():array
    {     
        return (new AzureService())->setUpData();
    }
}
 