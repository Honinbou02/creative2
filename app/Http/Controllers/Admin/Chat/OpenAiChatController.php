<?php

namespace App\Http\Controllers\Admin\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Chat\ChatRequest;
use App\Http\Requests\AiChatRequest;
use App\Services\Balance\BalanceService;
use App\Services\Integration\IntegrationService;
use App\Services\OpenAi\OpenAiService;
use App\Traits\Api\ApiResponseTrait;
use App\Traits\Global\GlobalTrait;
use App\Utils\AppStatic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpenAiChatController extends Controller
{
    use GlobalTrait;
    use ApiResponseTrait;
    public $openAiService;
    public $opneAi;

    public function __construct()
    {
        $this->openAiService = new OpenAiService();
        $this->opneAi = $this->openAiService->initOpenAi();
    }

    public function store(ChatRequest $request)
    {
        try{
            DB::beginTransaction();
            $openAiService = $this->opneAi->completetion();
            DB::commit();
        }
        catch(\Throwable $e){
            DB::rollBack();
            wLog("Failed to save chat", errorArray($e));
            return redirect()->back();
        }
    }

    public function codeGenerator(Request $request)
    {
        return view("backend.admin.chats.codes.add_code");
    }


        /**
     * Text Generator
     * */
    public function aiCodeGenerator(
        AiChatRequest $request,
        IntegrationService $integrationService,
        AppStatic $appStatic
    ): \Illuminate\Http\JsonResponse
    {
        try {
            // Check balance
            checkWordBalance();

            // check AiCodeGenerator Allowed
            checkValidCustomerFeature(allowAiCode());

            DB::beginTransaction();

            $contentGenerator = $integrationService->contentGenerator(generateCodeEngine(), $request);

            (new BalanceService())->balanceUpdate($contentGenerator);

            DB::commit();

            return $this->sendResponse(
                $appStatic::SUCCESS_WITH_DATA,
                localize("AI Code Generated"),
                $contentGenerator
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            wLog("Failed to Generate Code", errorArray($e), logService()::LOG_OPEN_AI);

            return $this->sendResponse(
              $appStatic::VALIDATION_ERROR,
              "Failed to generate Code " .$e->getMessage(),
              [],
              errorArray($e)
            );
        }
    }
}
