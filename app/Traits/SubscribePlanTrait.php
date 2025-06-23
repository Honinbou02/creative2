<?php

namespace App\Traits;

use App\Models\User;
use App\Models\AffiliateEarning;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionUser;
use App\Services\Model\Affiliate\AffiliateService;
use App\Traits\File\FileUploadTrait;
use App\Models\SubscriptionUserUsage;

trait SubscribePlanTrait {
    use FileUploadTrait;
    public function storeSubscriptionUser($request)
    {
        try {
            $plan_id             = $request->package_id ?? $request->plan_id; // Question: how can we get plan_id from request?
            $plan_id             = $plan_id ?? session('plan_id');

            $user_id             = intval($request->user_id);
            $user                = $user_id ? User::query()->findOrFail($user_id) : user();
            
            $is_offline_payment  = $request->is_offline;
            
            $payment_status      = $is_offline_payment ? appStatic()::PAYMENT_STATUS_PENDING : appStatic()::PAYMENT_STATUS_PAID;
            $subscription_status = $is_offline_payment ? appStatic()::PLAN_STATUS_PENDING : appStatic()::PLAN_STATUS_ACTIVE;
            $forcefully_active   = $is_offline_payment ? 0 : 1;

            //TODO:: Service file call require
            $plan                = SubscriptionPlan::query()->findOrFail($plan_id);
            $file                = $request->file ? $this->fileProcess($request->file, fileService()::DIR_MEDIA, false, $height = 800, $width  = 800, $fileOriginalName = true) : null;

            return SubscriptionUser::query()->create([
                'start_at'             => date('Y-m-d'),
                'expire_at'            => $is_offline_payment ? null : planEndDate($plan_id),
                'subscription_plan_id' => $plan_id,
                'subscription_status'  => $subscription_status,
                'payment_status'       => $payment_status,
                'price'                => $plan->price,
                'payment_gateway_id'   => $request->payment_method,
                'offline_payment_id'   => $request->offline_payment_method,
                'payment_details'      => $request->payment_details,
                'note'                 => $request->note,
                'forcefully_active'    => $forcefully_active,
                'is_active'            => 1,
                'file'                 => $file,
                'created_by_id'        => $user->id,
                'user_id'              => $user->id,
            ]);
        } catch (\Throwable $th) {
            //throw $th;            
            throw new \RuntimeException($th->getMessage(), $th->getCode());
        }
    }
    public function paymentStatus($subscription_user_id, $payment_status = null, $data =[])
    {
        $subscription_user = SubscriptionUser::query()->findOrFail($subscription_user_id);

        if(isPaid($payment_status)) {

            // Assign the subscription plan usages balances
           $subscriptionUsage = $this->storeSubscriptionPlanUserUsageFromSubscriptionPlanTrait($subscription_user);  // SubscriptionUserUsage.php

           //[TODO::expire previous plan]
            $userSubscriptionExpire = $this->makeExistingUserPlanExpire($subscription_user->user); // SubscriptionUser.php

            // Update Subscription
            $updateSubscriptionUser = $this->updateSubscriptionUserExpirationStatusAndPaymentStatus($subscription_user); // SubscriptionUser.php

            // Update Purchasing user referred user affiliate balance as per settings
            $earning = $this->updatePurchasingUserReferredUserBalance($subscription_user);

            // Update User current subscription
            $userPlan = $this->updateUserCurrentSubscriptionPlanId($subscription_user); // User.php
        }
        else if(isPaymentRejected($payment_status)){
            $subscription_user->update([
                'subscription_status' => appStatic()::PLAN_STATUS_REJECTED,
                'payment_status'      => appStatic()::PAYMENT_STATUS_REJECTED
            ]);
        }
        else if(isPaymentResubmit($payment_status)){
            $feedback_note = array_key_exists('feedback_note', $data) ? $data['feedback_note'] : null;
            $subscription_user->update([
                'feedback_note'  => $feedback_note,
                'payment_status' => appStatic()::PAYMENT_STATUS_RESUBMIT
            ]);
        }


        return $subscription_user;
    }

    public function updatePurchasingUserReferredUserBalance(object $subscriptionUser): object
    {
        // Check Affiliate earning settings is enabled
        $isAffiliateEnable = (int) getSetting('enable_affiliate_system');

        // When $isAffiliateEnable == 0 means affiliate earning is disabled.
        if($isAffiliateEnable === 0) {
            return $subscriptionUser;
        }

        // Who is purchasing the plan or subscription
        $purchasingUser = $subscriptionUser->user;

        $storeAffiliateEarning = false;

        // If referred user exist
        if(!empty($purchasingUser->referred_user_id))  {

            // Referrer of the purchasing user
            $referrer = $purchasingUser->referrer;


            // Get the Referral earning settings. Will get 0 either 1. 0 means one time earning policy, 1 means continuous earning policy
            $referralEarningSettings = getSetting("enable_affiliate_continuous_commission");


            if(isOneTimeAffiliateEarning($referralEarningSettings)) {


                // Check if the referrer already earned referral commission
                $isReferredUserAlreadyEarnedCommission = (new AffiliateService())->getAffiliateEarningsByUserIdAndReferredUserId(
                    $purchasingUser->id,
                    $referrer->id
                );

                // Referrer never earned commission
                if($isReferredUserAlreadyEarnedCommission->count() <= 0) {
                    $storeAffiliateEarning = true;
                }
            }else{
                // Add New Earning from subscription purchase as referral commission
                $storeAffiliateEarning = true;
            }
        }

        if($storeAffiliateEarning){

            $affiliateEarning = (new AffiliateService())->storeAffiliateEarningAndUserBalanceUpdate($subscriptionUser);
        }

        return $subscriptionUser;
    }

    /**
     * Will update,
     *
     * start_at as today's date
     * expire_at based on subscription plan id monthly/yearly
     * subscription_status as Active
     * payment_status as paid.
     * */
    public function updateSubscriptionUserExpirationStatusAndPaymentStatus(object $subscriptionUser)
    {
        $subscriptionUser->update([
            'start_at'            => date('Y-m-d'),
            'expire_at'           => planEndDate($subscriptionUser->subscription_plan_id),
            'subscription_status' => appStatic()::PLAN_STATUS_ACTIVE,
            'payment_status'      => appStatic()::PAYMENT_STATUS_PAID
        ]);

        return $subscriptionUser;
    }

    /**
     * Will update User.php
     *
     * subscription_plan_id
     * */
    public function updateUserCurrentSubscriptionPlanId(object $subscriptionUser): object
    {
        $subscriptionUser->user?->update([
            'subscription_plan_id'=>$subscriptionUser->subscription_plan_id
        ]);

        return $subscriptionUser->user;
    }
    
    
    public function storeSubscriptionPlanUserUsageFromSubscriptionPlanTrait(object $subscriptionUser): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $plan = $subscriptionUser->plan;

        $payloadArr = [
            'subscription_user_id'           => $subscriptionUser->id,
            'subscription_plan_id'           => $plan->id,
            'start_at'                       => date('Y-m-d'),
            'expire_at'                      => planEndDate($plan->id),
            'platform'                       => 1,
            'has_monthly_limit'              => 1,

            // Words
            'word_balance'                   => $plan->total_words_per_month ?? 0,
            'word_balance_used'              => 0,
            'word_balance_remaining'         => $plan->total_words_per_month ?? 0,
            'word_balance_t2s'               => $plan->total_text_to_speech_per_month ?? 0,
            'word_balance_used_t2s'          => 0,
            'word_balance_remaining_t2s'     => $plan->total_text_to_speech_per_month ?? 0,

            // SEO
            "seo_balance"                    => $plan->total_seo_balance_per_month ?? 0,
            "seo_balance_used"               => 0,
            "seo_balance_remaining"          => $plan->total_seo_balance_per_month ?? 0,

            // Image
            'image_balance'                  => $plan->total_images_per_month ?? 0,
            'image_balance_used'             => 0,
            'image_balance_remaining'        => $plan->total_images_per_month ?? 0,

            //Video
            'video_balance'                  => $plan->total_ai_video_per_month ?? 0,
            'video_balance_used'             => 0,
            'video_balance_remaining'        => $plan->total_ai_video_per_month ?? 0,

            //Speech
            'speech_balance'                 => $plan->total_speech_to_text_per_month ?? 0,
            'speech_balance_used'            => 0,
            'speech_balance_remaining'       => $plan->total_speech_to_text_per_month ?? 0,

            // social accounts
            'total_social_platform_account_per_month'           => $plan->total_social_platform_account_per_month ?? 0,
            'total_social_platform_account_per_month_used'      => 0,
            'total_social_platform_account_per_month_remaining' => $plan->total_social_platform_account_per_month ?? 0,
            
            // social post
            'total_social_platform_post_per_month'              => $plan->total_social_platform_post_per_month ?? 0,
            'total_social_platform_post_per_month_used'         => 0,
            'total_social_platform_post_per_month_remaining'    => $plan->total_social_platform_post_per_month ?? 0,

            //Allow
            'allow_unlimited_word'           => $plan->allow_unlimited_word ?? 0,
            'allow_unlimited_text_to_speech' => $plan->allow_unlimited_text_to_speech ?? 0,
            'allow_unlimited_image'          => $plan->allow_unlimited_image ?? 0,
            'allow_unlimited_speech_to_text' => $plan->allow_unlimited_speech_to_text ?? 0,
            'speech_to_text_filesize_limit'  => $plan->speech_to_text_filesize_limit ?? 0,
            'allow_words'                    => $plan->allow_words ?? 0,
            'allow_ai_product_shot'          => $plan->allow_ai_product_shot ?? 0,
            'allow_ai_photo_studio'          => $plan->allow_ai_photo_studio ?? 0,
            'allow_ai_avatar_pro'            => $plan->allow_ai_avatar_pro ?? 0,
            'allow_text_to_speech'           => $plan->allow_text_to_speech ?? 0,
            'allow_ai_code'                  => $plan->allow_ai_code ?? 0,
            'allow_google_cloud'             => $plan->allow_google_cloud ?? 0,
            'allow_azure'                    => $plan->allow_azure ?? 0,
            'allow_ai_video'                 => $plan->allow_ai_video ?? 0,
            'allow_ai_chat'                  => $plan->allow_ai_chat ?? 0,
            'allow_templates'                => $plan->allow_templates ?? 0,
            'allow_ai_rewriter'              => $plan->allow_ai_rewriter ?? 0,
            'allow_ai_detector'              => $plan->allow_ai_detector ?? 0,
            'allow_ai_plagiarism'            => $plan->allow_ai_plagiarism ?? 0,
            'allow_ai_image_chat'            => $plan->allow_ai_image_chat ?? 0,
            'allow_speech_to_text'           => $plan->allow_speech_to_text ?? 0,
            'allow_images'                   => $plan->allow_images ?? 0,
            'allow_sd_images'                => $plan->allow_sd_images ?? 0,
            'allow_dall_e_2_image'           => $plan->allow_dall_e_2_image ?? 0,
            'allow_dall_e_3_image'           => $plan->allow_dall_e_3_image ?? 0,
            'allow_ai_pdf_chat'              => $plan->allow_ai_pdf_chat ?? 0,
            'allow_eleven_labs'              => $plan->allow_eleven_labs ?? 0,
            'allow_real_time_data'           => $plan->allow_real_time_data ?? 0,
            'allow_blog_wizard'              => $plan->allow_blog_wizard ?? 0,
            'allow_ai_vision'                => $plan->allow_ai_vision ?? 0,
            'allow_team'                     => $plan->allow_team ?? 0,
            'allow_wordpress'                => $plan->allow_wordpress ?? 0,
            'allow_seo_content_optimization' => $plan->allow_seo_content_optimization ?? 0,

            'allow_facebook_platform'                           => $plan->allow_facebook_platform ?? 0,
            'allow_instagram_platform'                          => $plan->allow_instagram_platform ?? 0,
            'allow_twitter_platform'                            => $plan->allow_twitter_platform ?? 0,
            'allow_linkedin_platform'                           => $plan->allow_linkedin_platform ?? 0,
            'allow_whatsapp_platform'                           => $plan->allow_whatsapp_platform ?? 0,
            'allow_pinterest_platform'                          => $plan->allow_pinterest_platform ?? 0,
            'allow_youtube_platform'                            => $plan->allow_youtube_platform ?? 0,

            'allow_schedule_posting'                            => $plan->allow_schedule_posting ?? 0,
            'allow_ai_assistant'                                => $plan->allow_ai_assistant ?? 0,

            // Support
            'has_free_support'               => $plan->has_free_support ?? 0,
            'is_active'                      => 1,
            'user_id'                        => $subscriptionUser->user_id, // Customer ID
            'created_by_id'                  => userID(),
            'subscription_status'            => appStatic()::PLAN_STATUS_ACTIVE,
        ];

        return SubscriptionUserUsage::query()->create($payloadArr);
    }

    public function makeExistingUserPlanExpire(object $user)
    {
        // Making Subscription as expired
        $payloadsArr = [
            "subscription_status" => appStatic()::SUBSCRIPTION_STATUS_EXPIRED,
        ];

        if(isAdmin()){
            $payloadsArr["expire_by_admin_date"] = now()->format("Y-m-d H:i:s");
        }

        $subUserObj = SubscriptionUser::query()
            ->where("user_id", $user->id)
            ->where('subscription_status', appStatic()::PLAN_STATUS_ACTIVE)
            ->update($payloadsArr);
     

        // Expire User SubscriptionUserUsage too.
        $subUserUsageObj = SubscriptionUserUsage::query()
            ->where("user_id", $user->id)
            ->where('subscription_status', appStatic()::PLAN_STATUS_ACTIVE)
            ->update([
                "subscription_status" => appStatic()::SUBSCRIPTION_STATUS_EXPIRED,
                "expire_at"           => now()->format("Y-m-d"),
            ]);

        return $subUserObj;
    }

    public function affiliate_system($subscription_user_id, $user_id, $price)
    {
        $user = $user_id ? User::findOrFail($user_id) : auth()->user();
        if (getSetting('enable_affiliate_system') == '1') {
            if (!is_null($user->referred_by)) {

                $giveCommission = false;
                if (getSetting('enable_affiliate_continuous_commission') == "1") {
                    $giveCommission = true;
                    $user->is_commission_calculated = 0;
                } else if ($user->is_commission_calculated == 0) {
                    $giveCommission = true;
                }

                if ($giveCommission) {
                    $referredBy = User::where('id', $user->referred_by)->first();
                    if (!is_null($referredBy)) {
                        $earning = new AffiliateEarning;
                        $earning->user_id = $user->id;
                        $earning->referred_by = $referredBy->id;
                        $earning->subscription_user_id = $subscription_user_id;
                        $earning->amount = ((float) $price * (float) getSetting('affiliate_commission')) / 100;
                        $earning->commission_rate = getSetting('affiliate_commission');
                        $earning->save();

                        $referredBy->user_balance += (float) $earning->amount;
                        $referredBy->save();
                    }
                }
            }
        }
    }
    private function limitPackagePurchase($userId = null)
    {
        $user = $userId ? User::find((int)$userId) : auth()->user();
        if (isCustomer() || $userId) {
            $package_count = SubscriptionUser::where('user_id', $user->id)->whereIn('subscription_status', [1, 3])->count();
            if ($package_count >= 2) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    public function tempSubscriptionUserStore(
        $planId,
        $amount,
        $paymentGatewayId,
        $paymentDetails,
        $userId
    ): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {

        return SubscriptionUser::query()->create([
            'start_at'             => date('Y-m-d'),
            'expire_at'            => planEndDate($planId),
            'subscription_plan_id' => $planId,
            'subscription_status'  => appStatic()::PLAN_STATUS_ACTIVE,
            'payment_status'       => appStatic()::PAYMENT_STATUS_PAID,
            'price'                => $amount,
            'payment_gateway_id'   => $paymentGatewayId,
            'payment_details'      => $paymentDetails,
            'note'                 => '',
            'forcefully_active'    => 1,
            'is_active'            => 1,
            'created_by_id'        => $userId,
            'user_id'              => $userId,
        ]);
    }


}