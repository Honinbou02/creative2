<?php

namespace App\Http\Controllers\Admin\BrandVoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandVoice\BrandVoiceStoreRequest;
use App\Models\BrandVoice;
use App\Services\Action\BrandVoiceActionService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class BrandVoiceController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request, BrandVoiceActionService $brandVoiceActionService)
    {
        if($request->ajax()){
            $data["brandVoices"] = (new BrandVoiceActionService())->getBrandVoicesByUserId(getUserParentId());

            return view('backend.admin.brand-voice.brand-voice-list', $data)->render();
        }

        $data["tones"]       = $brandVoiceActionService->getTones();
        $data["types"]       = $brandVoiceActionService->getTypes();
        $data["brandVoiceForm"] = view("backend.admin.brand-voice.form-brand-voice")->with($data)->render();

        return view('backend.admin.brand-voice.index')->with($data);
    }

    public function create(Request $request, BrandVoiceActionService $brandVoiceActionService)
    {

        $data["tones"] = $brandVoiceActionService->getTones();
        $data["types"] = $brandVoiceActionService->getTypes();

        return view("backend.admin.brand-voice.add-brand-voice")->with($data);
    }

    public function store(BrandVoiceStoreRequest $request, BrandVoiceActionService $brandVoiceActionService)
    {
        try{
            \DB::beginTransaction();
            $brandVoice = $brandVoiceActionService->storeBrandVoice($request->getData(), getUserParentId());
            \DB::commit();

            return $this->sendResponse( 
                appStatic()::SUCCESS_WITH_DATA,
                localize("Successfully saved the brand voice"),
                $brandVoice
            );
        } catch(\Throwable $e){
            \DB::rollBack();
            wLog("Brand Voice Creation Failed", errorArray($e));

            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                localize("Failed to store category"),
                [],
                errorArray($e)
            );
        }
    }

    public function edit(Request $request,$id, BrandVoiceActionService $brandVoiceActionService)
    {
        try{
            $data["editBrandVoice"] = $brandVoiceActionService->getBrandVoiceById($id);

            // Is this my brand voice?
            if($data["editBrandVoice"]->user_id != getUserParentId()){

                abort(401);
            }

            $data["tones"] = $brandVoiceActionService->getTones();
            $data["types"] = $brandVoiceActionService->getTypes();

            if($request->ajax()){
                return view('backend.admin.brand-voice.form-brand-voice', $data)->render();
            }

            return view("backend.admin.brand-voice.edit-brand-voice")->with($data);
        }
        catch(\Throwable $e){
            \DB::rollBack();
            wLog("Failed to edit Brand voice", errorArray($e));

            return $this->sendResponse(
              appStatic()::SUCCESS_WITH_DATA,
              localize("Failed to edit Brand voice"),
              [],
              errorArray($e)
            );
        }
    }


    public function update(BrandVoiceStoreRequest $request, $id, BrandVoiceActionService $brandVoiceActionService)
    {
        try{
            \DB::beginTransaction();

            $brandVoice = $brandVoiceActionService->getBrandVoiceById($id);

            // Is this my brand voice?
            if($brandVoice->user_id != getUserParentId()){
                abort(401);
            }

            $brandVoiceActionService->updateBrandVoice($brandVoice ,$request->getData());

            \DB::commit();

            flashMessage(localize("Brand Voice Updated Successfully"));

            return $this->sendResponse(
                appStatic()::SUCCESS_WITH_DATA,
                localize("Successfully updated the brand voice"),
                $brandVoice
            );
        }
        catch(\Throwable $e){
            \DB::rollBack();
            wLog("Brand Voice Creation Failed", errorArray($e));

            return $this->sendResponse(
                appStatic()::NOT_FOUND,
                localize("Failed to Update Brand voice"),
                [],
                errorArray($e)
            );
        }
    }

    public function destroy(Request $request, BrandVoice $brandVoice)
    {
        try {
            validateRecordOwnerCheck($brandVoice);

            if ($request->ajax()) {

                // Delete BrandVoice Product
                (new BrandVoiceActionService())->deleteBrandVoiceProductsByBrandVoiceId($brandVoice->id);

                return $this->sendResponse(
                    appStatic()::SUCCESS,
                    localize("Successfully deleted the Brand Voice."),
                    $brandVoice->delete()
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to deleted the Brand Voice", errorArray($e));

            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                localize("Failed to deleted the Brand Voice") . $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}
