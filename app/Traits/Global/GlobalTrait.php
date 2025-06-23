<?php

namespace App\Traits\Global;

use App\Http\Requests\AiChatRequest;
use App\Services\Integration\IntegrationService;
use App\Traits\Api\ApiResponseTrait;
use App\Utils\AppStatic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait GlobalTrait
{
    use ApiResponseTrait;
    /**
     * Text Generator
     * */
    public function textGenerator(
        AiChatRequest $request,
        IntegrationService $integrationService,
        AppStatic $appStatic
    ) {
        try {
            DB::beginTransaction();
            $contentGenerator = $integrationService->contentGenerator($appStatic::ENGINE_OPEN_AI, $request);
            DB::commit();
            return $contentGenerator;
        } catch (\Throwable $e) {
            DB::rollBack();
            wLog("Failed to Generate Text", errorArray($e), logService()::LOG_OPEN_AI);
            return response()->json([errorArray($e)], 411);
        }
    }


    /**
     * Image Generator
     * */
    public function imageGenerator(Request $request, IntegrationService $integrationService, AppStatic $appStatic)
    {
        $openAiService = $integrationService->handle($appStatic::ENGINE_OPEN_AI);

        $openAi = $openAiService->initOpenAi();
    }

    /**
     * Text to Audio Generator
     * */
    public function textToAudioGenerator(Request $request, IntegrationService $integrationService, AppStatic $appStatic)
    {

        // TODO::will generate based on service type.
        $openAiService = $integrationService->handle($appStatic::ENGINE_ELEVEN_LAB);

        $openAi = $openAiService->initOpenAi();
    }

    /**
     * Speech to Text Generator
     * */
    public function speechToTextGenerator(Request $request, IntegrationService $integrationService, AppStatic $appStatic)
    {
        $openAiService = $integrationService->handle($appStatic::ENGINE_OPEN_AI);

        $openAi = $openAiService->initOpenAi();
    }

    /**
     * Text to Video Generator
     * */
    public function textToVideoGenerator(Request $request, IntegrationService $integrationService, AppStatic $appStatic)
    {
        $openAiService = $integrationService->handle($appStatic::ENGINE_OPEN_AI);

        $openAi = $openAiService->initOpenAi();
    }
}
