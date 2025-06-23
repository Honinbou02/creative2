<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class SubscriptionUserUsage extends Model
{
    use HasFactory;
    use SoftDeletes;
    use IsActiveTrait;
    use CreatedUpdatedByRelationshipTrait;

    protected $table = 'subscription_user_usages';
    protected $fillable = [
        "user_id",
        "subscription_user_id",
        "subscription_plan_id",
        "subscription_status",
        "platform",
        "has_monthly_limit",
        "start_at",
        "expire_at",
        "openai_model",
        "word_balance",
        "word_balance_used",
        "word_balance_remaining",
        "word_balance_t2s",
        "word_balance_used_t2s",
        "word_balance_remaining_t2s",
        "total_seo_balance",
        "seo_balance_used",
        "seo_balance_remaining",
        "image_balance",
        "image_balance_used",
        "image_balance_remaining",
        "video_balance",
        "video_balance_used",
        "video_balance_remaining",
        "speech_balance",
        "speech_balance_used",
        "speech_balance_remaining",
        "allow_unlimited_word",
        "allow_unlimited_text_to_speech",
        "allow_unlimited_image",
        "allow_unlimited_speech_to_text",
        "allow_unlimited_ai_video",
        "speech_to_text_filesize_limit",
        "allow_words",
        "allow_ai_code",
        "allow_ai_chat",
        "allow_ai_pdf_chat",
        "allow_templates",
        "allow_ai_writer",
        "allow_ai_rewriter",
        "allow_ai_detector",
        "allow_ai_plagiarism",
        "allow_real_time_data",
        "allow_blog_wizard",
        "allow_ai_product_shot",
        "allow_ai_photo_studio",
        "allow_ai_avatar_pro",
        "allow_text_to_speech",
        "allow_text_to_speech_open_ai",
        "total_brand_voice",
        "allow_brand_voice",
        "allow_clone_voice",
        "allow_google_cloud",
        "allow_azure",
        "allow_eleven_labs",
        "allow_ai_video",
        "allow_speech_to_text",
        "allow_images",
        "allow_ai_image_chat",
        "allow_sd_images",
        "allow_dall_e_2_image",
        "allow_dall_e_3_image",
        "allow_ai_vision",
        "allow_team",
        'allow_wordpress',
        'allow_seo_content_optimization',
        "has_free_support",
        "is_active",
        "created_by_id",
        "updated_by_id",
        "deleted_at",
        
        "allow_facebook_platform",
        "allow_instagram_platform",
        "allow_twitter_platform",
        "allow_linkedin_platform",
        "allow_whatsapp_platform",
        "allow_pinterest_platform",
        "allow_youtube_platform",
        "total_social_platform_account_per_month",
        "total_social_platform_account_per_month_used",
        "total_social_platform_account_per_month_remaining",
        "total_social_platform_post_per_month",
        "total_social_platform_post_per_month_used",
        "total_social_platform_post_per_month_remaining",
        "allow_schedule_posting",
        "allow_ai_assistant",
    ];
}
