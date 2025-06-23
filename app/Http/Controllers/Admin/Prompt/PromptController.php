<?php

namespace App\Http\Controllers\Admin\Prompt;

use App\Models\Prompt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Http\Resources\PromptResource;
use App\Http\Requests\PromptRequestForm;
use App\Services\Model\Prompt\PromptService;

class PromptController extends Controller
{
    use ApiResponseTrait;
    public $promptService;
    public $appStatic;
    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->promptService = new PromptService();
    }

    public function index(Request $request)
    {
        $data = $this->promptService->index();
        if ($request->ajax()) {

            return view('backend.admin.prompts.lists', $data)->render();
        }

        return view("backend.admin.prompts.index",$data);
    }

    public function store(PromptRequestForm $request)
    {
        try{
            $prompt = $this->promptService->store($request->getData());
            return $this->sendResponse(
              $this->appStatic::SUCCESS_WITH_DATA,
              localize("Successfully stored prompt"),
              PromptResource::make($prompt)
            );
        }
        catch(\Throwable $e){
            wLog("Failed to Store prompt", errorArray($e));
            return $this->sendResponse(
              $this->appStatic::VALIDATION_ERROR,
              localize("Failed to store prompt"),
              errorArray($e)
            );
        }
    }

    public function edit(Prompt $prompt)
    {
        return $this->sendResponse(
          $this->appStatic::SUCCESS_WITH_DATA,
          localize("Successfully retrieved prompt"),
          $prompt
        );
    }

    public function show($id)
    {
        return $id;
    }

    public function update(PromptRequestForm $request, Prompt $prompt)
    {
        $data = $this->promptService->update($prompt, $request->getData());

        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully  prompt Updated"),
            PromptResource::make($data)
        );
    }

    public function destroy(Request $request, Prompt $prompt)
    {
        try{
            if ($request->ajax()){
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted prompt"),
                    $prompt->delete()
                );
            }
        }
        catch(\Throwable $e){
            wLog("Failed to Delete prompt", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to Delete : ").$e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
    public function groupPrompts(Request $request)
    {
        $groupPrompts = $this->promptService->groupPrompts($request);
        $view = view('backend.admin.chats.render.render-prompt-library', compact('groupPrompts'))->render();
        return $view;
    }
}
