<?php

namespace Modules\SocialPilot\App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Traits\Api\ApiResponseTrait;

use Modules\SocialPilot\App\Http\Requests\ConfigurePlatformRequestForm;
use Modules\SocialPilot\App\Models\Platform;
use Modules\SocialPilot\App\Services\Platform\PlatformService;

class PlatformController extends Controller
{
    use ApiResponseTrait;
    protected $platformService;

    public function __construct()
    {
        $this->platformService = new PlatformService();
    }

    # callback url
    public function callback()
    {
        // 
    }
    

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data   = $this->platformService->index();
        if ($request->ajax()) {
           return view('socialpilot::platforms._contents', $data)->render();
        }
        return view('socialpilot::platforms.index', $data);
    }

    # render platform form
    public function renderPlatformForm(Request $request)
    {
        $platform   = $this->platformService->findById((int)$request->id);
        $view       = 'socialpilot::platforms.forms.'.$platform->slug;

        return view($view, compact('platform'))->render();
    }

    # store platform credentials
    public function storePlatformCredentials(ConfigurePlatformRequestForm $request)
    {
        try {
            $platform   = $this->platformService->storeCredentials($request);
            return $this->sendResponse(
                appStatic()::SUCCESS_WITH_DATA,
                localize("Successfully stored credentials"),
                []
            );
        } catch (\Throwable $e) {
            wLog("Failed to Store credentials", errorArray($e));
            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                localize("Failed to store credentials"),
                [],
                errorArray($e)
            );
        }
    }

    # edit a resource
    public function edit(Request $request)
    {
        $platform   = $this->platformService->findById((int)$request->id);
        $data       =  view('socialpilot::platforms.forms.add', compact('platform'))->render();
        return $this->sendResponse(
            appStatic()::SUCCESS_WITH_DATA,
            localize("Successfully retrieved platform"),
            $data
        );
    }

    # update a resource
    public function update(Request $request)
    {
        $data = $this->platformService->update($request);
       
        return $this->sendResponse(
            appStatic()::SUCCESS_WITH_DATA,
            localize("Successfully updated platform"),
            $data
        );
    }
}
