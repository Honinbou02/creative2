<?php

namespace Modules\WordpressBlog\App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Modules\WordpressBlog\App\Models\WpSetting;
use Modules\WordpressBlog\App\resources\WpSettingResource;
use Modules\WordpressBlog\Services\Settings\WpSettingService;
use Modules\WordpressBlog\App\Http\Requests\WpSettingRequestForm;

class WordpressSettingController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $wpSettingService;
    public function __construct()
    {
        $this->appStatic               = appStatic();
        $this->wpSettingService = new WpSettingService();
    }

    public function index(Request $request)
    {
        $data["settings"] = $this->wpSettingService->getAll(true, null);
        $data["settingsTabs"] = $this->wpSettingService->wpSettingTabs();
     
        if ($request->ajax()) {
            return view('wordpressblog::settings.lists', $data)->render();
        }

        return view("wordpressblog::settings.index")->with($data);
    }

    public function store(Request $request)
    {
        try {
            $wpSetting = $this->wpSettingService->store($request);

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                "Successfully stored wordpress setting",
                WpSettingResource::make($wpSetting)
            );
        } catch (\Throwable $e) {

            wLog("Failed to Store wordpress setting", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                "Failed to store wordpress setting",
                errorArray($e)
            );
        }
    }
    
}
