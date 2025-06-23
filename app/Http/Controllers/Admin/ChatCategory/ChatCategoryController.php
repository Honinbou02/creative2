<?php

namespace App\Http\Controllers\Admin\ChatCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChatCategory\ChatCategoryStoreRequest;
use App\Http\Requests\Admin\ChatCategory\ChatCategoryUpdateRequest;
use App\Http\Resources\Admin\ChatCategory\ChatCategoryResource;
use App\Models\ChatCategory;
use App\Services\Model\ChatCategory\ChatCategoryService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class ChatCategoryController extends Controller
{
    use ApiResponseTrait;
    public $chatCategoryService;
    public $appStatic;
    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->chatCategoryService = new ChatCategoryService();
    }

    public function index(Request $request)
    {
        $chatCategories = $this->chatCategoryService->getAll(true);

        if ($request->ajax()) {

            return view('backend.admin.chat-categories.chat_category_lists', compact('chatCategories'))->render();
        }

        return view("backend.admin.chat-categories.index",compact("chatCategories"));
    }

    public function store(ChatCategoryStoreRequest $request)
    {
        try{
            $chatCategory = $this->chatCategoryService->store($request->getData());
            return $this->sendResponse(
              $this->appStatic::SUCCESS_WITH_DATA,
              localize("Successfully stored Chat Category"),
              ChatCategoryResource::make($chatCategory)
            );
        }
        catch(\Throwable $e){
            wLog("Failed to Store Chat Category", errorArray($e));
            return $this->sendResponse(
              $this->appStatic::VALIDATION_ERROR,
              localize("Failed to store Chat Category"),
              errorArray($e)
            );
        }
    }

    public function edit(ChatCategory $chatCategory)
    {
        return $this->sendResponse(
          $this->appStatic::SUCCESS_WITH_DATA,
          localize("Successfully retrieved Chat Category"),
          $chatCategory
        );
    }

    public function show($id)
    {
        return $id;
    }

    public function update(ChatCategoryUpdateRequest $request, ChatCategory $chatCategory)
    {
        $data = $this->chatCategoryService->update($chatCategory, $request->getData());

        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully  Chat Category Updated"),
            ChatCategoryResource::make($data)
        );
    }

    public function destroy(Request $request, ChatCategory $chatCategory)
    {
        try{
            if ($request->ajax()){
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted Chat Category"),
                    $chatCategory->delete()
                );
            }
        }
        catch(\Throwable $e){
            wLog("Failed to Delete Chat Category", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to Delete : ").$e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}
