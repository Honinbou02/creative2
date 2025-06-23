<?php

namespace App\Http\Controllers\Admin\AiWriter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Integration\IntegrationService;
use App\Services\Model\AiWriter\AiWriterService;
use App\Http\Requests\AiWriter\AiWriterRequestForm;
use App\Models\GeneratedContent;

class AiWriterController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $aiWriterService;

    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->aiWriterService = new AiWriterService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['lists'] = $this->aiWriterService->getAll(true);
        
        if ($request->route()->getPrefix() === 'api') {
            return response()->json($data);
        }

        if ($request->ajax()) {
            return view('backend.admin.ai-writer.list', $data)->render();
        }

        return view('backend.admin.ai-writer.index', $data)->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.ai-writer.writer-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AiWriterRequestForm $request)
    {
        try {
            // Check Word Balance
            checkWordBalance();

            $model = $this->aiWriterService->store($request->getData());
            session()->put([sessionLab()::SESSION_GENERATE_TEXT_ID=>$model->id]);
        
            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully generate content store"), [],[], ['model'=>$model]
            );
        } catch (\Throwable $e) {

            wLog("Failed to Store generate content", errorArray($e));
           
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to store generate content"),
                [],
                errorArray($e)
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $content = $this->aiWriterService->findById($id);
        return view('backend.admin.ai-writer.show', compact('content'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            
            if ($request->ajax()) {
                $this->aiWriterService->delete($request->id);
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    "Successfully deleted AI Content",
                   
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete Template", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                "Failed to Delete : " . $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }

    public function generate(Request $request)
    {
        try{
            // Check balance
            checkWordBalance();

            // Is AiWriter Allowed
            checkValidCustomerFeature(allowAiWriter());

            $integrationService = new IntegrationService();
            $request->merge([
                'stream'=>true
            ]);

            return $integrationService->contentGenerator(aiWriterEngine(), $request);
        } catch(\Throwable $e) {
            wLog("Failed to Generate Text", errorArray($e), logService()::LOG_OPEN_AI);

            return $this->streamErrorResponse($e->getMessage());
        }
    }
    public function saveChange(Request $request)
    {
        try {
            // Check balance
            checkWordBalance();

            // Is AiWriter Allowed
            checkValidCustomerFeature(allowAiWriter());

            $this->aiWriterService->save($request);
            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                "Successfully generate content change");
        } catch (\Throwable $e) {

            wLog("Failed to change generate content", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                "Failed to change generate content - ".$e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}
