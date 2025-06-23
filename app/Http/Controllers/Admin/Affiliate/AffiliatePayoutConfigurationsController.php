<?php

namespace App\Http\Controllers\Admin\Affiliate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AffiliatePayoutAccount;
use App\Services\Model\Affiliate\AffiliateService;

class AffiliatePayoutConfigurationsController extends Controller
{
    protected $affiliateService;
    public function __construct()
    {
        $this->affiliateService = new AffiliateService();
    }
    public function index()
    {
        $data['user']                          = user();
        $data['activeAffiliatePaymentMethods'] = getSetting('affiliate_payout_payment_methods') != null ? json_decode(getSetting('affiliate_payout_payment_methods')) : [];

        return view('backend.admin.affiliate.configurePayouts', $data);
    }

    public function store(Request $request)
    {
        $user = user();

        $activeAffiliatePaymentMethods = getSetting('affiliate_payout_payment_methods') != null ? json_decode(getSetting('affiliate_payout_payment_methods')) : [];

        foreach ($activeAffiliatePaymentMethods as  $paymentMethod) {
            if ($request[$paymentMethod]) {
                $userPaymentMethod = $user->affiliatePayoutAccounts()->where('payment_method', $paymentMethod)->first();
                if (is_null($userPaymentMethod)) {
                    $userPaymentMethod = new AffiliatePayoutAccount;
                    $userPaymentMethod->user_id = $user->id;
                    $userPaymentMethod->payment_method = $paymentMethod;
                    $userPaymentMethod->account_details = $request[$paymentMethod];
                } else {
                    $userPaymentMethod->account_details = $request[$paymentMethod];
                }

                $userPaymentMethod->save();
            }
        }
        try {
            localize('Payout account has been set successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
        return back();
    }
}
