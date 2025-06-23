<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class SubscriptionPlan extends Model
{
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    use SoftDeletes;

    protected $table = 'subscription_plans';

    protected $fillable = [
            "show_facebook_platform",
            "allow_facebook_platform",
            "show_instagram_platform",
            "allow_instagram_platform",
            "show_twitter_platform",
            "allow_twitter_platform",
            "show_linkedin_platform",
            "allow_linkedin_platform",
            "show_whatsapp_platform",
            "allow_whatsapp_platform",
            "show_pinterest_platform",
            "allow_pinterest_platform",
            "show_youtube_platform",
            "allow_youtube_platform",
            "total_social_platform_account_per_month",
            "show_total_social_platform_account",
            "total_social_platform_post_per_month",
            "show_total_social_platform_post",
            "show_schedule_posting",
            "allow_schedule_posting",
            "show_ai_assistant",
            "allow_ai_assistant",
            
            "has_monthly_limit",
            "title",
            "slug",
            "user_id",
            "duration",
            "openai_model",
            "description",
            "package_type",
            "price",
            "discount_price",
            "discount_type",
            "discount",
            "discount_status",
            "discount_start_date",
            "discount_end_date",

            "allow_seo",
            "total_seo_balance_per_month",

            "show_seo_keyword",
            "allow_seo_keyword",

            "show_seo_helpful_content",
            "allow_seo_helpful_content",

            "show_seo_content_optimization",
            "allow_seo_content_optimization",

            "total_words_per_month",
            "speech_to_text_filesize_limit",
            "allow_words",
            "show_words",
            "allow_unlimited_word",
            "allow_text_to_speech",
            "show_text_to_speech",
            "allow_ai_code",
            "show_ai_code",
            "allow_ai_product_shot",
            "show_ai_product_shot",
            "allow_ai_photo_studio",
            "show_ai_photo_studio",
            "allow_ai_avatar_pro",
            "show_ai_avatar_pro",
            "total_text_to_speech_per_month",
            "allow_unlimited_text_to_speech",
            "allow_text_to_speech_open_ai",
            "show_text_to_speech_open_ai",

            "total_brand_voice",
            "allow_brand_voice",
            "show_brand_voice",
            "allow_clone_voice",
            "show_clone_voice",

            "allow_google_cloud",
            "show_google_cloud",
            "allow_azure",
            "show_azure",
            "allow_unlimited_ai_video",
            "total_ai_video_per_month",
            "allow_ai_video",
            "show_ai_video",
            "allow_ai_chat",
            "show_ai_chat",
            "allow_templates",
            "show_templates",
            "show_ai_writer",
            "allow_ai_writer",
            "allow_ai_rewriter",
            "show_ai_rewriter",
            "allow_ai_detector",
            "show_ai_detector",
            "allow_ai_plagiarism",
            "show_ai_plagiarism",
            "allow_ai_image_chat",
            "show_ai_image_chat",
            "total_speech_to_text_per_month",
            "allow_speech_to_text",
            "show_speech_to_text",
            "allow_unlimited_speech_to_text",
            "total_images_per_month",
            "allow_unlimited_image",
            "allow_images",
            "show_images",
            "allow_sd_images",
            "show_sd_images",
            "allow_dall_e_2_image",
            "show_dall_e_2_image",
            "allow_dall_e_3_image",
            "show_dall_e_3_image",
            "allow_ai_pdf_chat",
            "show_ai_pdf_chat",
            "allow_eleven_labs",
            "show_eleven_labs",
            "allow_real_time_data",
            "show_real_time_data",
            "allow_blog_wizard",
            "show_blog_wizard",
            "allow_ai_vision",
            "show_ai_vision",
            "allow_team",
            "show_team",
            "allow_wordpress",
            "show_wordpress",
            "show_open_ai_model",
            "show_live_support",
            "show_free_support",
            "has_live_support",
            "has_free_support",
            "is_featured",
            "other_features",
            "is_active",
            "created_by_id",
            "updated_by_id",
            "created_at",
            "updated_at",
            "deleted_at"
    ];
    public function scopeFilters($query)
    {
        $request = request();

        // Is Active
        if ($request->has("package_type")) {
            $query->where('package_type', $request->package_type);
        }

        // When package type is monthly add starter to the query
        if((string) $request->package_type === 'monthly' && !isCustomer()){
            $query->orWhere('package_type', 'starter');
        }

        // Search
        if ($request->has("search")) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return $query;
    }
    public function subscription_plan_templates()
    {
        return $this->belongsToMany(Template::class, 'subscription_plan_templates', 'subscription_plan_id', 'template_id');
    }
}
