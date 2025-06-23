<?php

namespace App\Services\Business;

use App\Models\SubscriptionUser;
use App\Models\SubscriptionUserUsage;

/**
 * Class SubscriptionService.
 */
class SubscriptionService
{
    public function assignSubscriptionPlan($payloads)
    {
        $subscription_plan_id = $payloads->subscription_plan_id;
        $appStatic            = appStatic();

        return SubscriptionUser::query()->create([
            "start_at"             => date('Y-m-d'),
            "expire_at"            => planEndDate($subscription_plan_id),
            "subscription_plan_id" => $subscription_plan_id,
            "subscription_status"  => $appStatic::PLAN_STATUS_ACTIVE,
            "payment_status"       => $appStatic::PAYMENT_STATUS_PAID,
            "price"                => $payloads->payment_amount,
            "payment_gateway_id"   => $payloads->payment_method,
            "payment_details"      => $payloads->payment_details,
            "note"                 => $payloads->note,
            "forcefully_active"    => $appStatic::ACTIVE,
            "is_active"            => $appStatic::ACTIVE,
            "created_by_id"        => $payloads->user_id,
            "user_id"              => session()->get('s_customer_id'),
        ]);
    }

    public function assignSubscriptionPlanUsage(object $subscriptionUser): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $plan                 = $subscriptionUser->plan;
        $subscription_user_id = $subscriptionUser->id;

        return SubscriptionUserUsage::query()->create([
            "subscription_user_id"           => $subscription_user_id,
            "subscription_plan_id"           => $plan->id,
            "start_at"                       => date('Y-m-d'),
            "expire_at"                      => planEndDate($plan->id),
            "platform"                       => 1,
            "has_monthly_limit"              => 1,
            "word_balance"                   => $plan->total_words_per_month ?? 0,
            "word_balance_used"              => 0,
            "word_balance_remaining"         => $plan->total_words_per_month ?? 0,
            "word_balance_t2s"               => $plan->total_text_to_speech_per_month ?? 0,
            "word_balance_used_t2s"          => 0,
            "word_balance_remaining_t2s"     => $plan->total_text_to_speech_per_month ?? 0,
            "image_balance"                  => $plan->total_images_per_month ?? 0,
            "image_balance_used"             => 0,
            "image_balance_remaining"        => $plan->total_images_per_month ?? 0,
            "video_balance"                  => $plan->total_ai_video_per_month ?? 0,
            "video_balance_used"             => 0,
            "video_balance_remaining"        => $plan->total_ai_video_per_month ?? 0,
            "speech_balance"                 => $plan->total_speech_to_text_per_month ?? 0,
            "speech_balance_used"            => 0,
            "speech_balance_remaining"       => $plan->total_speech_to_text_per_month ?? 0,
            "allow_unlimited_word"           => $plan->allow_unlimited_word ?? 0,
            "allow_unlimited_text_to_speech" => $plan->allow_unlimited_text_to_speech ?? 0,
            "allow_unlimited_image"          => $plan->allow_unlimited_image ?? 0,
            "allow_unlimited_speech_to_text" => $plan->allow_unlimited_speech_to_text ?? 0,
            "speech_to_text_filesize_limit"  => $plan->speech_to_text_filesize_limit ?? 0,
            "allow_words"                    => $plan->allow_words ?? 0,
            "allow_text_to_speech"           => $plan->allow_text_to_speech ?? 0,
            "allow_ai_code"                  => $plan->allow_ai_code ?? 0,
            "allow_google_cloud"             => $plan->allow_google_cloud ?? 0,
            "allow_azure"                    => $plan->allow_azure ?? 0,
            "allow_ai_video"                 => $plan->allow_ai_video ?? 0,
            "allow_ai_chat"                  => $plan->allow_ai_chat ?? 0,
            "allow_templates"                => $plan->allow_templates ?? 0,
            "allow_ai_rewriter"              => $plan->allow_ai_rewriter ?? 0,
            "allow_ai_detector"              => $plan->allow_ai_detector ?? 0,
            "allow_ai_plagiarism"            => $plan->allow_ai_plagiarism ?? 0,
            "allow_ai_image_chat"            => $plan->allow_ai_image_chat ?? 0,
            "allow_speech_to_text"           => $plan->allow_speech_to_text ?? 0,
            "allow_images"                   => $plan->allow_images ?? 0,
            "allow_sd_images"                => $plan->allow_sd_images ?? 0,
            "allow_dall_e_2_image"           => $plan->allow_dall_e_2_image ?? 0,
            "allow_dall_e_3_image"           => $plan->allow_dall_e_3_image ?? 0,
            "allow_ai_pdf_chat"              => $plan->allow_ai_pdf_chat ?? 0,
            "allow_eleven_labs"              => $plan->allow_eleven_labs ?? 0,
            "allow_real_time_data"           => $plan->allow_real_time_data ?? 0,
            "allow_blog_wizard"              => $plan->allow_blog_wizard ?? 0,
            "allow_ai_vision"                => $plan->allow_ai_vision ?? 0,
            "allow_team"                     => $plan->allow_team ?? 0,
            "allow_wordpress"                => $plan->allow_wordpress ?? 0,
            "allow_seo_content_optimization" => $plan->allow_seo_content_optimization ?? 0,
            "has_free_support"               => $plan->has_free_support ?? 0,
            "is_active"                      => \appStatic()::ACTIVE,
            "user_id"                        => $subscriptionUser->user_id,
            "created_by_id"                  => $subscriptionUser->created_by_id,
            "subscription_status"            => appStatic()::PLAN_STATUS_ACTIVE,

            
            // social accounts
            'total_social_platform_account_per_month'           => $plan->total_social_platform_account_per_month ?? 0,
            'total_social_platform_account_per_month_used'      => 0,
            'total_social_platform_account_per_month_remaining' => $plan->total_social_platform_account_per_month ?? 0,
            
            // social post
            'total_social_platform_post_per_month'              => $plan->total_social_platform_post_per_month ?? 0,
            'total_social_platform_post_per_month_used'         => 0,
            'total_social_platform_post_per_month_remaining'    => $plan->total_social_platform_post_per_month ?? 0,

            //Allow
            'allow_facebook_platform'                           => $plan->allow_facebook_platform ?? 0,
            'allow_instagram_platform'                          => $plan->allow_instagram_platform ?? 0,
            'allow_twitter_platform'                            => $plan->allow_twitter_platform ?? 0,
            'allow_linkedin_platform'                           => $plan->allow_linkedin_platform ?? 0,
            'allow_whatsapp_platform'                           => $plan->allow_whatsapp_platform ?? 0,
            'allow_pinterest_platform'                          => $plan->allow_pinterest_platform ?? 0,
            'allow_youtube_platform'                            => $plan->allow_youtube_platform ?? 0,

            'allow_schedule_posting'                            => $plan->allow_schedule_posting ?? 0,
            'allow_ai_assistant'                                => $plan->allow_ai_assistant ?? 0,
        ]);
    }

    public function getSubscriptionUserUsageByUserIdAndSubscriptionPlanId($userId, $subscriptionPlanId)
    {

        return SubscriptionUserUsage::query()
            ->where('user_id', $userId)
            ->where('subscription_plan_id', $subscriptionPlanId)
            ->latest()
            ->first();
    }

    public function getSubscriptionUserByUserIdAndSubscriptionId($userId, $subscriptionPlanId)
    {
        return SubscriptionUser::query()
            ->where('user_id', $userId)
            ->where('subscription_plan_id', $subscriptionPlanId)
            ->where('subscription_status', appStatic()::PLAN_STATUS_ACTIVE)
            ->first() ?? [];
    }
}
