<?php

namespace App\Http\Controllers\Admin\TextToSpeech;

use App\Models\TextToSpeech;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Support\Facades\Storage;
use App\Services\Balance\BalanceService;
use App\Services\Model\TextToSpeech\TextToSpeechService;
use App\Http\Resources\Admin\TextToSpeech\TextToSpeechResource;
use App\Http\Requests\Admin\TextToSpeech\TextToSpeechRequestForm;

class TextToSpeechController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $textToSpeechService;

    public function __construct(
    ) {
        $this->textToSpeechService = new TextToSpeechService();
        $this->appStatic = appStatic();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->textToSpeechService->getData();

        if ($request->route()->getPrefix() === 'api') {
            return response()->json($data);
        }

        if ($request->ajax()) {
            return view('backend.admin.textToSpeeches.text-to-speech-list', $data)->render();
        }

        return view('backend.admin.textToSpeeches.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TextToSpeechRequestForm $request)
    {
        try {
            if(!hasBalance(appStatic()::PURPOSE_TEXT_TO_VOICE)) {
                return $this->sendResponse(
                    $this->appStatic::BALANCE_ERROR,
                    localize("Your Text To Voice balance has exceeded the plan"),
                );
            }

            $isOpenAIEngine = isOpenAiEngine($request->engine);
            $feature        = allowTextToSpeech();

            if($isOpenAIEngine) {
                $feature = allowTextToSpeechOpenAI();
            }

            // Check Valid Permission
            checkValidCustomerFeature($feature);

            $textToSpeech = $this->textToSpeechService->store($request);

            (new BalanceService())->audioBalanceUpdate(getUserObject(), 1);

            // Generated
            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully stored TextToSpeech"),
                TextToSpeechResource::make($textToSpeech)
            );
        } catch (\Throwable $e) {
            wLog("Failed to Store TextToSpeech", errorArray($e));
            return $this->sendResponse($this->appStatic::VALIDATION_ERROR, $e->getMessage(), [], errorArray($e));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TextToSpeech $textToSpeech)
    {
        try {
            if(!isAdmin() && $textToSpeech->created_by_id != user()->id) {
                return $this->sendResponse(
                    $this->appStatic::UNAUTHORIZED,
                    localize("Sorry ! you are not creator"),
                );
            }
            $exit_file_path = base_path('public/' . $textToSpeech->file_path);
            if (file_exists($exit_file_path)) {
                unlink($exit_file_path);
            }
            if($textToSpeech->storage_type == 'aws') {
                Storage::disk('s3')->delete($textToSpeech->audioName);
            }
            if ($request->ajax()) {
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted TextToSpeech"),
                    $textToSpeech->delete()
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete TextToSpeech", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to Delete : ") . $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}
