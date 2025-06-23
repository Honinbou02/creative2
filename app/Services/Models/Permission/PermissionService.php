<?php

namespace App\Services\Models\Permission;

use App\Models\Permission;
use Illuminate\Support\Facades\Route;

/**
 * Class PermissionService.
 */
class PermissionService
{
    public function getAll(
        $isPaginateOrGet = false,
    )
    {
        $query = Permission::query();

        return $isPaginateOrGet ? $query->paginate(maxPaginateNo()) : $query->get();
    }


    public function storeRoutes($request)
    {
        $routes = Route::getRoutes();
        $data = [];

        $permissions = [];

        foreach ($routes as $key=>$route) {

            $routePrefix = $route->getPrefix();
            $routeName   = $route->getName();

            if(!empty($routePrefix)) {
                $prefixExplode = explode("/", $routePrefix);
                $mainPrefix = "";

                if(count($prefixExplode) > 1){
                    $mainPrefix = $prefixExplode[0];
                }else{
                    $mainPrefix = $routePrefix;
                }

//                if(in_array($mainPrefix, $this->allowedPrefix())){

                $explode = explode("/",$route->uri);

                $method = $route->methods()[0] ?? null;

                $payloads = [
                    'display_title'      => ucfirst(textReplace($route->getName(),"."," ")) ,
                    'route'              => $route->getName() ?? $route->uri(),
                    'url'                => $route->uri(),
                    'is_sidebar_menu'    => strpos($route->getName(),".index") ? 1 : 0,
                    'method_type'        => $method,
                ];

                $permissions[] = Permission::query()->updateOrCreate($payloads);
            }
        }

        return $permissions;
    }

    public function customerPermissionRoutes() : array
    {
        return [
            "allow_team" => [
                'all_roles'    => 'admin.roles.index',
                'add_roles'    => 'admin.roles.create',
                'store_roles'  => 'admin.roles.store',
                'show_roles'   => 'admin.roles.show',
                'edit_roles'   => 'admin.roles.edit',
                'delete_roles' => 'admin.roles.destroy',

                // Users
                'all_users'           => 'admin.users.index',
                'add_users'           => 'admin.users.create',
                'store_users'         => 'admin.users.store',
                'show_users'          => 'admin.users.show',
                'edit_users'          => 'admin.users.edit',
                'delete_users'        => 'admin.users.destroy',
                'update_user_balance' => 'admin.users.updateBalance',
                'balance_render'      => 'admin.balance-render',
            ],

            'allow_ai_chat' => [
                'chats'                 => 'admin.chats.index',
                'store_chats'           => 'admin.chats.store',
                'new_chat_thread'       => 'admin.chats.chatThreadConversation',
                'stream_conversation'   => 'admin.chats.conversation',

                // Chat Expert
                'all_chat-experts'             => 'admin.chat-experts.index',
                'add_chat-experts'             => 'admin.chat-experts.create',
                'store_chat-experts'           => 'admin.chat-experts.store',
                'show_chat-experts'            => 'admin.chat-experts.show',
                'edit_chat-experts'            => 'admin.chat-experts.edit',
                'delete_chat-experts'          => 'admin.chat-experts.destroy',
                'real_time_data'               => 'admin.chat-experts.destroy',

                // Prompt
                'all_prompts'       => 'admin.prompts.index',
                'add_prompts'       => 'admin.prompts.create',
                'store_prompts'     => 'admin.prompts.store',
                'show_prompts'      => 'admin.prompts.show',
                'edit_prompts'      => 'admin.prompts.edit',
                'delete_prompts'    => 'admin.prompts.destroy',

                // Chat Categories
                'all_chat-categories'     => 'admin.chat-categories.index',
                'add_chat-categories'     => 'admin.chat-categories.create',
                'store_chat-categories'   => 'admin.chat-categories.store',
                'show_chat-categories'    => 'admin.chat-categories.show',
                'edit_chat-categories'    => 'admin.chat-categories.edit',
                'delete_chat-categories'  => 'admin.chat-categories.destroy',

            ],

            'allow_ai_code' => [
                'Ai_Code_Generator'  => 'admin.openai.chats.code-generator',
                'Generate_Code'      => 'admin.openai.chats.contentGenerator',
            ],

            'allow_templates' => [
                // Template Categories
                'all_template-category'        => 'admin.template-categories.index',
                'add_template-category'        => 'admin.template-categories.create',
                'store_template-category'      => 'admin.template-categories.store',
                'show_template-category'       => 'admin.template-categories.show',
                'edit_template-category'       => 'admin.template-categories.edit',
                'delete_template-category'     => 'admin.template-categories.destroy',

                // Templates
                'all_templates'                => 'admin.templates.index',
                'add_templates'                => 'admin.templates.create',
                'store_templates'              => 'admin.templates.store',
                'show_templates'               => 'admin.templates.show',
                'edit_templates'               => 'admin.templates.edit',
                'delete_templates'             => 'admin.templates.destroy',
                'stream_template_contents'     => 'admin.templates.stream',
                'save_templates_content'       => 'admin.templates.saveContent',

                // Generated Content
                'show_generated-content'       => 'admin.generated-content.show',
                'update_generated-content'     => 'admin.generated-content.update',
                'delete_generated-content'     => 'admin.generated-content.destroy',
            ],

            'allow_blog_wizard'                => [
                'generate_new_topics'          => 'admin.generator.generateTopics',
                'generate_keywords'            => 'admin.generator.generateKeywords',
                'generate_titles'              => 'admin.generator.generateTitles',
                'generate_images'              => 'admin.generator.generateImages',
                'generate_outlines'            => 'admin.generator.generateOutlines',
                'stream_and_generate_articles' => 'admin.generator.generateArticles',
                'all_articles'                 => 'admin.articles.index',
                'add_articles'                 => 'admin.articles.create',
                'store_articles'               => 'admin.articles.store',
                'show_articles'                => 'admin.articles.show',
                'edit_articles'                => 'admin.articles.edit',
                'delete_articles'              => 'admin.articles.destroy',
            ],

            'allow_ai_writer' => [
                'all_ai-writer'           => 'admin.ai-writer.index',
                'ai_writer_create'        => 'admin.ai-writer.create',
                'ai_writer_store'         => 'admin.ai-writer.store',
                'ai_writer_show'          => 'admin.ai-writer.show',
                'ai_writer_edit'          => 'admin.ai-writer.edit',
                'ai_writer_update'        => 'admin.ai-writer.update',
                'ai_writer_delete'        => 'admin.ai-writer.destroy',

                // Content Generate
                "ai_writer_content_generate"    => "admin.ai-writer.generate",
                "ai_writer_content_save_change" => "admin.ai-writer.save-change",

            ],

            'allow_ai_rewriter' => [
                'all_ai_ReWriter'           => 'admin.ai-rewriter.index',
                'ai_ReWriter_create'        => 'admin.ai-rewriter.create',
                'ai_ReWriter_store'         => 'admin.ai-rewriter.store',
                'ai_ReWriter_show'          => 'admin.ai-rewriter.show',
                'ai_ReWriter_edit'          => 'admin.ai-rewriter.edit',
                'ai_ReWriter_update'        => 'admin.ai-rewriter.update',
                'ai_ReWriter_delete'        => 'admin.ai-rewriter.destroy',

                // Content Generate
                "ai_writer_content_generate"    => "admin.ai-rewriter.rewrite",
            ],

            'allow_ai_detector'                => [
                'all_ai_detector'              => 'admin.ai-detector.index',
                'ai_detector_create'           => 'admin.ai-detector.create',
                'ai_detector_store'            => 'admin.ai-detector.store',
                'ai_detector_show'             => 'admin.ai-detector.show',
                'ai_detector_edit'             => 'admin.ai-detector.edit',
                'ai_detector_update'           => 'admin.ai-detector.update',
                'ai_detector_delete'           => 'admin.ai-detector.destroy',
            ],

            'allow_ai_plagiarism' => [
                'ai_plagiarism'                => 'admin.ai-plagiarism.index',
                'ai_plagiarism_create'         => 'admin.ai-plagiarism.create',
                'ai_plagiarism_store'          => 'admin.ai-plagiarism.store',
                'ai_plagiarism_show'           => 'admin.ai-plagiarism.show',
                'ai_plagiarism_edit'           => 'admin.ai-plagiarism.edit',
                'ai_plagiarism_update'         => 'admin.ai-plagiarism.update',
                'ai_plagiarism_delete'         => 'admin.ai-plagiarism.destroy',
            ],

            'allow_ai_video' => [
                'ai_video'                     => 'admin.videos.index',
                'generate_video'               => 'admin.videos.sdImage2Video',
                'download_video'               => 'admin.videos.downloadVideo',
            ],

            "allow_avatar_pro" => [
                "ALL_Avatar_pro_videos"        => "admin.avatarPro.index",
                "Create_Avatar_pro"            => "admin.avatarPro.create",
                "Load_avatar_talking_photos"   => "admin.avatarPro.getAvatarsAndTalkingPhotos",
                "Load_Voices"                  => "admin.avatarPro.getVoices",
                "Get_Avatar_By_Id"             => "admin.avatarPro.getAvatarByAvatarId",
                "Save_Avatar_Video_By_Hey_Gen" => "admin.avatarPro.createVideo",
            ],

            "allow_brand_voice" => [
                'all_Brand_Voices' => 'admin.brand-voices.index',
                'add_blogs'        => 'admin.brand-voices.create',
                'store_blogs'      => 'admin.brand-voices.store',
                'show_blogs'       => 'admin.brand-voices.show',
                'edit_blogs'       => 'admin.brand-voices.edit',
                'delete_blogs'     => 'admin.brand-voices.destroy',
            ],

            'allow_text_to_speech'             => [
                'all_text-to-speeches'             => 'admin.text-to-speeches.index',
                'add_text-to-speeches'             => 'admin.text-to-speeches.create',
                'store_text-to-speeches'           => 'admin.text-to-speeches.store',
                'show_text-to-speeches'            => 'admin.text-to-speeches.show',
                'edit_text-to-speeches'            => 'admin.text-to-speeches.edit',
                'delete_text-to-speeches'          => 'admin.text-to-speeches.destroy',
            ],

            'allow_speech_to_text'             => [
                'speech_to_text'               => 'admin.voice-to-text.create',
            ],
            'allow_ai_image_chat'              => [
                'image_chat'                   => 'admin.chats.aiImageChat',
            ],

            "allow_ai_vision"  => [
                "all_ai_vision" => "admin.chats.aiVisionChat",
            ],

            'allow_ai_pdf_chat' => [
                'pdf_chat'            => 'admin.chats.aiPDFChat',
                'pdf_chat_embedding'  => 'admin.chats.pdfChatEmbedding',
                'stream_pdf_chat'     => 'admin.chats.pdfChatCompletion',
                'delete_pdf_chat'     => 'admin.chats.destroy',
            ],

            'allow_images'                     => [
                'all_images'                     => 'admin.images.index',
                'image_generate'                 => 'admin.images.generateImage',
                'dall_e_2'                       => 'admin.images.dallE2',
                'dall_e_3'                       => 'admin.images.dallE3',
                'SD_Text_to_Image'               => 'admin.images.sdText2Image',
                'SD_Image_to_Image_multi_prompt' => 'admin.images.sdImage2ImageMultiPrompt',
                'SD_Image_to_Image_masking'      => 'admin.images.sdImage2ImageMasking',
                'SD_Image_to_Image_upscale'      => 'admin.images.sdImage2ImageUpscale',
            ],

            "allow_product_shot"  => [
                "all_product_shot"             => "admin.productShot.index",
                "Generate_and_store_image"     => "admin.productShot.generateProductShotImage",
            ],

            "allow_photo_studio"  => [
                "all_photo_studio"             => "admin.photoStudio.index",
                "Generate_and_store_image"     => "admin.photoStudio.generatePhotoStudioImage",
            ],

            'folders'                          => [
                'all_folders'                  => 'admin.folders.index',
                'add_folders'                  => 'admin.folders.create',
                'store_folders'                => 'admin.folders.store',
                'edit_folders'                 => 'admin.folders.edit',
                'delete_folders'               => 'admin.folders.destroy',

                // Move Folders
                'move_folders_content'        => 'admin.folders.move-folder-content',
                'move_folder'                 => 'admin.folders.move-folder',
            ],
            'documents'                        => [
                'all_documents'                => 'admin.documents.index',
            ],
            'reports'                          => [
                'words'                        => 'admin.reports.words',
                'code'                         => 'admin.reports.codes',
                'image'                        => 'admin.reports.images',
                'speech_to_text'               => 'admin.reports.s2t',
                'mostUsed_template'            => 'admin.reports.mostUsed',
            ],
        ];
    }

    public function demoRoutes(): array
    {
        $permissionsArr = Permission::query()->where("is_allowed_in_demo", 1)->pluck("route")->toArray();

        $loginLogoutRoutesArr =  [
            "admin.login",
            "login",
            "logout",
        ];

        return array_unique(array_merge($permissionsArr,$loginLogoutRoutesArr));
    }
}
