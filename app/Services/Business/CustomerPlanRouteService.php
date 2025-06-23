<?php

namespace App\Services\Business;

/**
 * Class CustomerPlanRouteService.
 */
class CustomerPlanRouteService
{

    public function customerPlanRoutes(): array
    {
        $roles              = $this->getRolesRoutes();
        $users              = $this->getUsersRoutes();
        $tickets            = $this->getTicketsRoutes();
        $templates          = $this->getTemplatesRoutes();
        $images             = $this->getImagesRoutes();
        $videos             = $this->getVideosRoutes();
        $audios             = $this->getAudiosRoutes();
        $aiChats            = $this->getAiChatsRoutes();
        $aiWriters          = $this->getAiWriterRoutes();
        $aiReWriters        = $this->getAiReWriterRoutes();
        $articles           = $this->getArticleRoutes();
        $commonRoutes       = $this->getCommonRoutes();

        return array_merge(
            $commonRoutes,
            $roles,
            $users,
            $articles,
            $tickets,
            $templates,
            $images,
            $videos,
            $audios,
            $aiChats,
            $aiWriters,
            $aiReWriters
        );
    }

    public function getAiReWriterRoutes()
    {
        return [
            'admin.ai-rewriter.create'             => 'allow_ai_rewriter',
            'admin.ai-rewriter.index'              => 'allow_ai_rewriter',
            'admin.ai-rewriter.show'               => 'allow_ai_rewriter',
            'admin.ai-rewriter.edit'               => 'allow_ai_rewriter',
            'admin.ai-rewriter.store'              => 'allow_ai_rewriter',
            'admin.ai-rewriter.destroy'            => 'allow_ai_rewriter',
            'admin.ai-rewriter.update'             => 'allow_ai_rewriter',


        ];
    }

    public function getAiWriterRoutes()
    {
        return [
            'admin.ai-writer.create'             => 'allow_ai_writer',
            'admin.ai-writer.index'              => 'allow_ai_writer',
            'admin.ai-writer.show'               => 'allow_ai_writer',
            'admin.ai-writer.store'              => 'allow_ai_writer',
            'admin.ai-writer.edit'               => 'allow_ai_writer',
            'admin.ai-writer.destroy'            => 'allow_ai_writer',
            'admin.ai-writer.update'             => 'allow_ai_writer',

            // AI Writer Content & Save Changes
            "admin.ai-writer.generate"           => "allow_ai_writer",
            "admin.ai-writer.save-change"        => "allow_ai_writer"
        ];
    }

    public function getArticleRoutes(): array
    {
        return [
            'admin.articles.create'             => 'allow_blog_wizard',
            'admin.articles.index'              => 'allow_blog_wizard',
            'admin.articles.show'               => 'allow_blog_wizard',
            'admin.articles.store'              => 'allow_blog_wizard',
            'admin.articles.edit'               => 'allow_blog_wizard',
            'admin.articles.destroy'            => 'allow_blog_wizard',
            'admin.articles.update'             => 'allow_blog_wizard',

            // Keywords
            'admin.generator.generateKeywords'          => 'allow_blog_wizard',

            // Title
            'admin.generator.generateTitles'            => 'allow_blog_wizard',

            // Meta Description
            'admin.generator.generateMetaDescriptions'  => 'allow_blog_wizard',

            // Outlines
            'admin.generator.generateOutlines'  => 'allow_blog_wizard',

            // Image Generate
            'admin.generator.generateImages'    => 'allow_blog_wizard',

            // Unsplash Image Search
            'admin.generator.imageSearch'       => 'allow_blog_wizard',

            // Article Generate
            'admin.generator.generateArticles'  => 'allow_blog_wizard',


        ];
    }

    public function getRolesRoutes(): array
    {
        return [
            'admin.roles.index'    => 'allow_team',
            'admin.roles.create'   => 'allow_team',
            'admin.roles.store'    => 'allow_team',
            'admin.roles.show'     => 'allow_team',
            'admin.roles.edit'     => 'allow_team',
            'admin.roles.update'   => 'allow_team',
            'admin.roles.destroy'  => 'allow_team',
        ];
    }

    public function getUsersRoutes(): array
    {
        return [
            'admin.users.index'    => 'allow_team',
            'admin.users.create'   => 'allow_team',
            'admin.users.store'    => 'allow_team',
            'admin.users.show'     => 'allow_team',
            'admin.users.edit'     => 'allow_team',
            'admin.users.update'   => 'allow_team',
            'admin.users.destroy'  => 'allow_team',
        ];
    }

    public function getTicketsRoutes(): array
    {
        return [
            'admin.support-tickets.index'    => 'has_free_support',
            'admin.support-tickets.create'   => 'has_free_support',
            'admin.support-tickets.store'    => 'has_free_support',
            'admin.support-tickets.show'     => 'has_free_support',
            'admin.support-tickets.edit'     => 'has_free_support',
            'admin.support-tickets.update'   => 'has_free_support',
            'admin.support-tickets.destroy'  => 'has_free_support',

            // Support Categories
            "admin.support-categories.index",
            "admin.support-priorities.index",

            // Replies
            'admin.support-replies.index'    => 'has_free_support',
            'admin.support-replies.create'   => 'has_free_support',
            'admin.support-replies.store'    => 'has_free_support',
            'admin.support-replies.show'     => 'has_free_support',
            'admin.support-replies.edit'     => 'has_free_support',
            'admin.support-replies.update'   => 'has_free_support',
            'admin.support-replies.destroy'  => 'has_free_support',

            // Individual Reply View
            "admin.support-tickets.reply"    => "has_free_support"
        ];
    }

    public function getTemplatesRoutes(): array
    {

        return [
            'admin.templates.index'   => 'allow_templates',
            'admin.templates.create'  => 'allow_templates',
            'admin.templates.store'   => 'allow_templates',
            'admin.templates.show'    => 'allow_templates',
            'admin.templates.edit'    => 'allow_templates',
            'admin.templates.update'  => 'allow_templates',
            'admin.templates.destroy' => 'allow_templates',

            'admin.templates.saveContent'  => 'allow_templates',
            'admin.templates.stream'       => 'allow_templates',
        ];
    }

    public function getImagesRoutes(): array
    {

        return [
            "admin.images.index"                    => "allow_images",
            "admin.images.generateImage"            => "allow_images",
            "admin.images.destroy"                  => "allow_images",

            // Open AI
            "admin.images.dallE2"                   => "allow_dall_e_2_image",
            "admin.images.dallE3"                   => "allow_dall_e_3_image",

            //Stable Diffusion
            "admin.images.sdText2Image"             => "allow_sd_images",
            "admin.images.sdImage2ImageMultiPrompt" => "allow_images",
            "admin.images.sdImage2ImagePrompt"      => "allow_images",
            "admin.images.sdImage2ImageMasking"     => "allow_images",
            "admin.images.sdImage2ImageUpscale"     => "allow_images",


            //Photo Studio
            "admin.photoStudio.index"                    => "allow_ai_photo_studio",
            "admin.photoStudio.generatePhotoStudioImage" => "allow_ai_photo_studio",

            // Product Shot
            "admin.productShot.index"                    => "allow_ai_product_shot",
            "admin.productShot.generateProductShotImage" => "allow_ai_product_shot",
        ];
    }

    public function getVideosRoutes() : array
    {
        // allow_ai_avatar_pro,  allow_ai_video
        return [
            // Avatar pro
            "admin.avatarPro.index"                          => "allow_ai_avatar_pro",
            "admin.avatarPro.create"                         => "allow_ai_avatar_pro",
            "admin.avatarPro.getAvatarsAndTalkingPhotos"     => "allow_ai_avatar_pro",
            "admin.avatarPro.getVoices"                      => "allow_ai_avatar_pro",
            "admin.avatarPro.importAvatarsAndTalkingPhotos"  => "allow_ai_avatar_pro",
            "admin.avatarPro.importVoices"                   => "allow_ai_avatar_pro",
            "admin.avatarPro.getAvatarByAvatarId"            => "allow_ai_avatar_pro",
            "admin.avatarPro.createVideo"                    => "allow_ai_avatar_pro",

            // allow_ai_video
            "admin.videos.index"         => "allow_ai_video",
            "admin.videos.sdImage2Video" => "allow_ai_video",
            "admin.videos.downloadVideo" => "allow_ai_video",

        ];
    }

    public function getAiChatsRoutes() : array
    {

        return [
            // Common Routes
            "admin.chats.chatThreadConversation" => "allow_ai_chat",
            "admin.chats.conversation"           => "allow_ai_chat",

            // Code
            "admin.openai.chats.code-generator"    => "allow_ai_code",
            "admin.openai.chats.contentGenerator"  => "allow_ai_code",


            // Chats
            'admin.chats.index'   => 'allow_ai_chat',
            'admin.chats.create'  => 'allow_ai_chat',
            'admin.chats.store'   => 'allow_ai_chat',
            'admin.chats.show'    => 'allow_ai_chat',
            'admin.chats.edit'    => 'allow_ai_chat',
            'admin.chats.update'  => 'allow_ai_chat',

            // Re-Write

            // Chat Image
            "admin.chats.aiImageChat" => "allow_ai_image_chat",

            // AI Vision
            "admin.chats.aiVisionChat" => "allow_ai_vision",

            // Ai Chat
            'admin.chat-experts.index'   => 'allow_ai_chat',
            'admin.chat-experts.create'  => 'allow_ai_chat',
            'admin.chat-experts.store'   => 'allow_ai_chat',
            'admin.chat-experts.show'    => 'allow_ai_chat',
            'admin.chat-experts.edit'    => 'allow_ai_chat',
            'admin.chat-experts.update'  => 'allow_ai_chat',
            'admin.chat-experts.destroy' => 'allow_ai_chat',


            // AI PDF Chat
            "admin.chats.aiPdfChat"         => "allow_ai_pdf_chat",
            "admin.chats.pdfChatEmbedding"  => "allow_ai_pdf_chat",
            "admin.chats.pdfChatCompletion" => "allow_ai_pdf_chat",
            "admin.chats.destroy"           => "allow_ai_pdf_chat",

        ];
    }

    public function getAudiosRoutes(): array
    {
        return [
            "admin.voice-to-text.index"   => "allow_speech_to_text",
            "admin.voice-to-text.create"  => "allow_speech_to_text",
            "admin.voice-to-text.show"    => "allow_speech_to_text",
            "admin.voice-to-text.edit"    => "allow_speech_to_text",
            "admin.voice-to-text.update"  => "allow_speech_to_text",
            "admin.voice-to-text.destroy" => "allow_speech_to_text",

            // Voice Clone
            "admin.voice.index"              => "allow_voice_clone",
            "admin.voice.cloneVoice"         => "allow_voice_clone",

            // text to speech
            "admin.text-to-speeches.index"   => "allow_text_to_speech",
            "admin.text-to-speeches.create"  => "allow_text_to_speech",
            "admin.text-to-speeches.show"    => "allow_text_to_speech",
            "admin.text-to-speeches.edit"    => "allow_text_to_speech",
            "admin.text-to-speeches.update"  => "allow_text_to_speech",
            "admin.text-to-speeches.destroy" => "allow_text_to_speech",

        ];
    }


    public function getCommonRoutes(): array
    {
        return [
            "admin.profile",
            "admin.profile",
            "admin.info-update",
            "admin.change-password",
            "admin.users.updateBalance",
            "admin.balance-render",

            // Subscriptions
            "admin.subscription-plans.index",
            "admin.subscription-plans.package-update",
            "admin.subscription-plans.get-price",

            // Plan
            "admin.plan-histories.index",
            "admin.plan-histories.show",
            "admin.plan-invoice.index",
            "admin.plan-invoice.download",

            // Documents
            "admin.documents.index",
            "admin.generated-content.show",
            "admin.generated-content.update",
            "admin.generated-content.destroy",

            // Folders
            "admin.folders.index",
            "admin.folders.create",
            "admin.folders.store",
            "admin.folders.edit",
            "admin.folders.update",
            "admin.folders.destroy",

            // Move Folder Content
            "admin.folders.move-folder-content",
            "admin.folders.move-folder",

            // Affiliate Routes
            "admin.affiliate.overview",
            "admin.affiliate.payments.index",
            "admin.affiliate.payout.configure",
            "admin.affiliate.payout.configureStore",
            "admin.affiliate.withdraw.index",
            "admin.affiliate.withdraw.store",
            "admin.affiliate.withdraw.update",
            "admin.affiliate.earnings.index",

            "admin.offline-payment-methods.index",
            "admin.offline-payment-methods.show",

            // Reports
            "admin.reports.words",
            "admin.reports.codes",
            "admin.reports.images",
            "admin.reports.s2t",
            "admin.reports.mostUsed",
            "admin.reports.subscriptions",

            // wordpress
            'admin.connectWP',
            'admin.wordpress.list',
            'admin.seo.wpPostSeoChecker',

            'admin.wordpress-credentials.index',
            'admin.wordpress-credentials.store',
            'admin.wordpress-credentials.edit',
            'admin.wordpress-credentials.update',

            'admin.tags.index',
            'admin.tags.store',
            'admin.tags.edit',
            'admin.tags.update',

            'admin.wordpress-tags.index',
            'admin.wordpress-tags.store',
            'admin.wordpress-tags.edit',
            'admin.wordpress-tags.update',

            'admin.wordpress-posts.index',
            'admin.wordpress-posts.store',
            'admin.wordpress-posts.edit',
            'admin.wordpress-posts.update',

            'admin.wordpress-categories.index',
            'admin.wordpress-categories.store',
            'admin.wordpress-categories.edit',
            'admin.wordpress-categories.update',

            'admin.wordpress-posts-published.index',
            'admin.wordpress-posts-published.store',
            'admin.wordpress-posts-published.edit',
            'admin.wordpress-posts-published.update',

            'admin.sync.all.users',
            'admin.sync.all.tags',
            'admin.sync.all.categories',

            'admin.blog-categories.index',
            'admin.blog-categories.store',
            'admin.blog-categories.edit',
            'admin.blog-categories.update',
            
            'admin.wordpress.authorLists',
            'admin.wordpress.syncAllUsers',
            "admin.wordpress.articles.edit",
            "admin.wordpress.importArticle",
            
            // plagiarism
            'admin.ai-plagiarism.index',
            'admin.ai-plagiarism.store',
            'admin.ai-plagiarism.edit',
            'admin.ai-plagiarism.update',
            
            // detector
            'admin.ai-detector.index',
            'admin.ai-detector.store',
            'admin.ai-detector.edit',
            'admin.ai-detector.update',
            
            // photoStudio
            'admin.images.photoStudio.index',
            'admin.images.photoStudio.generatePhotoStudioImage',
            
            // product-shot
            'admin.images.productShot.index',
            'admin.images.productShot.generateProductShotImage',

            
            // account routes
            'admin.accounts.index',
            'admin.accounts.create',
            'admin.accounts.store',
            'admin.accounts.destroy',

            // posts routes
            'admin.socials.posts.index',
            'admin.socials.posts.create',
            'admin.socials.posts.store',
            'admin.socials.posts.destroy',

            'admin.socials.posts.ai-assistant-form',
            'admin.socials.posts.ai-assistant-save-contents',
            'admin.socials.posts.ai-assistant.stream',

            // quick-texts routes
            'admin.quick-texts.index',
            'admin.quick-texts.create',
            'admin.quick-texts.edit',
            'admin.quick-texts.form',
            'admin.quick-texts.store',
            'admin.quick-texts.update',
            'admin.quick-texts.destroy',
        ];
    }

}
