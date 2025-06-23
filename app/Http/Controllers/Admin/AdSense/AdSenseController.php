<?php

namespace App\Http\Controllers\Admin\AdSense;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Model\AdSense\AdSenseService;
use App\Http\Requests\Admin\AdSense\AdSenseRequestForm;

class AdSenseController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $adSenseService;
    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->adSenseService = new AdSenseService();
    }
    public function index()
    {
        $data = $this->adSenseService->index();
        return view('backend.admin.settings.adSense.index', $data);
    }
    public function store(AdSenseRequestForm $request)
    {
        $this->adSenseService->store($request->validated());
    }
    public function edit($id)
    {
        $model = $this->adSenseService->findById($id);
    }
    public function update(AdSenseRequestForm $request, $id)
    {
        try {
            $model = $this->adSenseService->update($request->validated(), $id);
            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully Updated"),
            );
        } catch (\Throwable $e) {
            wLog("Failed to update ", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to update"),
                [],
                errorArray($e)
            );
        }
    }
}
