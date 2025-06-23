<?php

namespace App\Http\Controllers\Admin\AiRewriter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AiRewriterRequest;
use App\Services\AiData\AiDataService;
use App\Services\Balance\BalanceService;
use App\Services\Core\AiConfigService;
use App\Services\Model\AiWriter\AiWriterService;
use App\Services\OpenAi\OpenAiService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class AiRewriterController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $aiWriterService;

    public function __construct()
    {
        $this->appStatic       = appStatic();
        $this->aiWriterService = new AiWriterService();
    }
    public function index(Request $request)
    {
        $data['lists'] = $this->aiWriterService->getAll(true);

        if ($request->route()->getPrefix() === 'api') {
            return response()->json($data);
        }

        if ($request->ajax()) {
            return view('backend.admin.ai-writer.list', $data)->render();
        }

        return view("backend.admin.ai-rewriter.index");
    }


    public function create()
    {
        return view('backend.admin.ai-rewriter.add-re-write');
    }

    public function rewrite(AiRewriterRequest $request)
    {
        try{
            // Check balance
            checkWordBalance();

            // Is AiReWrite Allowed
            checkValidCustomerFeature(allowAiReWriter());

            $type       = $request->type;
            $language   = $request->language ?? "english";
            $text       = $request->text;
            $prompt     = null;
            $request["content_purpose"] = "rewrite";
            $request["title"]           = "{$type} {$language}";

            if ($type == 'rewrite') {
                $prompt = "Rewrite the text  content professionally language is '$language' and text is '$text'";
            } else if ($type == 'summarize') {
                $prompt = "Summarize the content professionally language is '$language' and text is '$text'";
            } else if ($type == 'make_it_longer') {
                $prompt = "make it longer the content professionally language is '$language' and text is '$text'";
            } else if ($type == 'make_it_shorter') {
                $prompt = "make it shorter the content professionally language is '$language' and text is '$text'";
            } else if ($type == 'improve_writing') {
                $prompt = "Improve the content professionally language is '$language' and text is '$text'";
            } else if ($type == 'grammar_correction') {
                $prompt = "Correct this to standard $language. Text is '{$text}'";
            }

            if (!empty($prompt)) {
                $aiConfigService = new AiConfigService();
                $openAiService = new OpenAiService();

                $open_ai = $openAiService->initOpenAi();
                $user    = user();
                $platform = $aiConfigService->setPlatForm($this->appStatic::ENGINE_OPEN_AI);

                $usingModel = $this->appStatic::GPT_3_5_TURBO;

                $opts    = [
                    'model'             => $usingModel,
                    'messages'          =>  [[
                        'role' => 'user',
                        'content' => $prompt
                    ]],
                ];

                $completion     = $open_ai->chat($opts);
                $decodedResult  = convertJsonDecode($completion);

                wLog("{$request->content_purpose} = Open AI Response Decoded Result", $decodedResult, \logService()::LOG_OPEN_AI);

                /**
                 * Check is Open ai raise an error.
                 * If yes, then throw the exception
                 *
                 * Either Continue execution.
                 * */
                $isErrorFree = $openAiService->processResponse($decodedResult);

                /**
                 * Save Data into Generated Contents
                 * */
                $generatedContent = (new AiDataService())->storeGeneratedContents(
                    $decodedResult,
                    $prompt,
                    $request,
                    $platform,
                    $usingModel);

                //TODO::User Balance Update
                (new BalanceService())->balanceUpdate($generatedContent);

                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Rewrite successfully"),
                    $generatedContent
                );
            }

            // No Prompt Found
            return $this->sendResponse(
                $this->appStatic::NOT_FOUND,
                localize("No Prompt Found")
            );
        }
        catch(\Throwable $e){
            wLog("Failed to Rewrite", errorArray($e));

            return $this->sendResponse(
              $this->appStatic::BALANCE_ERROR,
              $e->getMessage(),
              [],
              errorArray($e)
            );
        }
    }

    
}
