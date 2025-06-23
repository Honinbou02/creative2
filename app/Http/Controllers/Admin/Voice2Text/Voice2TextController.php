<?php

namespace App\Http\Controllers\Admin\Voice2Text;

use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Balance\BalanceService;
use App\Services\Integration\IntegrationService;
use App\Services\Model\SpeechToText\SpeechToTextService;
use App\Http\Requests\Admin\SpeechToText\SpeechToTextRequestForm;

class Voice2TextController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $voice2TextService;

    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->voice2TextService = new SpeechToTextService();

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.voice2Text.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpeechToTextRequestForm $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Check Permissions
            checkValidCustomerFeature("allow_speech_to_text");

           $result = (new IntegrationService())->audio2TextGenerator(appStatic()::ENGINE_OPEN_AI, $request);

           (new BalanceService())->audio2TextBalanceUpdate(getUserObject(), 1);

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully generate content speech to text store"), [],[], ['model'=>$result]
            );
        } catch (\Throwable $e) {

            wLog("Failed to Store generate content speech to text", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to store generate content speech to text")." ".$e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}
