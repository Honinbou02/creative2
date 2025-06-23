<?php

namespace Modules\SocialPilot\App\Http\Controllers\QuickText;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Traits\Api\ApiResponseTrait;

use Modules\SocialPilot\App\Http\Requests\QuickTextRequestForm;
use Modules\SocialPilot\App\Services\QuickText\QuickTextService;

class QuickTextController extends Controller
{
    use ApiResponseTrait;

    protected $quickTextService;

    public function __construct()
    {
        $this->quickTextService = new QuickTextService();
    }

    # Display a listing of the resource. 
    public function index(Request $request)
    {
        $data   = $this->quickTextService->index();
        if ($request->ajax()) {
           return view('socialpilot::quick-texts._contents', $data)->render();
        }
        return view('socialpilot::quick-texts.index', $data);
    }

    # form
    public function form(Request $request)
    {
        $quickText   = $request->id != null ? $this->quickTextService->findById((int)$request->id) : null;
        $data        =  view('socialpilot::quick-texts.forms.add', compact('quickText'))->render();
        return $this->sendResponse(
            appStatic()::SUCCESS_WITH_DATA,
            localize("Successfully retrieved quick text form"),
            $data
        );
    }

    # store resource
    public function store(QuickTextRequestForm $request)
    {
        try {
            $quickText   = $this->quickTextService->store($request);
            return $this->sendResponse(
                appStatic()::SUCCESS_WITH_DATA,
                localize("Successfully stored quick text"),
                []
            );
        } catch (\Throwable $e) {
            wLog("Failed to Store quick text", errorArray($e));
            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                localize("Failed to store quick text"),
                [],
                errorArray($e)
            );
        }
    }

    # update a resource
    public function update(Request $request)
    {
        $data = $this->quickTextService->update($request);
       
        return $this->sendResponse(
            appStatic()::SUCCESS_WITH_DATA,
            localize("Successfully updated quick text"),
            $data
        );
    }

    # destroy a resource
    public function destroy($id)
    {
        $data = $this->quickTextService->findById($id);
        try {
            return $this->sendResponse(
                appStatic()::SUCCESS_WITH_DATA,
                localize("Successfully deleted quick text"),
                $data->delete()
            );
        } catch (\Throwable $th) {
            wLog("Failed to Delete Folder", errorArray($th));
            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                localize("Failed to delete the quick text"),
                [],
                errorArray($th)
            );
        }
    }
}
