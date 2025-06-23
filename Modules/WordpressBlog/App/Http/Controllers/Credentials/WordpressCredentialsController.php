<?php

namespace Modules\WordpressBlog\App\Http\Controllers\Credentials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Modules\WordpressBlog\App\resources\WpCredentialResource;
use Modules\WordpressBlog\Services\Credentials\WpCredentialService;
use Modules\WordpressBlog\App\Http\Requests\WpCredentialRequestForm;

class WordpressCredentialsController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $wpCredentialService;
    public function __construct()
    {
        $this->appStatic               = appStatic();
        $this->wpCredentialService = new WpCredentialService();
    }

    public function index(Request $request)
    {
        $data = $this->wpCredentialService->index();
        return view("wordpressblog::credentials.index")->with($data);
    }

    public function store(WpCredentialRequestForm $request)
    {
        try {
            $wpCredential = $this->wpCredentialService->store($request->getData());

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully stored"),
                WpCredentialResource::make($wpCredential)
            );
        } catch (\Throwable $e) {

            wLog("Failed to Store", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to store"),
                errorArray($e)
            );
        }
    }

    public function edit($id)
    {
        $wpCredential = $this->wpCredentialService->findWpCredentialById($id);
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully retrieved"),
            $wpCredential
        );
    }

    public function show($id)
    {
    }

    public function update(WpCredentialRequestForm $request, $id)
    {
        $wpCredential = $this->wpCredentialService->findWpCredentialById($id);
        validateRecordOwnerCheck($wpCredential);
        $data = $this->wpCredentialService->update($wpCredential, $request->getData());
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully Updated"),
            WpCredentialResource::make($data)
        );
    }

    public function destroy(Request $request, $id)
    {
        try {
            $wpCredential = $this->wpCredentialService->findWpCredentialById($id);
            validateRecordOwnerCheck($wpCredential);
            if ($request->ajax()) {
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted"),
                    $wpCredential->delete()
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete the", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to Delete : ") . $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}
