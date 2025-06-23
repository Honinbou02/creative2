<?php

namespace Modules\SocialPilot\App\Services\Account;

use App\Services\Balance\BalanceService;
use Illuminate\Support\Arr;
use Modules\SocialPilot\App\Models\PlatformsAccount;

class AccountService
{
    public function index()
    {
        $request         = request();
        $platforms       = PlatformsAccount::filterByUser()->whereHas('platform', function ($q) {
            $q->isActive();
        });
        
        if($request->has('search')){
            $platforms->where('account_name', 'like', '%'.$request->search.'%');
        }
        
        if($request->type){
            $platforms->where('platform_id', appStatic()::PLATFORM_IDS[$request->type]);
        }

        $platforms       = $platforms->paginate(maxPaginateNo());
        $data['details'] = $platforms;
        $data['type']    = $request->type;
        return $data;
    }
    
    public function count()
    {
        return PlatformsAccount::filterByUser()->whereHas('platform', function ($q) {
            $q->isActive();
        })->count();
    }

    public function findById($id)
    {
        return PlatformsAccount::findOrFail((int) $id);
    }

    public function findByConditions($conditions)
    {
        return PlatformsAccount::where($conditions)->first();
    }

    public function getByIds($ids)
    {
        return PlatformsAccount::filterByUser()->whereIn('id', $ids)->whereHas('platform', function ($q) { $q->isActive();})->get();
    }

    public function store($platform, $accountDetails, $type, $platformAccountID)
    {
        $user               = user();
        $accountId          = Arr::get($accountDetails,"account_id", null);

        $conditions         = ['platform_id' => $platform->id, 'account_id' => $accountId , 'user_id' => $user->id];
        $platformAccount    = $platformAccountID != null ? $this->findById($platformAccountID) : PlatformsAccount::firstOrNew($conditions);

        $platformAccount->account_name                = Arr::get($accountDetails, 'account_name');
        $platformAccount->account_details             = json_encode($accountDetails);
        $platformAccount->is_connected                = appStatic()::STATUS['TRUE'];
        $platformAccount->account_type                = $type;
        
        $platformAccount->access_token                = Arr::get($accountDetails, "access_token",null);
        $platformAccount->access_token_expire_at      = Arr::get($accountDetails, "access_token_expire_at",null);
        $platformAccount->refresh_token               = Arr::get($accountDetails, "refresh_token",null);
        $platformAccount->refresh_token_expire_at     = Arr::get($accountDetails, "refresh_token_expire_at",null);
        $platformAccount->is_active                   = appStatic()::STATUS['TRUE'];

        $platformAccount->save();

        // update account balance
        try {
            (new BalanceService())->updateUserAccountBalance();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    
    public function disConnectAccount($platformAccount)
    {
        $platformAccount->is_connected                = appStatic()::STATUS['FALSE'];
        $platformAccount->is_active                   = appStatic()::STATUS['FALSE'];
        $platformAccount->save();
    }
}
