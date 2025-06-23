<?php

namespace App\Http\Controllers\Admin\User;

use App\Utils\AppStatic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ChangePasswordRequestForm;
use App\Http\Requests\Admin\Profile\InfoUpdateRequestForm;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Model\User\UserProfileService;

class UserProfileController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $userProfileService;
    public function __construct()
    {
        $this->appStatic          = new AppStatic();
        $this->userProfileService = new UserProfileService();
    }
    public function index(Request $request)
    {
        $data['user'] = $this->userProfileService->profile($request->id);
        return view('backend.admin.profile.index', $data);
    }
 
    public function changePassword(ChangePasswordRequestForm $request)
    {
        $this->userProfileService->passwordChange($request->validated());
        return $this->sendResponse(
            appStatic()::SUCCESS_WITH_DATA,
           localize('Password Change Successfully'),
        );
    }
    public function infoUpdate(InfoUpdateRequestForm $request)
    {
      
        $this->userProfileService->updateInfo($request->validated());
        return $this->sendResponse(
            appStatic()::SUCCESS_WITH_DATA,
            localize('Info Change Successfully'),
        );
    }
}
