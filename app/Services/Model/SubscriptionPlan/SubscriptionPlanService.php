<?php

namespace App\Services\Model\SubscriptionPlan;

use App\Models\SubscriptionPlan;
use App\Services\Model\PaymentGateway\PaymentGatewayService;
use App\Services\Model\TemplateCategory\TemplateCategoryService;
use App\Services\Model\OfflinePaymentMethod\OfflinePaymentMethodService;

class SubscriptionPlanService
{
    public function index():array
    {
        $data = [];
        $data["packages"]   = $this->getAll(true, null);
        $data["payments"]   = $this->payments();
        $data["offlinePaymentMethods"]  = (new OfflinePaymentMethodService())->getAll(false, 1);
        return $data;
    }

    public function getAll($isPaginateGetOrPluck = null, $onlyActives = null, $withRelationships = ["updatedBy", "createdBy", 'subscription_plan_templates'], $getAllWithoutPagination = false)
    {
        $query = SubscriptionPlan::query()->filters()->whereNull('deleted_at');

        // Bind Relationships
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if(!is_null($onlyActives)){
            $query->isActive($onlyActives);
        }

        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("title", "id");
        }
        
        if ($getAllWithoutPagination) {
            return $query->get();
        }

        return $isPaginateGetOrPluck ? $query->paginate(maxPaginateNo()) : $query->get();
    }

    public function findSubscriptionPlanById($id, $withRelationships = [], $conditions = [])
    {
        $query = SubscriptionPlan::query();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        return $query->findOrFail($id);
    }

    public function store(array $payloads)
    {
        return SubscriptionPlan::query()->create($payloads);
    }

    public function update(object $package, array $payloads)
    {
        $package->update($payloads);

        return $package;
    }

    public function storeNewSubscriptionPlan($request)
    {
        if($request->has('package_id') && !empty($request->package_id)) {
            $plan                   = $this->findSubscriptionPlanById($request->package_id);
            $copyPlan               = $plan->replicate();
            $copyPlan->package_type = $request->package_type ?? 'monthly';
            $copyPlan->save();

            return $copyPlan;
        }

        $enableSeoKeywords            = getSetting("enable_seo_keywords");
        $enableHelpfulContent         = getSetting("enable_helpful_content_analysis");
        $enableSeoContentOptimization = getSetting("enable_seo_content_optimization");
        $enableAiChat                 = getSetting("enable_ai_chat");
        $enableAiWriter               = getSetting("enable_ai_writer");
        $enableAiReWriter             = getSetting("enable_ai_rewriter");
        $enableTemplates              = getSetting("enable_templates");
        $enableAiBlogWizard           = getSetting("enable_ai_blog_wizard");
        $enableGenerateCode           = getSetting("enable_generate_code");
        $enableAiPdfChat              = getSetting("enable_ai_pdf_chat");
        $enableAiVision               = getSetting("enable_ai_vision");
        $enableBrandVoice             = getSetting("enable_brand_voice");
        $enableVoiceClone             = getSetting("enable_voice_clone");
        $enableAiVideo                = getSetting("enable_ai_video");
        $enableAiAvatarPro            = getSetting("enable_ai_avatar_pro");
        $enableAiImages               = getSetting("enable_ai_images");
        $enableAiChatImage            = getSetting("enable_ai_chat_image");
        $enableAiProductShot          = getSetting("enable_ai_product_shot");
        $enableAiPhotoStudio          = getSetting("enable_ai_photo_studio");
        $enableAiDetector             = getSetting("enable_ai_detector");
        $enableAiPlagiarism           = getSetting("enable_ai_plagiarism");
        $enable_speech_to_text        = getSetting("enable_speech_to_text");
        $enable_text_to_speech        = getSetting("enable_text_to_speech");
        $enable_eleven_labs           = getSetting("enable_eleven_labs");
        $enable_google_cloud          = getSetting("enable_google_cloud");
        $enable_azure                 = getSetting("enable_azure");
        $enable_generate_image        = getSetting("enable_generate_image");

        $payloads = [
            "title"                          => "New Plan",
            "slug"                           => slugMaker("New Plan"),
            "description"                    => "Get started with our new package",
            "openai_model"                   => 'gpt-3.5-turbo',
            "is_active"                      => appStatic()::ACTIVE,
            "package_type"                   =>  $request->package_type ?? 'monthly',
            "speech_to_text_filesize_limit"  => 2, // 0MB
            "allow_seo"                      => ($enableSeoKeywords || $enableHelpfulContent || $enableSeoContentOptimization) ? 1 : 0,
            "total_seo_balance_per_month"    => 0,
            "show_seo_keyword"               => $enableSeoKeywords ?? 0,
            "allow_seo_keyword"              => $enableSeoKeywords ?? 0,
            "show_seo_helpful_content"       => $enableHelpfulContent ?? 0,
            "allow_seo_helpful_content"      => $enableHelpfulContent ?? 0,
            "show_seo_content_optimization"  => $enableSeoContentOptimization ?? 0,
            "allow_seo_content_optimization" => $enableSeoContentOptimization ?? 0,
            "allow_words"                    => $enableAiChat ?? 0,
            "show_words"                     => $enableAiChat ?? 0,
            "allow_text_to_speech"           => $enable_speech_to_text ?? 0,
            "show_text_to_speech"            => $enable_speech_to_text ?? 0,
            "allow_ai_code"                  => $enableGenerateCode ?? 0,
            "show_ai_code"                   => $enableGenerateCode ?? 0,
            "allow_ai_product_shot"          => $enableAiProductShot ?? 0,
            "show_ai_product_shot"           => $enableAiProductShot ?? 0,
            "allow_ai_photo_studio"          => $enableAiPhotoStudio ?? 0,
            "show_ai_photo_studio"           => $enableAiPhotoStudio ?? 0,
            "allow_ai_avatar_pro"            => $enableAiAvatarPro ?? 0,
            "show_ai_avatar_pro"             => $enableAiAvatarPro ?? 0,
            "total_text_to_speech_per_month" => 0,
            "allow_text_to_speech_open_ai"   => 1,
            "show_text_to_speech_open_ai"    => 1,
            "total_brand_voice"              => 0,
            "allow_brand_voice"              => $enableBrandVoice ?? 0,
            "show_brand_voice"               => $enableBrandVoice ?? 0,
            "allow_clone_voice"              => $enableVoiceClone ?? 0,
            "show_clone_voice"               => $enableVoiceClone ?? 0,
            "allow_google_cloud"             => $enable_google_cloud ?? 0,
            "show_google_cloud"              => $enable_google_cloud ?? 0,
            "allow_azure"                    => $enable_azure ?? 0,
            "show_azure"                     => $enable_azure ?? 0,
            "allow_unlimited_ai_video"       => 0,
            "total_ai_video_per_month"       => 0,
            "allow_ai_video"                 => $enableAiVideo ?? 0,
            "show_ai_video"                  => $enableAiVideo ?? 0,
            "allow_ai_chat"                  => $enableAiChat ?? 0,
            "show_ai_chat"                   => $enableAiChat ?? 0,
            "allow_templates"                => $enableTemplates ?? 0,
            "show_templates"                 => $enableTemplates ?? 0,
            "show_ai_writer"                 => $enableAiWriter ?? 0,
            "allow_ai_writer"                => $enableAiWriter ?? 0,
            "allow_ai_rewriter"              => $enableAiReWriter ?? 0,
            "show_ai_rewriter"               => $enableAiReWriter ?? 0,
            "allow_ai_detector"              => $enableAiDetector ?? 0,
            "show_ai_detector"               => $enableAiDetector ?? 0,
            "allow_ai_plagiarism"            => $enableAiPlagiarism ?? 0,
            "show_ai_plagiarism"             => $enableAiPlagiarism ?? 0,
            "allow_ai_image_chat"            => $enableAiChatImage ?? 0,
            "show_ai_image_chat"             => $enableAiChatImage ?? 0,
            "total_speech_to_text_per_month" => 0,
            "allow_speech_to_text"           => $enable_speech_to_text ?? 0,
            "show_speech_to_text"            => $enable_speech_to_text ?? 0,
            "allow_unlimited_speech_to_text" => 0,
            "total_images_per_month"         => 0,
            "allow_unlimited_image"          => 0,
            "allow_images"                   => $enableAiImages ?? 0,
            "show_images"                    => $enable_generate_image ?? 0,
            "allow_sd_images"                => $enable_generate_image ?? 0,
            "show_sd_images"                 => $enable_generate_image ?? 0,
            "allow_dall_e_2_image"           => $enable_generate_image ?? 0,
            "show_dall_e_2_image"            => $enable_generate_image ?? 0,
            "allow_dall_e_3_image"           => $enable_generate_image ?? 0,
            "show_dall_e_3_image"            => $enable_generate_image ?? 0,
            "allow_ai_pdf_chat"              => $enableAiPdfChat ?? 0,
            "show_ai_pdf_chat"               => $enableAiPdfChat ?? 0,
            "allow_eleven_labs"              => 0,
            "show_eleven_labs"               => 1,
            "allow_real_time_data"           => 0,
            "show_real_time_data"            => 1,
            "allow_blog_wizard"              => $enableAiBlogWizard ?? 0,
            "show_blog_wizard"               => $enableAiBlogWizard ?? 0,
            "allow_ai_vision"                => $enableAiVision ?? 0,
            "show_ai_vision"                 => $enableAiVision ?? 0,
            "allow_team"                     => 0,
            "show_team"                      => 1,
            "show_open_ai_model"             => 1,
            "show_live_support"              => 1,
            "show_free_support"              => 1,
            "has_live_support"               => 1,
            "has_free_support"               => 1,
            
            "show_facebook_platform"                  => 1,
            "allow_facebook_platform"                 => 1,
            "show_instagram_platform"                 => 1,
            "allow_instagram_platform"                => 1,
            "show_twitter_platform"                   => 1,
            "allow_twitter_platform"                  => 0,
            "show_linkedin_platform"                  => 1,
            "allow_linkedin_platform"                 => 0,
            "show_whatsapp_platform"                  => 0,
            "allow_whatsapp_platform"                 => 0,
            "show_pinterest_platform"                 => 0,
            "allow_pinterest_platform"                => 0,
            "show_youtube_platform"                   => 0,
            "allow_youtube_platform"                  => 0,
            
            "total_social_platform_account_per_month" => 10,
            "show_total_social_platform_account"      => 1,
            "total_social_platform_post_per_month"    => 1,
            "show_total_social_platform_post"         => 1,

            "show_schedule_posting"                   => 1,
            "allow_schedule_posting"                  => 1,
            "show_ai_assistant"                       => 1,
            "allow_ai_assistant"                      => 0,
        ];

        return SubscriptionPlan::query()->create($payloads);
    }

    public function updatePlan($request)
    {
        if($request->package_id) {
           $column            = str_replace('package-', '', $request->name);
            $subscriptionPlan = $this->findSubscriptionPlanById($request->package_id);

            $subscriptionPlan->update([
                $column => $request->value
            ]);

           return $subscriptionPlan;
        }
    }

    public function starterPlan():object|null
    {
        return SubscriptionPlan::query()
            ->where('package_type', appStatic()::PACKAGE_TYPE_STARTER)
            ->where('is_active', appStatic()::ACTIVE)
            ->first();
    }

    public function plans($type = null)
    {
        $type = $type ?? 'monthly';

        return SubscriptionPlan::query()
            ->where('package_type', $type)
            ->where('is_active', 1)
            ->get();
    }

    public function payments()
    {
        return (new PaymentGatewayService())->paymentGateways([],false, true);
    }

    public function templates($id):array
    {
        $data                        = [];
        $subscription_plan           = $this->findSubscriptionPlanById($id);
        $data['subscription_plan']   = $subscription_plan;
        $data['template_categories'] = (new TemplateCategoryService())->getAll('get', 1, ['adminTemplates']);
        $data['exitTemplateIds']     = $subscription_plan->subscription_plan_templates()->pluck('template_id')->toArray();
        return $data;
    }
}