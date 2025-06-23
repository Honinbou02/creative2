<?php

namespace App\Http\Controllers\Admin\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Http\Requests\UpdateChatThreadRequestForm;
use App\Services\Model\ChatThread\ChatThreadService;

class ChatThreadController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $chatThreadService;
    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->chatThreadService = new ChatThreadService();
    }
    public function update(UpdateChatThreadRequestForm $request)
    {
        $id = $request->chat_thread_id;
        $this->chatThreadService->update($id, $request->validated());
    }
    public function destroy(Request $request, $id)
    {
        
        $model = $this->chatThreadService->findById($id);
        try {
            if($model->user_id == userID()) {

                if ($request->ajax()) {
                    return $this->sendResponse(
                        $this->appStatic::SUCCESS,
                        localize("Successfully Deleted"),
                        $model->delete()
                    );
                }
            }
            if ($request->ajax()) {
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Permission denied"),
                  
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete Tag", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to Delete : ") . $e->getMessage(),
                [],
                errorArray($e)
            );
        }
        
    }
}
