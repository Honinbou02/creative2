<?php

namespace App\Http\Controllers\Admin\Voice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Voice\VoiceCloneRequest;
use App\Services\Action\VoiceCloneActionService;
use App\Services\Balance\BalanceService;
use App\Traits\Api\ApiResponseTrait;

class VoiceCloneController extends Controller
{
    use ApiResponseTrait;
    private $voiceService;

    public function __construct()
    {
        $this->voiceService = new VoiceCloneActionService();
    }

    public function index()
    {
        try{
            $data["voices"] = (new VoiceCloneActionService())->getVoicesByUserId(getUserObject()->id);

            return view('backend.admin.clone.voice.index')->with($data);
        }
        catch(\Throwable $e){
            flashMessage($e->getMessage(), 'error');

            return to_route("admin.voice.index");
        }
    }

    public function cloneVoice(VoiceCloneRequest $request)
    {
        try{
            \DB::beginTransaction();

            if(!hasBalance(appStatic()::PURPOSE_TEXT_TO_VOICE)) {
                return $this->sendResponse(
                    appStatic()::BALANCE_ERROR,
                    localize("Your Voice Clone balance has exceeded the plan"),
                );
            }

            // Check Voice Clone is Allowed
            checkValidCustomerFeature("allow_clone_voice");

            $user = getUserObject();

            $voiceClone = $this->voiceService->cloneVoice($request->validated(), getUserObject());

            (new BalanceService())->audioBalanceUpdate($user, 1);

            \DB::commit();

            flashMessage("Successfully cloned Voice", 'success');

            return $this->sendResponse(
              appStatic()::SUCCESS_WITH_DATA,
              localize("Successfully cloned Voice"),
              $voiceClone
            );
        }
        catch(\Throwable $e){
            \DB::rollBack();

            wLog("Failed to clone Voice", errorArray($e));

            flashMessage($e->getMessage(), 'error');

            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                "Failed to clone Voice - ".$e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
    
    
}
