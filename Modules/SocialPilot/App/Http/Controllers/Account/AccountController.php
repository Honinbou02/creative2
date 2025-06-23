<?php

namespace Modules\SocialPilot\App\Http\Controllers\Account;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Modules\SocialPilot\App\Services\Account\AccountService;
use Modules\SocialPilot\App\Services\Account\FacebookService;
use Modules\SocialPilot\App\Services\Account\InstagramService;
use Modules\SocialPilot\App\Services\Account\LinkedinService;
use Modules\SocialPilot\App\Services\Account\TwitterService;
use Modules\SocialPilot\App\Services\Platform\PlatformService;

class AccountController extends Controller
{
    use ApiResponseTrait;
    protected $accountService;
    protected $platformService;

    # constructor
    public function __construct()
    {
        $this->accountService   = new AccountService();
        $this->platformService  = new PlatformService();
    }

    # Display a listing of the resource.
    public function index(Request $request)
    {
        $data   = $this->accountService->index();

        $request->merge(['onlyActives' => true]);

        $getAll             = true;
        $data['platforms'] = ($this->platformService->index($getAll))['details'];

        if ($request->ajax()) {
           return view('socialpilot::accounts._contents', $data)->render();
        }
        return view('socialpilot::.accounts.index', $data);
    }
    
    # create form
    public function create(Request $request)
    {
        checkAccountCreateBalance();
        
        $type       = $request->type; // facebook/twitter...
        $platform   = $this->platformService->findBySlug($type);
        $data       =  view('socialpilot::accounts.forms.'.$type , compact('platform'))->render();
        return $this->sendResponse(
            appStatic()::SUCCESS_WITH_DATA,
            localize("Successfully retrieved account form"),
            $data
        );
    }

    # store resource
    public function store(Request $request)
    {
        checkAccountCreateBalance();

        $platform = $this->platformService->findById($request->platform_id);
        $data     =  match ($request->type){
            appStatic()::PLATFORM_FACEBOOK => (new FacebookService())->store($request, $platform),
        };

        return $this->sendResponse(
            $data['status_code'],
            $data['message'],
            $data
        );
    }

    # connect account
    public function connect($platform)
    {
        
        checkAccountCreateBalance();
        
        $platform = $this->platformService->findBySlug($platform);

        return match ($platform->slug){
            appStatic()::PLATFORM_FACEBOOK      => redirect((new FacebookService())->redirect($platform)),
            appStatic()::PLATFORM_INSTAGRAM     => redirect((new InstagramService())->redirect($platform)),
            appStatic()::PLATFORM_TWITTER       => redirect((new TwitterService())->redirect($platform)),
            appStatic()::PLATFORM_LINKEDIN      => redirect((new LinkedinService())->redirect($platform)),
        };
    }

    # callback
    public function callback(Request $request, $platform)
    {
        
        checkAccountCreateBalance();

        $platform = $this->platformService->findBySlug($platform);
        return match ($platform->slug){
            appStatic()::PLATFORM_FACEBOOK      => (new FacebookService())->callback($request, $platform),
            appStatic()::PLATFORM_INSTAGRAM     => (new InstagramService())->callback($request, $platform),
            appStatic()::PLATFORM_TWITTER       => (new TwitterService())->callback($request, $platform),
            appStatic()::PLATFORM_LINKEDIN      => (new LinkedinService())->callback($request, $platform),
        };
    }

    # destroy a resource
    public function destroy($id)
    {
        $data = $this->accountService->findById($id);
        try {
            return $this->sendResponse(
                appStatic()::SUCCESS_WITH_DATA,
                localize("Successfully deleted account"),
                $data->delete()
            );
        } catch (\Throwable $th) {
            wLog("Failed to Delete Folder", errorArray($th));
            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                localize("Failed to delete the account"),
                [],
                errorArray($th)
            );
        }
    }
   
}
