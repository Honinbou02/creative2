<?php

namespace App\Services\Gowinston;

use Illuminate\Support\Str;
use App\Models\GeneratedContent;
use App\Services\Core\OpenAiCore;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Services\Core\GowinstonCore;
use App\Traits\Api\ApiResponseTrait;
use App\Traits\File\FileUploadTrait;
use App\Services\AiData\AiDataService;
use App\Services\Core\AiConfigService;
use App\Services\Prompt\PromptService;
use Illuminate\Support\Facades\Storage;
use App\Services\Balance\BalanceService;
use App\Services\Model\User\UserService;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class GowinstonService.
 */
class GowinstonService
{
    use ApiResponseTrait;

    /**
     * @throws \Throwable
     */
    public function scanContent($request, $platform)
    {
        $appStatic      = appStatic();
        $generateAction = $request->content_purpose;

        // Content detector Check
        if ($generateAction === $appStatic::PURPOSE_CONTENT_DETECTOR) {

            return $this->detectContent($request, $platform);
        }

        // Plagiarism check
        if ($generateAction === $appStatic::PURPOSE_CONTENT_PLAGIARISM) {

            return $this->plagiarismContent($request, $platform);
        }
    }
    
    public function init(): GowinstonCore
    {
        return new GowinstonCore(plagiarismApi());
    }

    public function setPlatform(string $platform) : int
    {
        return (new AiConfigService())->setPlatForm($platform);
    }

    public function detectContent($request, $platform)
    {
        $gowinston = $this->init();
        $params = [
            'text' => $request->text,
            'language' => 'en',
            'sentences' => true,
            'version' => "3.0",

        ];
        $result        = $gowinston->textDetector($params);
        $decodedResult = convertJsonDecode($result);

        # if have api error
        if (array_key_exists('error',$decodedResult) && array_key_exists('description', $decodedResult)) {
            return $decodedResult;
        }

        $decodedResult = $this->gowinstonAiUsage($decodedResult);

        return (new AiDataService())->storeGeneratedContents($decodedResult, $request->text , $request, $this->setPlatform($platform), $usingModel = 'GowinstonAi');
    }

    public function plagiarismContent($request, $platform)
    {
        try {
            $gowinston = $this->init();
            $params = [
                'text' => $request->text,
            ];
            $result        = $gowinston->plagiarismCheck($params);
            $decodedResult = convertJsonDecode($result);
            # if have api error 
            if (array_key_exists('error',$decodedResult) && array_key_exists('description', $decodedResult)) {
                return $decodedResult;
            }
            $decodedResult = $this->gowinstonAiUsage($decodedResult, strlen($request->text));
            $generatedContent = (new AiDataService())->storeGeneratedContents($decodedResult, $request->text , $request, $this->setPlatform($platform), $usingModel = 'GowinstonAi');
            return $generatedContent;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function gowinstonAiUsage($decodedResult, $length = 0)
    {
        $outputContents = '';
        $result["usage"] = [];
        if (isset($decodedResult['score'])) {         
            $promptsToken = isset($decodedResult['length']) ? $decodedResult['length'] : $length;
            $completionToken = $decodedResult['credits_used'];
            $result["usage"][] = $promptsToken;
            $result["usage"][] = $completionToken;
            $result["usage"][] = $completionToken;
        }
        $result["gowinstonAi"] = $outputContents;
        $result["row_response"] = $decodedResult;
        return $result;
    }

}
