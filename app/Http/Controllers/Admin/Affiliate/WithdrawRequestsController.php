<?php

namespace App\Http\Controllers\Admin\Affiliate;

use App\Http\Requests\Affiliate\WithdrawRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AffiliatePayment;
use App\Http\Controllers\Controller;
use App\Models\AffiliatePayoutAccount;

class WithdrawRequestsController extends Controller
{
    public function index()
    {
        $user = user();
        $paymentHistories = AffiliatePayment::query()->where('status', 'requested');
        if ($user->user_type == "customer") {
            $paymentHistories = $paymentHistories->where('user_id', $user->id)->latest();
        } else {           
            $paymentHistories = $paymentHistories->latest();
        }
        $paymentHistories = $paymentHistories->paginate(maxPaginateNo());
        return view('backend.admin.affiliate.withdrawRequests', compact('paymentHistories'));
    }

    public function store(WithdrawRequest $request)
    {
        try{
            \DB::beginTransaction();

            $paymentAccount = AffiliatePayoutAccount::query()->findOrFail($request->payout_account_id);
            $user           = user();

            if (priceToUsd($request->amount) < getSetting('minimum_withdrawal_amount')) {

                flashMessage(localize('Your payout amount can not be less than the minimum withdrawal amount'),"error");

                return back();
            }

            if (priceToUsd($request->amount) > $user->user_balance) {

                flashMessage(localize('Your balance is lower than withdrawal amount'),"error");

                return back();
            }

            $affiliatePayment = AffiliatePayment::query()->create([
                'user_id'          => $user->id,
                'amount'           => priceToUsd($request->amount),
                'payment_method'   => $paymentAccount->payment_method,
                'additional_info'  => $paymentAccount->additional_info,
            ]);

            $user->update([
                "user_balance" => $user->user_balance - priceToUsd($request->amount)
            ]);

            flashMessage(localize('Your payout request has been submitted'),"error");

            \DB::commit();

            return back();
        }
        catch(\Throwable $e){
            \DB::rollBack();

            wLog("Failed to create Withdraw Request", errorArray($e));

            flashMessage(localize('Failed to create Withdraw Request')." ".$e->getMessage(),"error");

            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $history = AffiliatePayment::query()->findOrFail($request->id);
        $user    = User::query()->findOrFail($history->user_id);

        if ($request->status == "cancelled") {
            $user->user_balance += $history->amount;
            $user->save();
        }

        $history->status = $request->status;
        $history->remarks = $request->remarks;
        $history->save();

        localize('Status has been updated successfully');

        return back();
    }
}
