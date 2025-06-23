<?php

namespace App\Services\Model\Customer;

use App\Models\User;
use App\Services\Model\User\UserService;
use App\Models\PaymentGateway;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionUser;
use App\Models\SubscriptionUserUsage;
use Illuminate\Support\Facades\Hash;
use App\Services\Model\SubscriptionPlan\SubscriptionPlanService;
use App\Traits\SubscribePlanTrait;
use Carbon\Carbon;

class CustomerService
{
    use SubscribePlanTrait;
    
    public function index(): array
    {
        $data = [];
        $data["customers"] = (new UserService())->getAll(
            true,
            null,
            appStatic()::TYPE_CUSTOMER, false, ['plan']
        );

        $data["payment_gateways"] = PaymentGateway::where('is_active', 1)->get();
        $data["plans"]            = (new SubscriptionPlanService())->getAll(true, true, [], true);
        return $data;
    }
    public function getAll(
        $isPaginateGetOrPluck = null,
        $onlyActives = null,
        $withRelationships = ["updatedBy", "createdBy"]
    ) {
        $request = request();

        $query = User::query()->orderBy('id', 'DESC')->filters()->where('user_type', appStatic()::TYPE_CUSTOMER);

        // Bind Relationships
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if (!is_null($onlyActives)) {
            $query->isActive($onlyActives);
        }
        
        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("name", "id");
        }

        return $isPaginateGetOrPluck ? $query->paginate(maxPaginateNo()) : $query->get();
    }
    public function findUserById($id, $withRelationships = [], $conditions = [])
    {
        $query = User::query();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        if(!empty($conditions)){
            $query->where($conditions);
        }
        
        return $query->findOrFail($id);
    }

    public function store(object $payloads)
    {
        $subscription_plan_id       = isset($payloads->assign_plan) && !empty($payloads->subscription_plan_id) ? (int) $payloads->subscription_plan_id : null;
        
        $user                       = new User();
        $user->name                 = $payloads->name;
        $user->email                = $payloads->email;
        $user->mobile_no            = $payloads->mobile_no;
        $user->user_type            = appStatic()::TYPE_CUSTOMER;
        $user->avatar               = $payloads->avatar;
        $user->subscription_plan_id = $subscription_plan_id;
        $user->is_active            = $payloads->is_active;
        $user->email_verified_at    = Carbon::now();
        $user->password             = Hash::make($payloads->password);
        $user->save();
        
        if(!empty($subscription_plan_id)){
            $plan = SubscriptionPlan::findOrFail($subscription_plan_id);
            if ($plan) {
                $this->makeExistingUserPlanExpire($user);
                session()->put('s_customer_id', $user->id);
                $subscriptionUser = $this->storeSubscriptionPlanUser($payloads, $subscription_plan_id);
                $this->storeSubscriptionPlanUserUsage($subscriptionUser->id, $plan);

                $package = $plan->package_type == 'starter' ? localize('Monthly') : localize($plan->package_type);
                $data['package']    = html_entity_decode($plan->title) .'/'.$package;
                $data['price']      = $subscriptionUser->price;
                $data['start_date'] = $subscriptionUser->start_at;
                $data['end_date']   = $subscriptionUser->expire_at;
                $data['method']     = $subscriptionUser->payment_gateway_id ? $subscriptionUser->paymentMethod->name : '';
                if($user->email) {
                    sendMail($user->email,  $user->name, 'add-new-customer-welcome-email', $data);
                }
            }
        }
        
        return $user;
    }
    public function storeSubscriptionPlanUser($payloads, $subscription_plan_id)
    {
        $subscriptionUser = new SubscriptionUser();
        $subscriptionUser->start_at             = date('Y-m-d');
        $subscriptionUser->expire_at            = planEndDate($subscription_plan_id);
        $subscriptionUser->subscription_plan_id = $subscription_plan_id;
        $subscriptionUser->subscription_status  = appStatic()::PLAN_STATUS_ACTIVE;
        $subscriptionUser->payment_status       = appStatic()::PAYMENT_STATUS_PAID;
        $subscriptionUser->price                = $payloads->payment_amount ?? 0;
        $subscriptionUser->payment_gateway_id   = $payloads->payment_method ?? null;
        $subscriptionUser->offline_payment_id   = $payloads->offline_payment_id ?? null;
        $subscriptionUser->payment_details      = $payloads->payment_details ?? null;
        $subscriptionUser->note                 = $payloads->note ?? null;
        $subscriptionUser->forcefully_active    = 1;
        $subscriptionUser->is_active            = 1;
        $subscriptionUser->created_by_id        = userID();
        $subscriptionUser->user_id              = session()->get('s_customer_id');
        
        $subscriptionUser->save();

        return $subscriptionUser;
    }
    public function storeSubscriptionPlanUserUsage($subscription_user_id, $plan)
    {
        $userUsage = new SubscriptionUserUsage();
        $userUsage->subscription_user_id           = $subscription_user_id;
        $userUsage->subscription_plan_id           = $plan->id;
        $userUsage->start_at                       = date('Y-m-d');
        $userUsage->expire_at                      = planEndDate($plan->id);
        $userUsage->platform                       = 1;
        $userUsage->has_monthly_limit              = 1;
        $userUsage->word_balance                   = $plan->total_words_per_month ?? 0;
        $userUsage->word_balance_used              = 0;
        $userUsage->word_balance_remaining         = $plan->total_words_per_month ?? 0;
        $userUsage->word_balance_t2s               = $plan->total_text_to_speech_per_month ?? 0;
        $userUsage->word_balance_used_t2s          = 0;
        $userUsage->word_balance_remaining_t2s     = $plan->total_text_to_speech_per_month ?? 0;
        $userUsage->image_balance                  = $plan->total_images_per_month ?? 0;
        $userUsage->image_balance_used             = 0;
        $userUsage->image_balance_remaining        = $plan->total_images_per_month ?? 0;
        $userUsage->video_balance                  = $plan->total_ai_video_per_month ?? 0;
        $userUsage->video_balance_used             = 0;
        $userUsage->video_balance_remaining        = $plan->total_ai_video_per_month ?? 0;
        $userUsage->speech_balance                 = $plan->total_speech_to_text_per_month ?? 0;
        $userUsage->speech_balance_used            = 0;
        $userUsage->speech_balance_remaining       = $plan->total_speech_to_text_per_month ?? 0;
        $userUsage->allow_unlimited_word           = $plan->allow_unlimited_word ?? 0;
        $userUsage->allow_unlimited_text_to_speech = $plan->allow_unlimited_text_to_speech ?? 0;
        $userUsage->allow_unlimited_image          = $plan->allow_unlimited_image ?? 0;
        $userUsage->allow_unlimited_speech_to_text = $plan->allow_unlimited_speech_to_text ?? 0;
        $userUsage->speech_to_text_filesize_limit  = $plan->speech_to_text_filesize_limit ?? 0;
        $userUsage->allow_words                    = $plan->allow_words ?? 0;
        $userUsage->allow_text_to_speech           = $plan->allow_text_to_speech ?? 0;
        $userUsage->allow_ai_code                  = $plan->allow_ai_code ?? 0;
        $userUsage->allow_google_cloud             = $plan->allow_google_cloud ?? 0;
        $userUsage->allow_azure                    = $plan->allow_azure ?? 0;
        $userUsage->allow_ai_video                 = $plan->allow_ai_video ?? 0;
        $userUsage->allow_ai_chat                  = $plan->allow_ai_chat ?? 0;
        $userUsage->allow_templates                = $plan->allow_templates ?? 0;
        $userUsage->allow_ai_rewriter              = $plan->allow_ai_rewriter ?? 0;
        $userUsage->allow_ai_detector              = $plan->allow_ai_detector ?? 0;
        $userUsage->allow_ai_plagiarism            = $plan->allow_ai_plagiarism ?? 0;
        $userUsage->allow_ai_image_chat            = $plan->allow_ai_image_chat ?? 0;
        $userUsage->allow_speech_to_text           = $plan->allow_speech_to_text ?? 0;
        $userUsage->allow_images                   = $plan->allow_images ?? 0;
        $userUsage->allow_sd_images                = $plan->allow_sd_images ?? 0;
        $userUsage->allow_dall_e_2_image           = $plan->allow_dall_e_2_image ?? 0;
        $userUsage->allow_dall_e_3_image           = $plan->allow_dall_e_3_image ?? 0;
        $userUsage->allow_ai_pdf_chat              = $plan->allow_ai_pdf_chat ?? 0;
        $userUsage->allow_eleven_labs              = $plan->allow_eleven_labs ?? 0;
        $userUsage->allow_real_time_data           = $plan->allow_real_time_data ?? 0;
        $userUsage->allow_blog_wizard              = $plan->allow_blog_wizard ?? 0;
        $userUsage->allow_ai_vision                = $plan->allow_ai_vision ?? 0;
        $userUsage->allow_team                     = $plan->allow_team ?? 0;
        $userUsage->allow_wordpress                = $plan->allow_wordpress ?? 0;
        $userUsage->allow_seo_content_optimization = $plan->allow_seo_content_optimization ?? 0;
        $userUsage->has_free_support               = $plan->has_free_support ?? 0;
        $userUsage->is_active                      = \appStatic()::ACTIVE;
        $userUsage->user_id                        = session()->get('s_customer_id');
        $userUsage->created_by_id                  = userID();
        $userUsage->subscription_status            = appStatic()::PLAN_STATUS_ACTIVE;

        $userUsage->total_social_platform_account_per_month           = $plan->total_social_platform_account_per_month ?? 0;
        $userUsage->total_social_platform_account_per_month_used      = 0;
        $userUsage->total_social_platform_account_per_month_remaining = $plan->total_social_platform_account_per_month ?? 0;
        
        $userUsage->total_social_platform_post_per_month              = $plan->total_social_platform_post_per_month ?? 0;
        $userUsage->total_social_platform_post_per_month_used         = 0;
        $userUsage->total_social_platform_post_per_month_remaining    = $plan->total_social_platform_post_per_month ?? 0;

        $userUsage->allow_facebook_platform                           = $plan->allow_facebook_platform ?? 0;
        $userUsage->allow_instagram_platform                          = $plan->allow_instagram_platform ?? 0;
        $userUsage->allow_twitter_platform                            = $plan->allow_twitter_platform ?? 0;
        $userUsage->allow_linkedin_platform                           = $plan->allow_linkedin_platform ?? 0;
        $userUsage->allow_whatsapp_platform                           = $plan->allow_whatsapp_platform ?? 0;
        $userUsage->allow_pinterest_platform                          = $plan->allow_pinterest_platform ?? 0;
        $userUsage->allow_youtube_platform                            = $plan->allow_youtube_platform ?? 0;
        
        $userUsage->allow_schedule_posting                            = $plan->allow_schedule_posting ?? 0;
        $userUsage->allow_ai_assistant                                = $plan->allow_ai_assistant ?? 0;


        $userUsage->save();
    }
    public function update($id, object $request)
    {
        $user = User::where('id', $id)->first();
        $user->email     = $request->email;
        $user->name      = $request->name;
        $user->mobile_no = $request->mobile_no;
        $user->avatar    = $request->avatar;
        if(!is_null($request->is_active)){
            $user->is_active = $request->is_active;
        }
        $user->save();
        return $user;
    }
    public function existUser($id, $email, $mobile_no = null)
    {
        if($email) {
           return  User::where('id', '!=', $id)->where('email', $email)->first();               
        }
        if($mobile_no) {
           return  User::where('id', '!=', $id)->where('mobile_no', $mobile_no);
        }
        return false;
    }

    public function updateUserSubscriptionPlanId(object $user, $subscription_plan_id)
    {
        $user->update([
            "subscription_plan_id" => $subscription_plan_id
        ]);

        return $user;
    }
    public function assignPackage($request)
    {
        $user    = $this->findUserById((int) $request->id);
        if(!empty($request->assign_subscription_plan_id)){
            $plan = SubscriptionPlan::findOrFail((int) $request->assign_subscription_plan_id);
            if ($plan) {
                
                $this->makeExistingUserPlanExpire($user);
                session()->put('s_customer_id', $request->id);
                $payloads = (object) [
                    'payment_amount'        => $request->assign_payment_amount ?? 0,
                    'payment_method'        => $request->assign_payment_method ?? null,
                    'offline_payment_id'    => $request->assign_offline_payment_method ?? null,
                    'payment_details'       => $request->assign_payment_detail ?? null,
                ];
                
                $subscriptionUser = $this->storeSubscriptionPlanUser($payloads, $request->assign_subscription_plan_id);
                $this->storeSubscriptionPlanUserUsage($subscriptionUser->id, $plan);
                $user->update(['subscription_plan_id' =>  $plan->id]);

                $package = $plan->package_type == 'starter' ? localize('Monthly') : localize($plan->package_type);
                $data['package']    = html_entity_decode($plan->title) .'/'.$package;
                $data['price']      = $subscriptionUser->price;
                $data['start_date'] = $subscriptionUser->start_at;
                $data['end_date']   = $subscriptionUser->expire_at;
                $data['method']     = $subscriptionUser->payment_gateway_id ? $subscriptionUser->paymentMethod->name : '';
                if($user->email) {
                    sendMail($user->email,  $user->name, 'admin-assign-package', $data);
                }
            }
        }
        return $user;
    }
}
