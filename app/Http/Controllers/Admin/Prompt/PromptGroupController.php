<?php

namespace App\Http\Controllers\Admin\Prompt;

use App\Models\PromptGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Http\Resources\PromptGroupResource;
use App\Http\Requests\PromptGroupRequestForm;
use App\Services\Model\Prompt\PromptGroupService;

class PromptGroupController extends Controller
{
    use ApiResponseTrait;
    public $promptGroupService;
    public $appStatic;
    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->promptGroupService = new PromptGroupService();
    }

    public function index(Request $request)
    {
        $promptGroups = $this->promptGroupService->getAll(true);

        if ($request->ajax()) {

            return view('backend.admin.prompt-groups.lists', compact('promptGroups'))->render();
        }

        return view("backend.admin.prompt-groups.index",compact("promptGroups"));
    }

    public function store(PromptGroupRequestForm $request)
    {
        try{
            $promptGroup = $this->promptGroupService->store($request->getData());
            return $this->sendResponse(
              $this->appStatic::SUCCESS_WITH_DATA,
              localize("Successfully stored prompt group"),
              PromptGroupResource::make($promptGroup)
            );
        }
        catch(\Throwable $e){
            wLog("Failed to Store prompt group", errorArray($e));
            return $this->sendResponse(
              $this->appStatic::VALIDATION_ERROR,
              localize("Failed to store prompt group"),
              errorArray($e)
            );
        }
    }

    public function edit(PromptGroup $promptGroup)
    {
        return $this->sendResponse(
          $this->appStatic::SUCCESS_WITH_DATA,
          localize("Successfully retrieved prompt group"),
          $promptGroup
        );
    }

    public function show($id)
    {
        return $id;
    }

    public function update(PromptGroupRequestForm $request, PromptGroup $promptGroup)
    {
        $data = $this->promptGroupService->update($promptGroup, $request->getData());

        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully  prompt group Updated"),
            PromptGroupResource::make($data)
        );
    }

    public function destroy(Request $request, PromptGroup $promptGroup)
    {
        try{
            if ($request->ajax()){
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted prompt group"),
                    $promptGroup->delete()
                );
            }
        }
        catch(\Throwable $e){
            wLog("Failed to Delete prompt group", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to Delete : ").$e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}
