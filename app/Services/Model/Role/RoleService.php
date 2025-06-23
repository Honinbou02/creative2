<?php

namespace App\Services\Model\Role;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Scopes\UserIdScopeTrait;
use App\Services\Models\Permission\PermissionService;
use App\Traits\Models\Status\IsActiveTrait;
use App\Traits\Models\User\UserMenuPermissionTrait;
use App\Traits\Models\User\UserTrait;
use Illuminate\Database\Eloquent\Model;

class RoleService
{
    use UserMenuPermissionTrait;
    use IsActiveTrait;
    use UserTrait;
    use UserIdScopeTrait;

    /**
     * @incomingParams $paginatePluckOrGet will contain null,true, false.
     *  $paginatePluckOrGet == null means return pluck data.
     *  $paginatePluckOrGet == true means return paginate data.
     *  $paginatePluckOrGet == false means return get data.
     *
     * @incomingParams $onlyActive will contain null,true, false.
     * $onlyActive == null means return categories all rows.
     * $onlyActive == true means return only active categories where is_active column value is 1.
     * $onlyActive == false means return only active categories where is_active column value is 0.
     * */
    public function getAll(
        $paginatePluckOrGet = null,
        $onlyActive         = null,
        $eagerLoad  = []
    ) {

        $query = Role::query();

        // Eager Load
        (!empty($eagerLoad) ? $eagerLoad = array_merge($eagerLoad, ["createdBy", "updatedBy"]) : true);

        $query->with($eagerLoad)->latest();

        // Bind Merchant ID or Super Admin ID

        // Binding Merchant ID
        if (isCustomer() || isCustomerTeam()) {
            $query->userId(customerId());
        } else {
            $user_id = isAdmin() ? userID() : getUserParentId();

            $query->userId($user_id);
        }

        // Active in-active
        if (!empty($onlyActive)) {
            // Only active categories or not active categories
            ($onlyActive ? $query->isActive() : $query->isActive(false));
        }

        // Pluck Data Returning
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck("id", "title");
        }

        return $paginatePluckOrGet ? $query->paginate(maxPaginateNo()) : $query->get();
    }


    /**
     * Role Store
     * */
    public function store($payloads): Model
    {

        return Role::query()->create($payloads);
    }

    # Permissions Delete
    public function permissionDeletes($role)
    {
        $role->permissions()->delete();
    }

    #Role Permission Save
    public function rolePermissionStore($role, array $permission_ids): Model
    {
        foreach ($permission_ids as $key => $permission_id) {

            RolePermission::query()->create([
                "role_id"       => $role->id,
                "permission_id" => $permission_id
            ]);
        }

        return $role;
    }

    public function findById($id)
    {
        return Role::query()->with("permissions")->findOrFail($id);
    }


    public function getPermissionByRoute(string $route)
    {
        if (isCacheExists($route)) {
            $cachePermission = cache()->get($route);
        } else {
            $permission = Permission::query()->where("route", $route)->firstOrFail();

            setCacheData($permission->route, $permission);
            $cachePermission = cache()->get($route);
        }

        return $cachePermission->id;
    }

    #Role Update
    public function update($role, $payloads): Model
    {
        $role->update($payloads);

        return $role;
    }


    # Role User Menu Permission update
    public function roleUsersMenuPermissionIncrease($role)
    {
        $users = $role->users;

        if ($users && $users->count() > 0) {
            foreach ($users as $key => $user) {

                // User Menu Permission Update
                self::increaseUserMenuPermissions($user);
            }
        }

        return $role;
    }

    public function adminCustomRoutes()
    {
        if (isCustomer()){

            return $this->customerPermissionsRoutes();
        }


        return [
            'dashboard' => [
                'Dashboard' => 'home',
            ],

            'roles' => [
                'all_roles'    => 'admin.roles.index',
                'add_roles'    => 'admin.roles.create',
                'store_roles'  => 'admin.roles.store',
                'show_roles'   => 'admin.roles.show',
                'edit_roles'   => 'admin.roles.edit',
                'delete_roles' => 'admin.roles.destroy',
            ],

            'users' => [
                'all_users'           => 'admin.users.index',
                'add_users'           => 'admin.users.create',
                'store_users'         => 'admin.users.store',
                'show_users'          => 'admin.users.show',
                'edit_users'          => 'admin.users.edit',
                'delete_users'        => 'admin.users.destroy',
                'update_user_balance' => 'admin.users.updateBalance',
            ],

            'articles' => [
                'generate_new_topics'          => 'admin.generator.generateTopics',
                'generate_keywords'            => 'admin.generator.generateKeywords',
                'generate_titles'              => 'admin.generator.generateTitles',
                'generate_images'              => 'admin.generator.generateImages',
                'generate_outlines'            => 'admin.generator.generateOutlines',
                'stream_and_generate_articles' => 'admin.generator.generateArticles',
                'all_articles'                 => 'admin.articles.index',
                'all_wordpress_articles'       => 'admin.wordpress.articles.list',
                'add_articles'                 => 'admin.articles.create',
                'store_articles'               => 'admin.articles.store',
                'show_articles'                => 'admin.articles.show',
                'edit_articles'                => 'admin.articles.edit',
                'edit_wordpress_articles'      => 'admin.wordpress.articles.edit',
                'delete_articles'              => 'admin.articles.destroy',
            ],

            'template-categories' => [
                'all_template-categories'    => 'admin.template-categories.index',
                'add_template-categories'    => 'admin.template-categories.create',
                'store_template-categories'  => 'admin.template-categories.store',
                'show_template-categories'   => 'admin.template-categories.show',
                'edit_template-categories'   => 'admin.template-categories.edit',
                'delete_template-categories' => 'admin.template-categories.destroy',
            ],

            'templates' => [
                'all_templates'            => 'admin.templates.index',
                'add_templates'            => 'admin.templates.create',
                'store_templates'          => 'admin.templates.store',
                'show_templates'           => 'admin.templates.show',
                'edit_templates'           => 'admin.templates.edit',
                'delete_templates'         => 'admin.templates.destroy',
                'stream_template_contents' => 'admin.templates.stream',
                'save_templates_content'   => 'admin.templates.saveContent',
            ],

            'folders'                      => [
                'all_folders'              => 'admin.folders.index',
                'add_folders'              => 'admin.folders.create',
                'store_folders'            => 'admin.folders.store',
                'edit_folders'             => 'admin.folders.edit',
                'delete_folders'           => 'admin.folders.destroy',
            ],

            'text-to-speeches'                     => [
                'all_text-to-speeches'             => 'admin.text-to-speeches.index',
                'add_text-to-speeches'             => 'admin.text-to-speeches.create',
                'store_text-to-speeches'           => 'admin.text-to-speeches.store',
                'show_text-to-speeches'            => 'admin.text-to-speeches.show',
                'edit_text-to-speeches'            => 'admin.text-to-speeches.edit',
                'delete_text-to-speeches'          => 'admin.text-to-speeches.destroy',
            ],

            'ai-writer'                            => [
                'all_ai-writer'                    => 'admin.ai-writer.index',
                'add_ai-writer'                    => 'admin.ai-writer.create',
                'store_ai-writer'                  => 'admin.ai-writer.store',
                'show_ai-writer'                   => 'admin.ai-writer.show',
                'edit_ai-writer'                   => 'admin.ai-writer.edit',
                'delete_ai-writer'                 => 'admin.ai-writer.destroy',
                'generate_ai-writer'               => 'admin.ai-writer.generate',
                'save_generated_ai_writer_content' => 'admin.ai-writer.save-change',
            ],

            'media-managers'                       => [
                'all_media-managers'               => 'admin.media-managers.index',
                'add_media-managers'               => 'admin.media-managers.create',
                'store_media-managers'             => 'admin.media-managers.store',
                'show_media-managers'              => 'admin.media-managers.show',
                'edit_media-managers'              => 'admin.media-managers.edit',
                'delete_media-managers'            => 'admin.media-managers.destroy',
            ],

            'platforms'                              => [
                'all_platforms'                      => 'admin.platforms.index',
                'edit_platforms'                     => 'admin.platforms.edit',
                'configure_platforms'                => 'admin.platforms.configure-form',
            ],

            
            'accounts'                              => [
                'all_accounts'                      => 'admin.accounts.index',
                'add_accounts'                      => 'admin.accounts.create',
                'store_accounts'                    => 'admin.accounts.store',
                'delete_accounts'                   => 'admin.accounts.destroy',
            ],
            
            'social-posts'                              => [
                'all_social_posts'                      => 'admin.socials.posts.index',
                'add_social_posts'                      => 'admin.socials.posts.create',
                'store_social_posts'                    => 'admin.socials.posts.store',
                'delete_social_posts'                   => 'admin.socials.posts.destroy',
                'ai_assistant'                          => 'admin.socials.posts.ai-assistant-form',
            ],
            
            'quick-texts'                              => [
                'all_quick_texts'                      => 'admin.quick-texts.index',
                'add_quick_texts'                      => 'admin.quick-texts.create',
                'store_quick_texts'                    => 'admin.quick-texts.store',
                'delete_quick_texts'                   => 'admin.quick-texts.destroy',
            ],
            
            'prompt-groups'                              => [
                'all_prompt_groups'                      => 'admin.prompt-groups.index',
                'add_prompt_groups'                      => 'admin.prompt-groups.create',
                'store_prompt_groups'                    => 'admin.prompt-groups.store',
                'show_prompt_groups'                     => 'admin.prompt-groups.show',
                'edit_prompt_groups'                     => 'admin.prompt-groups.edit',
                'delete_prompt_groups'                   => 'admin.prompt-groups.destroy',
            ],

            'chat-categories'                      => [
                'all_chat-categories'              => 'admin.chat-categories.index',
                'add_chat-categories'              => 'admin.chat-categories.create',
                'store_chat-categories'            => 'admin.chat-categories.store',
                'show_chat-categories'             => 'admin.chat-categories.show',
                'edit_chat-categories'             => 'admin.chat-categories.edit',
                'delete_chat-categories'           => 'admin.chat-categories.destroy',
            ],

            'prompts'                              => [
                'all_prompts'                      => 'admin.prompts.index',
                'add_prompts'                      => 'admin.prompts.create',
                'store_prompts'                    => 'admin.prompts.store',
                'show_prompts'                     => 'admin.prompts.show',
                'edit_prompts'                     => 'admin.prompts.edit',
                'delete_prompts'                   => 'admin.prompts.destroy',
            ],

            'chats'                                => [
                'all_chats'                        => 'admin.chats.index',
                'store_chats'                      => 'admin.chats.store',
            ],

            'chat-experts'                 => [
                'all_chat-experts'         => 'admin.chat-experts.index',
                'add_chat-experts'         => 'admin.chat-experts.create',
                'store_chat-experts'       => 'admin.chat-experts.store',
                'show_chat-experts'        => 'admin.chat-experts.show',
                'edit_chat-experts'        => 'admin.chat-experts.edit',
                'delete_chat-experts'      => 'admin.chat-experts.destroy',
            ],

            'generated-content'            => [
                'show_generated-content'   => 'admin.generated-content.show',
                'update_generated-content'   => 'admin.generated-content.update',
                'delete_generated-content' => 'admin.generated-content.destroy',
            ],

            'documents'                    => [
                'all_documents'            => 'admin.documents.index',
            ],

            'settings'                     => [
                'all_settings'             => 'admin.settings.index',
                'add_settings'             => 'admin.settings.create',
                'store_settings'           => 'admin.settings.store',
                'show_settings'            => 'admin.settings.show',
                'edit_settings'            => 'admin.settings.edit',
                'delete_settings'          => 'admin.settings.destroy',
            ],

            'images' => [
                'all_images'                     => 'admin.images.index',
                'image_generate'                 => 'admin.images.generateImage',
                'dall_e_2'                       => 'admin.images.dallE2',
                'dall_e_3'                       => 'admin.images.dallE3',
                'SD_Text_to_Image'               => 'admin.images.sdText2Image',
                'SD_Image_to_Image_multi_prompt' => 'admin.images.sdImage2ImageMultiPrompt',
                'SD_Image_to_Image_masking'      => 'admin.images.sdImage2ImageMasking',
                'SD_Image_to_Image_upscale'      => 'admin.images.sdImage2ImageUpscale',
            ],

            "AI_Product_Shot"                  => [
                "ALL_Product_Shots"            => "admin.productShot.index",
                "Generate_and_store_image"     => "admin.productShot.generateProductShotImage",
            ],

            "AI_PHOTO_Studio"                  => [
                "ALL_PHOTO_Studio"             => "admin.photoStudio.index",
                "Generate_and_store_image"     => "admin.photoStudio.generatePhotoStudioImage",
            ],

            'videos'                           => [
                'all_videos'                   => 'admin.videos.index',
                'sd_image_to_video'            => 'admin.videos.sdImage2Video',
                'AI_Avatar_pro'                => 'admin.videos.sdImage2Video',
            ],

            "AI_Avatar_PRO"                    => [
                "ALL_Avatar_pro_videos"        => "admin.avatarPro.index",
                "Create_Avatar_pro"            => "admin.avatarPro.create",
                "Load_avatar_talking_photos"   => "admin.avatarPro.getAvatarsAndTalkingPhotos",
                "Load_Voices"                  => "admin.avatarPro.getVoices",
                "Get_Avatar_By_Id"             => "admin.avatarPro.getAvatarByAvatarId",
                "Save_Avatar_Video_By_Hey_Gen" => "admin.avatarPro.createVideo",
            ],

            'Brand_Voices' => [
                'all_Brand_Voices' => 'admin.brand-voices.index',
                'add_blogs'        => 'admin.brand-voices.create',
                'store_blogs'      => 'admin.brand-voices.store',
                'show_blogs'       => 'admin.brand-voices.show',
                'edit_blogs'       => 'admin.brand-voices.edit',
                'delete_blogs'     => 'admin.brand-voices.destroy',
            ],

            'Voice_Clone' => [
                'all_Voice_Clone'   => 'admin.voice.index',
                'Store_Voice_Clone' => 'admin.voice.cloneVoice',
            ],

            'languages' => [
                'all_languages'    => 'admin.languages.index',
                'add_languages'    => 'admin.languages.create',
                'store_languages'  => 'admin.languages.store',
                'show_languages'   => 'admin.languages.show',
                'edit_languages'   => 'admin.languages.edit',
                'delete_languages' => 'admin.languages.destroy',
            ],

            'localizations' => [
                'store_localizations' => 'admin.localizations.store',
                'show_localizations'  => 'admin.localizations.show',
            ],

            'currencies' => [
                'all_currencies'    => 'admin.currencies.index',
                'add_currencies'    => 'admin.currencies.create',
                'store_currencies'  => 'admin.currencies.store',
                'show_currencies'   => 'admin.currencies.show',
                'edit_currencies'   => 'admin.currencies.edit',
                'delete_currencies' => 'admin.currencies.destroy',
            ],

            'uppy' => [
                'all_uppy'            => 'admin.uppy.index',
                'store_uppy'          => 'admin.uppy.store',
                'uppy_selected_files' => 'admin.uppy.selectedFiles',
                'uppy_delete'         => 'admin.uppy.delete',
            ],

            'tags' => [
                'all_tags'    => 'admin.tags.index',
                'add_tags'    => 'admin.tags.create',
                'store_tags'  => 'admin.tags.store',
                'show_tags'   => 'admin.tags.show',
                'edit_tags'   => 'admin.tags.edit',
                'delete_tags' => 'admin.tags.destroy',
            ],

            'pages' => [
                'all_pages'    => 'admin.pages.index',
                'add_pages'    => 'admin.pages.create',
                'store_pages'  => 'admin.pages.store',
                'show_pages'   => 'admin.pages.show',
                'edit_pages'   => 'admin.pages.edit',
                'delete_pages' => 'admin.pages.destroy',
            ],

            'blog-categories' => [
                'all_blog-categories'    => 'admin.blog-categories.index',
                'add_blog-categories'    => 'admin.blog-categories.create',
                'store_blog-categories'  => 'admin.blog-categories.store',
                'show_blog-categories'   => 'admin.blog-categories.show',
                'edit_blog-categories'   => 'admin.blog-categories.edit',
                'delete_blog-categories' => 'admin.blog-categories.destroy',
            ],

            'blogs'            => [
                'all_blogs'    => 'admin.blogs.index',
                'add_blogs'    => 'admin.blogs.create',
                'store_blogs'  => 'admin.blogs.store',
                'show_blogs'   => 'admin.blogs.show',
                'edit_blogs'   => 'admin.blogs.edit',
                'delete_blogs' => 'admin.blogs.destroy',
            ],

            'faqs' => [
                'all_faqs'    => 'admin.faqs.index',
                'add_faqs'    => 'admin.faqs.create',
                'store_faqs'  => 'admin.faqs.store',
                'show_faqs'   => 'admin.faqs.show',
                'edit_faqs'   => 'admin.faqs.edit',
                'delete_faqs' => 'admin.faqs.destroy',
            ],

            'support-categories' => [
                'all_support-categories'    => 'admin.support-categories.index',
                'add_support-categories'    => 'admin.support-categories.create',
                'store_support-categories'  => 'admin.support-categories.store',
                'show_support-categories'   => 'admin.support-categories.show',
                'edit_support-categories'   => 'admin.support-categories.edit',
                'delete_support-categories' => 'admin.support-categories.destroy',
            ],

            'support-priorities'            => [
                'all_support-priorities'    => 'admin.support-priorities.index',
                'add_support-priorities'    => 'admin.support-priorities.create',
                'store_support-priorities'  => 'admin.support-priorities.store',
                'show_support-priorities'   => 'admin.support-priorities.show',
                'edit_support-priorities'   => 'admin.support-priorities.edit',
                'delete_support-priorities' => 'admin.support-priorities.destroy',
            ],

            'support-tickets' => [
                'all_support-tickets'    => 'admin.support-tickets.index',
                'add_support-tickets'    => 'admin.support-tickets.create',
                'store_support-tickets'  => 'admin.support-tickets.store',
                'show_support-tickets'   => 'admin.support-tickets.show',
                'edit_support-tickets'   => 'admin.support-tickets.edit',
                'delete_support-tickets' => 'admin.support-tickets.destroy',
            ],

            'subscription-plans' => [
                'all_subscription-plans'    => 'admin.subscription-plans.index',
                'add_subscription-plans'    => 'admin.subscription-plans.create',
                'store_subscription-plans'  => 'admin.subscription-plans.store',
                'show_subscription-plans'   => 'admin.subscription-plans.show',
                'edit_subscription-plans'   => 'admin.subscription-plans.edit',
                'delete_subscription-plans' => 'admin.subscription-plans.destroy',
            ],

            'customers' => [
                'all_customers'     => 'admin.customers.index',
                'add_customers'     => 'admin.customers.create',
                'store_customers'   => 'admin.customers.store',
                'show_customers'    => 'admin.customers.show',
                'edit_customers'    => 'admin.customers.edit',
                'delete_customers'  => 'admin.customers.destroy',
            ],

            'plan-histories' => [
                'all_plan-histories' => 'admin.plan-histories.index',
            ],

            'reports'=>[
                'words_reports'  => 'admin.reports.words',
                'code'           => 'admin.reports.codes',
                'image'          => 'admin.reports.images',
                'speech_to_text' => 'admin.reports.s2t',
                'mostUsed'       => 'admin.reports.mostUsed',
                'subscriptions'  => 'admin.reports.subscriptions',
            ],

            'Wordpress_Settings'=>[
                'all_wordpress_settings'     => 'admin.wordpress-settings.index',
                'add_wordpress_settings'     => 'admin.wordpress-settings.create',
                'store_wordpress_settings'   => 'admin.wordpress-settings.store',
                'show_wordpress_settings'    => 'admin.wordpress-settings.show',
                'edit_wordpress_settings'    => 'admin.wordpress-settings.edit',
                'delete_wordpress_settings'  => 'admin.wordpress-settings.destroy',
            ],

            'Wordpress_Credentials'=>[
                'test_wordpress_credentials'    => 'admin.connectWP',
                'all_wordpress_credentials'     => 'admin.wordpress-credentials.index',
                'add_wordpress_credentials'     => 'admin.wordpress-credentials.create',
                'store_wordpress_credentials'   => 'admin.wordpress-credentials.store',
                'show_wordpress_credentials'    => 'admin.wordpress-credentials.show',
                'edit_wordpress_credentials'    => 'admin.wordpress-credentials.edit',
                'delete_wordpress_credentials'  => 'admin.wordpress-credentials.destroy',
            ],

            'Wordpress_Tags'=>[
                'all_wordpress_tags'     => 'admin.wordpress-tags.index',
                'add_wordpress_tags'     => 'admin.wordpress-tags.create',
                'store_wordpress_tags'   => 'admin.wordpress-tags.store',
                'show_wordpress_tags'    => 'admin.wordpress-tags.show',
                'edit_wordpress_tags'    => 'admin.wordpress-tags.edit',
                'delete_wordpress_tags'  => 'admin.wordpress-tags.destroy',
            ],

            'Wordpress_Posts'=>[
                'all_wordpress_posts'     => 'admin.wordpress-posts.index',
                'add_wordpress_posts'     => 'admin.wordpress-posts.create',
                'store_wordpress_posts'   => 'admin.wordpress-posts.store',
                'show_wordpress_posts'    => 'admin.wordpress-posts.show',
                'edit_wordpress_posts'    => 'admin.wordpress-posts.edit',
                'delete_wordpress_posts'  => 'admin.wordpress-posts.destroy',
            ],

            'Wordpress_Categories'=>[
                'all_wordpress_categories'     => 'admin.wordpress-categories.index',
                'add_wordpress_categories'     => 'admin.wordpress-categories.create',
                'store_wordpress_categories'   => 'admin.wordpress-categories.store',
                'show_wordpress_categories'    => 'admin.wordpress-categories.show',
                'edit_wordpress_categories'    => 'admin.wordpress-categories.edit',
                'delete_wordpress_categories'  => 'admin.wordpress-categories.destroy',
            ],

            'Wordpress_Post_Publish'=>[
                'all_wordpress_posts_published'     => 'admin.wordpress-posts-published.index',
                'add_wordpress_posts_published'     => 'admin.wordpress-posts-published.create',
                'store_wordpress_posts_published'   => 'admin.wordpress-posts-published.store',
                'show_wordpress_posts_published'    => 'admin.wordpress-posts-published.show',
                'edit_wordpress_posts_published'    => 'admin.wordpress-posts-published.edit',
                'delete_wordpress_posts_published'  => 'admin.wordpress-posts-published.destroy',
            ],

            'Wordpress_Data_Sync'=>[
                'sync_all_authors'     => 'admin.sync.all.users',
                'sync_all_categories'  => 'admin.sync.all.categories',
                'sync_all_tags'        => 'admin.sync.all.tags',
            ],

            'wordpress_articles'=>[
                'all_articles'                  => 'admin.wordpress.list',
                'import_article_from_wordpress' => 'admin.wordpress.importArticle',
                'all_authors'                   => 'admin.wordpress.authorLists',
                'sync_all_authors_via_ajax'     => 'admin.wordpress.syncAllUsers',
            ],

            'System_Update'=>[
                'Health_Check'           => 'admin.systemUpdate.health-check',
                'Update_System'          => 'admin.systemUpdate.update',
                'Check_File_Permission'  => 'admin.systemUpdate.file-permission',
                'One_Click_Update'       => 'admin.systemUpdate.oneClickUpdate',
                'Manual_Update_System'   => 'admin.systemUpdate.update-version',
            ],
        ];
    }


    public function customerPermissionsRoutes()
    {
        return (new PermissionService())->customerPermissionRoutes();
    }

    public function customerTeamRoutes()
    {
        return [


            'allow_ai_chat'                    => [
                'chats'                        => 'admin.chats.index',
                'store_chats'                  => 'admin.chats.store',
                'all_chat-experts'             => 'admin.chat-experts.index',
                'add_chat-experts'             => 'admin.chat-experts.create',
                'store_chat-experts'           => 'admin.chat-experts.store',
                'show_chat-experts'            => 'admin.chat-experts.show',
                'edit_chat-experts'            => 'admin.chat-experts.edit',
                'delete_chat-experts'          => 'admin.chat-experts.destroy',
                'real_time_data'               => 'admin.chat-experts.destroy',
            ],
            'allow_ai_code'                    => [
                'ai_code-generator'            => 'admin.openai.chats.code-generator',
            ],
            'allow_templates'                  => [
                'all_template-category'        => 'admin.template-categories.index',
                'add_template-category'        => 'admin.template-categories.create',
                'store_template-category'      => 'admin.template-categories.store',
                'show_template-category'       => 'admin.template-categories.show',
                'edit_template-category'       => 'admin.template-categories.edit',
                'delete_template-category'     => 'admin.template-categories.destroy',
                'all_templates'                => 'admin.templates.index',
                'add_templates'                => 'admin.templates.create',
                'store_templates'              => 'admin.templates.store',
                'show_templates'               => 'admin.templates.show',
                'edit_templates'               => 'admin.templates.edit',
                'delete_templates'             => 'admin.templates.destroy',
                'stream_template_contents'     => 'admin.templates.stream',
                'save_templates_content'       => 'admin.templates.saveContent',
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
            'allow_ai_rewriter'                => [
                'all_ai-writer'                => 'admin.ai-writer.index',
                'add_ai-writer'                => 'admin.ai-writer.create',
            ],
            'allow_ai_detector'                => [
                'all_ai_detector'              => 'admin.ai-detector.index',
            ],
            'allow_ai_plagiarism'              => [
                'ai_plagiarism'                => 'admin.ai-plagiarism.index',
            ],
            'allow_ai_video'                   => [
                'ai_video'                     => 'admin.videos.index',
            ],
            'allow_text_to_speech'             => [
                'text_to_speech'               => 'admin.text-to-speeches.index',

            ],
            'allow_speech_to_text'             => [
                'speech_to_text'               => 'admin.voice-to-text.create',
            ],
            'allow_ai_image_chat'              => [
                'image_chat'                   => 'admin.chats.aiImageChat',
            ],
            'allow_ai_pdf_chat'                => [
                'pdf_chat'                     => 'admin.chats.aiPDFChat',
            ],

            'allow_images'                     => [
                'images'                       => 'admin.images.index',
                'image_generate'               => 'admin.images.generateImage',
                'dall_e_2'                     => 'admin.images.dallE2',
                'dall_e_3'                     => 'admin.images.dallE3',
                'Stable_Diffusion '            => 'admin.images.sdText2Image',
            ],
            'folders'                          => [
                'all_folders'                  => 'admin.folders.index',
                'add_folders'                  => 'admin.folders.create',
                'store_folders'                => 'admin.folders.store',
                'edit_folders'                 => 'admin.folders.edit',
                'delete_folders'               => 'admin.folders.destroy',
            ],
            'documents'                        => [
                'all_documents'                => 'admin.documents.index',
            ],
            'reports'                          => [
                'words_reports'                => 'admin.reports.words',
                'code'                         => 'admin.reports.codes',
                'image'                        => 'admin.reports.images',
                'speech_to_text'               => 'admin.reports.s2t',
                'mostUsed_template'            => 'admin.reports.mostUsed',
            ],
        ];
    }
}
