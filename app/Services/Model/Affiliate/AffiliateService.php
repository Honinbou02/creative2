<?php

namespace App\Services\Model\Affiliate;

use Illuminate\Support\Str;
use App\Models\AffiliateEarning;
use App\Models\AffiliatePayment;

class AffiliateService {

    public function overview($request = null):array
    {
        $data = [];
        $data['user']             = $this->referralCodeStore($request);

        $data['earningHistories'] = user()->referredUserEarnings()->latest()->paginate(5);

        return $data;
    }
    
    private function referralCodeStore()
    {
        $user = user();

        if (empty($user->referral_code)) {
            $user->update([
                'referral_code' => substr(userID() . Str::random(10), 0, 10)
            ]);
        }

        return $user;
    }
    
    public function paymentHistories(): array
    {
        $data['user']             = user();
        $data['paymentHistories'] = AffiliatePayment::query()
            ->where('status', '!=', 'requested')
            ->when($data['user']->user_type == appStatic()::TYPE_CUSTOMER, function($q) {
            $q->where('user_id',user()->id);
        })->latest()->paginate(maxPaginateNo());

       return $data;
    }
    
    public function earningHistories()
    {
        $data['user'] = user();
        $data['earningHistories'] = AffiliateEarning::when($data['user']->user_type == appStatic()::TYPE_CUSTOMER, function($q) {
            $q->where('user_id',user()->id);
        })->latest()->paginate(maxPaginateNo());    
        return $data;
    }

    public function getAffiliateEarningsByUserIdAndReferredUserId($userId, $referredUserId)
    {
        return AffiliateEarning::query()
            ->where("user_id", $userId)
            ->where("referred_user_id", $referredUserId)
            ->get();
    }

    public function storeAffiliateEarningAndUserBalanceUpdate(object $subscriptionUser): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $commissionRate = getAffiliateCommissionRate();
        $amount         = percentageCalculations($subscriptionUser->price, $commissionRate);

        $dataArr = [
            "user_id"              => $subscriptionUser->user_id,
            "referred_user_id"     => $subscriptionUser->user?->referred_user_id,
            "subscription_user_id" => $subscriptionUser->id,
            "amount"               => $amount,
            "commission_rate"      => $commissionRate,
            "is_active"            => appStatic()::ACTIVE,
        ];

        $affiliateEarning = AffiliateEarning::query()->create($dataArr);

        // Update User Balance
        $this->updateUserBalance($subscriptionUser->user->referrer, $affiliateEarning->amount);

        return $affiliateEarning;
    }

    public function updateUserBalance(object $user, $amount = 0): object
    {
        $user->update([
            "user_balance" => $user->user_balance + $amount
        ]);

        return $user;
    }
}