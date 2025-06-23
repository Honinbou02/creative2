<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\FAQ\FAQController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\Chat\ChatController;
use App\Http\Controllers\Admin\Page\PageController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Admin\Tags\TagsController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Customer\BalanceController;
use App\Http\Controllers\Admin\CronJobListController;
use App\Http\Controllers\Admin\Pdf\PdfChatController;
use App\Http\Controllers\Admin\Query\QueryController;
use App\Http\Controllers\Admin\Video\VideoController;
use App\Http\Controllers\Admin\StatusUpdateController;
use App\Http\Controllers\Admin\Folder\FolderController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\Prompt\PromptController;
use App\Http\Controllers\Customer\TeamMemberController;
use App\Http\Controllers\Admin\Report\ReportsController;
use App\Http\Controllers\Admin\Support\TicketController;
use App\Http\Controllers\Customer\PlanHistoryController;
use App\Http\Controllers\Admin\AdSense\AdSenseController;
use App\Http\Controllers\Admin\Article\ArticleController;
use App\Http\Controllers\Admin\Chat\ChatExpertController;
use App\Http\Controllers\Admin\Chat\ChatThreadController;
use App\Http\Controllers\Admin\Chat\OpenAiChatController;
use App\Http\Controllers\Admin\Project\ProjectController;
use App\Http\Controllers\Admin\TermsConditionsController;
use App\Http\Controllers\Admin\Utility\UtilityController;
use App\Http\Controllers\Admin\Chat\ChatHistoryController;
use App\Http\Controllers\Admin\Support\CategoryController;
use App\Http\Controllers\Admin\Support\PriorityController;
use App\Http\Controllers\Admin\User\UserProfileController;
use App\Http\Controllers\Admin\AiWriter\AiWriterController;
use App\Http\Controllers\Admin\Blog\BlogCategoryController;
use App\Http\Controllers\Admin\Currency\CurrencyController;
use App\Http\Controllers\Admin\Customer\CustomerController;
use App\Http\Controllers\Admin\Language\LanguageController;
use App\Http\Controllers\Admin\Settings\SettingsController;
use App\Http\Controllers\Admin\Template\TemplateController;
use App\Http\Controllers\Admin\Appearance\AboutUsController;
use App\Http\Controllers\Admin\Prompt\PromptGroupController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Generator\GeneratorController;
use App\Http\Controllers\Admin\Image\ImageGenerateController;
use App\Http\Controllers\Admin\Support\TicketReplyController;
use App\Http\Controllers\Admin\Appearance\ContactUsController;
use App\Http\Controllers\Admin\Settings\PWASettingsController;
use App\Http\Controllers\Admin\Appearance\AppearanceController;
use App\Http\Controllers\Admin\Balance\BalanceUpdateController;
use App\Http\Controllers\Admin\Permission\PermissionController;
use App\Http\Controllers\Admin\Voice2Text\Voice2TextController;
use App\Http\Controllers\Admin\MediaManager\UppyMediaController;
use App\Http\Controllers\Admin\NewsLetter\NewslettersController;
use App\Http\Controllers\Admin\Subscriber\SubscribersController;
use App\Http\Controllers\Authentication\Wp\WpBasicAuthController;
use App\Http\Controllers\Admin\Download\DownloadContentController;
use App\Http\Controllers\Admin\ChatCategory\ChatCategoryController;
use App\Http\Controllers\Admin\MediaManager\MediaManagerController;
use App\Http\Controllers\Admin\TextToSpeech\TextToSpeechController;
use App\Http\Controllers\Admin\Affiliate\EarningHistoriesController;
use App\Http\Controllers\Admin\Affiliate\WithdrawRequestsController;
use App\Http\Controllers\Admin\Plagiarism\ContentDetectorController;
use App\Http\Controllers\Admin\Voice2Text\Voice2TextInputController;
use App\Http\Controllers\Admin\Affiliate\AffiliateOverviewController;
use App\Http\Controllers\Admin\Affiliate\AffiliatePaymentsController;
use App\Http\Controllers\Admin\EmailTemplate\EmailTemplateController;
use App\Http\Controllers\Admin\Plagiarism\ContentPlagiarismController;
use App\Http\Controllers\Admin\ClientFeedback\ClientFeedbackController;
use App\Http\Controllers\Admin\Language\LanguageLocalizationController;
use App\Http\Controllers\Admin\PaymentGateway\PaymentGatewayController;
use App\Http\Controllers\Admin\PaymentRequest\PaymentRequestController;
use App\Http\Controllers\Admin\Settings\OfflinePaymentMethodController;
use App\Http\Controllers\Admin\Subscription\SubscriptionPlanController;
use App\Http\Controllers\Admin\GeneratedContent\GeneratedContentController;
use App\Http\Controllers\Admin\Subscription\SubscriptionSettingsController;
use App\Http\Controllers\Admin\TemplateCategory\TemplateCategoryController;
use App\Http\Controllers\Admin\Subscription\SubscriptionPlanTemplateController;
use App\Http\Controllers\Admin\Affiliate\AffiliatePayoutConfigurationsController;
use App\Http\Controllers\Admin\Image\PhotoStudioController;
use App\Http\Controllers\Admin\Voice\VoiceCloneController;
use App\Http\Controllers\v1\Admin\AiProductPhotographyController;
use App\Http\Controllers\Admin\AvatarPro\AvatarProController;
use App\Http\Controllers\Admin\BrandVoice\BrandVoiceController;
use App\Http\Controllers\Admin\Official\WriteRapController;
use App\Http\Controllers\Admin\Update\UpdateController;
use App\Http\Controllers\Admin\FilePermissionController;
use App\Http\Controllers\Admin\AiRewriter\AiRewriterController;
use App\Http\Controllers\Admin\Seo\SeoCheckerController;

Route::get("sync", [WpBasicAuthController::class, "syncWp"])->name("syncWP");
Route::get("connect-wp", [WpBasicAuthController::class, "connectWp"])->name("connectWP");
Route::get("upload-post", [WpBasicAuthController::class, "uploadAPost"])->name("uploadAPost");
Route::get("show/{id}", [WpBasicAuthController::class, "showPost"])->name("showPost");
Route::get("posts", [WpBasicAuthController::class, "getAllPosts"])->name("getAllPosts");
Route::get('/offline', function () {
    return view('vendor.laravelpwa.offline');
});


Auth::routes();



Route::get('/listing', [DashboardController::class, 'listing'])->name('list');

Route::middleware(["auth","demo.permission"])->prefix("stripe")->name("stripe.")->group(function () {
    Route::get("/checkout/plan/{stripe_plan}", [CheckoutController::class, "checkoutPlan"])->name("checkout");
    Route::get("success", [CheckoutController::class, "success"])->name("success");
    Route::get("cancel", [CheckoutController::class, "cancel"])->name("cancel");
});

# Admin Users
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'verified', 'permission',"demo.middleware"]], function () {
    //Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware("permission");

    Route::post("update/active-status", [StatusUpdateController::class, "updateActiveStatus"])->name("status.update");

    /* User Role Management Start */
    Route::prefix("user-role-management")->group(function () {
        Route::resource("permissions", PermissionController::class);
        Route::resource("roles", RoleController::class);
        Route::resource("users", UserController::class);
    });
    /* User Role Management End */


    Route::post('add-admin', [AdminController::class, 'store'])->name('store'); //->middleware('demo');
    Route::get('update-admin/{id}', [AdminController::class, 'getUser'])->name('edit');
    Route::post('update-admin/{id}', [AdminController::class, 'update'])->name('update');
    Route::post('update-admin-status/{id}', [AdminController::class, 'status'])->name('status');
    Route::post('delete-admin/{id}', [AdminController::class, 'destroy'])->name('delete');

    Route::prefix("openai")->name("openai.")->group(function () {
        Route::resource("chats", OpenAiChatController::class);

        Route::prefix("chats")->name("chats.")->group(function () {
            Route::get("code-generator/hub", [OpenAiChatController::class, "codeGenerator"])->name("code-generator");
            Route::post("content-generator", [OpenAiChatController::class, "aiCodeGenerator"])->name("contentGenerator");
        });
    });

    Route::post('/ai-chat-history/send-email', [ChatHistoryController::class, 'sendInEmail'])->name('chat.sendInEmail');
    Route::get('/ai-chat-history/download', [ChatHistoryController::class, 'downloadChatHistory'])->name('chat.download');
    Route::post('/ai-chat-history/delete-conversation', [ChatHistoryController::class, 'deleteConversation'])->name('chat.delete-conversation');

    Route::get('profile', [UserProfileController::class, 'index'])->name('profile');
    Route::post('profile-info-update', [UserProfileController::class, 'infoUpdate'])->name('info-update');
    Route::post('profile-change-password', [UserProfileController::class, 'changePassword'])->name('change-password');

    Route::resource("articles", ArticleController::class);

    // Article Meta Description & Focus Keyword
    Route::prefix("articles")->name("articles.")->group(function () {
       Route::post("store-article-meta", [ArticleController::class, "storeArticleMetaOrKeyword"])->name("storeArticleMetaOrKeyword");
    });

    Route::prefix("seo")->name("seo.")->group(function () {
        Route::get("/", [SeoCheckerController::class, "index"])->name("index");
        Route::get("article/{id}/wp-post-seo-checker", [SeoCheckerController::class, "wpPostSeoChecker"])->name("wpPostSeoChecker");
        Route::post("article/{id}/wp-post-seo-checker", [SeoCheckerController::class, "storeWpPostSeoChecker"])->name("storeWpPostSeoChecker");
        Route::get("article/{id}/blog-seo-checker", [SeoCheckerController::class, "articleSeoChecker"])->name("articleSeoChecker");
        Route::post("article/{id}/article-seo-checker", [SeoCheckerController::class, "storeArticleSeoChecker"])->name("storeArticleSeoChecker");
    });

    Route::prefix("generator")->name("generator.")->group(function () {
        Route::get("new-image-search", [GeneratorController::class, "imageSearch"])->name("imageSearch");
        Route::post("new-topics", [GeneratorController::class, "generateTopics"])->name("generateTopics");
        Route::post("new-keywords", [GeneratorController::class, "generateKeywords"])->name("generateKeywords");
        Route::post("new-titles", [GeneratorController::class, "generateTitles"])->name("generateTitles");
        Route::post("new-meta-description", [GeneratorController::class, "generateMetaDescriptions"])->name("generateMetaDescriptions");
        Route::post("new-outlines", [GeneratorController::class, "generateOutlines"])->name("generateOutlines");
        Route::post("new-images", [GeneratorController::class, "generateImages"])->name("generateImages");
        Route::get("new-articles", [GeneratorController::class, "generateArticles"])->name("generateArticles");
    });

    Route::prefix("users")->name("users.")->group(function () {
        Route::post("balance-update", [BalanceUpdateController::class, "updateBalance"])->name("updateBalance");
    });

    /**
     * Templates
     * */
    Route::resource("template-categories", TemplateCategoryController::class);
    Route::resource("templates", TemplateController::class);

    /**
     * Templates
     * */
    Route::prefix("templates")->name("templates.")->group(function () {
        Route::post("{id}/save-content", [TemplateController::class, "saveTemplateContent"])->name("saveContent");
        Route::get("{id}/streaming", [TemplateController::class, "streamTemplate"])->name("stream");
    });
    /**
     * Folder
     */
    Route::resource("folders", FolderController::class)->except(['show']);
    Route::get('move-folder-content', [FolderController::class, 'moveToFolderContent'])->name('folders.move-folder-content');
    Route::post('move-folder', [FolderController::class, 'moveToFolder'])->name('folders.move-folder');
    /**
     * text to speech
     */
    Route::resource("text-to-speeches", TextToSpeechController::class);

    /**
     * AI writer
     */
    Route::resource("ai-writer", AiWriterController::class);
    Route::get('ai-writer/generate/content', [AiWriterController::class, 'generate'])->name('ai-writer.generate');
    Route::post('ai-writer/generate/save-change', [AiWriterController::class, 'saveChange'])->name('ai-writer.save-change');

    //AI-ReWriter.
    Route::resource("ai-rewriter", AiRewriterController::class);

    Route::prefix("ai-rewriter")->name("ai-rewriter.")->group(function () {
        Route::post("rewrite", [AiRewriterController::class, "rewrite"])->name("rewrite");
    });
    /**
     * Media manager
     */
    Route::resource("media-managers", MediaManagerController::class);
    /**
     * Prompts
     * */
    Route::resource("chat-categories", ChatCategoryController::class);
    Route::resource("prompt-groups", PromptGroupController::class);
    Route::resource("prompts", PromptController::class);

    Route::get('group-prompts', [PromptController::class, 'groupPrompts'])->name('group-prompts');
    /**
     * Chat
     * */
    Route::prefix("chats")->name("chats.")->group(function () {
        Route::get("/", [ChatController::class, "index"])->name("index");
        Route::post("store", [ChatController::class, "store"])->name("store");
        Route::post("chat-thread-conversation", [ChatController::class, "chatThreadConversation"])->name("chatThreadConversation");
        Route::get("conversation", [ChatController::class, "conversation"])->name("conversation");

        // AI Vision
        Route::get("ai-image-chat", [ChatController::class, "aiImageChat"])->name("aiImageChat");
        Route::get("ai-vision-chat", [ChatController::class, "aiVisionChat"])->name("aiVisionChat");

        # AI PDF Chat
        Route::prefix("ai-pdf-chat")->group(function () {
            Route::get("/", [PdfChatController::class, "aiPdfChat"])->name("aiPDFChat");
            Route::post("pdf-chat-embedding", [PdfChatController::class, "pdfChatEmbedding"])->name("pdfChatEmbedding");
            Route::get("pdf-chat", [PdfChatController::class, "pdfChatCompletion"])->name("pdfChatCompletion");
            Route::post("destroy-pdf-chat", [PdfChatController::class, "destroy"])->name("destroy");
        });
    });

    Route::resource("chat-experts", ChatExpertController::class);

    Route::get("generated-content/show/{id}", [GeneratedContentController::class, 'show'])->name('generated-content.show');
    Route::post("generated-content/update", [GeneratedContentController::class, 'update'])->name('generated-content.update');
    Route::post("generated-content/destroy", [GeneratedContentController::class, 'destroy'])->name('generated-content.destroy');

    Route::get("documents", [ProjectController::class, 'index'])->name('documents.index');
    # documents ajax
    Route::post('/move-to-folder-modal', [ProjectController::class, 'moveToFolderModalOpen'])->name('projects.move-to-folder-content');
    Route::post('/move-to-folder', [ProjectController::class, 'moveToFolder'])->name('projects.move-to-folder');

    Route::resource("settings", SettingsController::class);
    Route::get("settings-credentials", [SettingsController::class, 'credentials'])->name('settings.credentials');

    /**
     * Image Generation
     * */
    Route::prefix("images")->name("images.")->group(function () {
        Route::get("/", [ImageGenerateController::class, "index"])->name("index");
        Route::post("generate-image", [ImageGenerateController::class, "generateImage"])->name("generateImage");
        Route::post("dall-e-2", [ImageGenerateController::class, "dallE2"])->name("dallE2");
        Route::post("dall-e-3", [ImageGenerateController::class, "dallE3"])->name("dallE3");
        Route::post("sd-text-2-image", [ImageGenerateController::class, "sdText2Image"])->name("sdText2Image");
        Route::post("sd-image-2-image-multi-prompt", [ImageGenerateController::class, "sdImage2ImageMultiPrompt"])->name("sdImage2ImageMultiPrompt");
        Route::post("sd-image-2-image-prompt", [ImageGenerateController::class, "sdImage2ImagePrompt"])->name("sdImage2ImagePrompt");
        Route::post("sd-image-2-image-masking", [ImageGenerateController::class, "sdImage2ImageMasking"])->name("sdImage2ImageMasking");
        Route::post("sd-image-2-image-upscale", [ImageGenerateController::class, "sdImage2ImageUpscale"])->name("sdImage2ImageUpscale");
        Route::DELETE("destroy/{id}", [ImageGenerateController::class, 'destroy'])->name('destroy');
        // Photo Studio
        Route::prefix("photo-studio")->name("photoStudio.")->group(function () {
            Route::get("/", [PhotoStudioController::class, "index"])->name("index");
            Route::post("/generate-image", [PhotoStudioController::class, "generatePhotoStudioImage"])->name("generatePhotoStudioImage");
        });

        // Product Shot
        Route::prefix("product-shot")->name("productShot.")->group(function () {
            Route::get("/", [AiProductPhotographyController::class, "index"])->name("index");
            Route::post("/generate-image", [AiProductPhotographyController::class, "generateProductShotImage"])->name("generateProductShotImage");
        });
    });

    /**
     * Video Generation
     * */
    Route::prefix("videos")->name("videos.")->group(function () {
        Route::get("/", [VideoController::class, "index"])->name("index");
        Route::post("ai-image-to-video", [VideoController::class, "sdImage2Video"])->name("sdImage2Video");
        Route::get('/video/{id}', [VideoController::class, 'downloadVideo'])->name("downloadVideo");
    });
    
    Route::resource('languages', LanguageController::class);
    Route::resource('localizations', LanguageLocalizationController::class)->only(['show', 'store']);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('media-managers', MediaManagerController::class);

    Route::get('/media-manager/get-files', [UppyMediaController::class, 'index'])->name('uppy.index');
    Route::get('/media-manager/get-selected-files', [UppyMediaController::class, 'selectedFiles'])->name('uppy.selectedFiles');
    Route::post('/media-manager/add-files', [UppyMediaController::class, 'store'])->name('uppy.store');
    Route::get('/media-manager/delete-files/{id}', [UppyMediaController::class, 'delete'])->name('uppy.delete');

    Route::resource('tags', TagsController::class);

    Route::resource('pages', PageController::class);

    Route::resource('blog-categories', BlogCategoryController::class);

    Route::resource('blogs', BlogController::class);

    Route::resource('faqs', FAQController::class);

    // support ticket
    Route::resource('support-categories', CategoryController::class);
    Route::resource('support-priorities', PriorityController::class);
    Route::resource('support-tickets', TicketController::class);
    Route::resource('support-replies', TicketReplyController::class);
    Route::get('support-tickets/reply/{id}',[ TicketController::class, 'reply'])->name('support-tickets.reply');

    // subscriptions
    Route::resource('subscription-plans', SubscriptionPlanController::class);
    Route::post('subscription-plans/package-update', [SubscriptionPlanController::class, 'updatePlan'])->name('subscription-plans.package-update');
    Route::get('subscription-plans/get-price/{id}', [SubscriptionPlanController::class, 'getPrice'])->name('subscription-plans.get-price');
    Route::post('/update-package-templates', [SubscriptionPlanTemplateController::class, 'updateTemplates'])->name('subscriptions.updateTemplates');
    // customer
    Route::resource('customers', CustomerController::class);
    Route::post('assign-package-form', [CustomerController::class, 'assignPackage'])->name('customers.assign-package');
    Route::post('assign-package', [CustomerController::class, 'assignPackageUpdate'])->name('customers.assign-package.update');
    Route::get('customers-export', [CustomerController::class, 'exports'])->name('customers.export');

    Route::get('plan-histories', [PlanHistoryController::class, 'index'])->name('plan-histories.index');
    Route::get('plan-histories/{id}', [PlanHistoryController::class, 'show'])->name('plan-histories.show');
    Route::get('plan-invoice/{id}', [PlanHistoryController::class, 'invoice'])->name('plan-invoice.index');
    Route::get('plan-download/{id}', [PlanHistoryController::class, 'download'])->name('plan-invoice.download');

    Route::resource('voice-to-text', Voice2TextController::class)->only(['create', 'store']);

    Route::prefix("clone")->group(function () {
        Route::prefix("voice")->name("voice.")->group(function () {
            Route::get("/", [VoiceCloneController::class, "index"])->name("index");
            Route::post("/clone-voice", [VoiceCloneController::class, "cloneVoice"])->name("cloneVoice");
        });
    });

    # Avatar
    Route::prefix("avatar-pro")->name("avatarPro.")->group(function () {
       Route::get("/", [AvatarProController::class, "index"])->name("index");
       Route::get("create", [AvatarProController::class, "create"])->name("create");
       Route::get("load-avatars-talking-photos", [AvatarProController::class, "getAvatarsAndTalkingPhotos"])->name("getAvatarsAndTalkingPhotos");
       Route::get("load-voices", [AvatarProController::class, "getVoices"])->name("getVoices");
       Route::get("import-avatars-talking-photos", [AvatarProController::class, "importAvatarsAndTalkingPhotos"])->name("importAvatarsAndTalkingPhotos");
       Route::get("import-voices", [AvatarProController::class, "getVoices"])->name("importVoices");
       Route::get("load-avatars-by-id", [AvatarProController::class, "getAvatarByAvatarId"])->name("getAvatarByAvatarId");
       Route::post("create-video", [AvatarProController::class, "createVideo"])->name("createVideo");
    });

    // Brand Voice
    Route::resource("brand-voices", BrandVoiceController::class);

    Route::resource('ai-plagiarism', ContentPlagiarismController::class);
    Route::resource('ai-detector', ContentDetectorController::class);

    Route::resource('payment-gateways', PaymentGatewayController::class);

    # reports
    Route::group(['prefix' => 'reports'], function () {
        Route::get('/words-generated', [ReportsController::class, 'words'])->name('reports.words');
        Route::get('/codes-generated', [ReportsController::class, 'codes'])->name('reports.codes');
        Route::get('/images-generated', [ReportsController::class, 'images'])->name('reports.images');
        Route::get('/speech-to-text-generated', [ReportsController::class, 's2t'])->name('reports.s2t');
        Route::get('/most-used-templates', [ReportsController::class, 'mostUsed'])->name('reports.mostUsed');
        Route::get('/subscriptions', [ReportsController::class, 'subscriptions'])->name('reports.subscriptions');
    });

    Route::get('appearance', [AppearanceController::class, 'index'])->name('appearance.index');
    Route::post('appearance/update', [AppearanceController::class, 'update'])->name('appearance.update');
    Route::resource('client-feedbacks', ClientFeedbackController::class);

    Route::get('subscription-settings', [SubscriptionSettingsController::class, 'index'])->name('subscription-settings.index');
    Route::post('subscription-settings/gateway-product/store', [SubscriptionSettingsController::class, 'storeGatewayProduct'])->name('subscription-settings.store.gateway.product');



    Route::group(['prefix' => 'ad_sense', 'as' => 'settings.adSense.'], function () {
        Route::get('/', [AdSenseController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [AdSenseController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AdSenseController::class, 'update'])->name('update');
    });

    # affiliate routes
    Route::group(['prefix' => 'affiliate'], function () {


        # overview
        Route::get('/overview', [AffiliateOverviewController::class, 'index'])->name('affiliate.overview');
        Route::get('/configure-payouts', [AffiliatePayoutConfigurationsController::class, 'index'])->name('affiliate.payout.configure');
        Route::post('/configure-payouts', [AffiliatePayoutConfigurationsController::class, 'store'])->name('affiliate.payout.configureStore');

        # withdraw
        Route::get('/withdraw-requests', [WithdrawRequestsController::class, 'index'])->name('affiliate.withdraw.index');
        Route::post('/withdraw-requests', [WithdrawRequestsController::class, 'store'])->name('affiliate.withdraw.store');
        Route::post('/update-requests', [WithdrawRequestsController::class, 'update'])->name('affiliate.withdraw.update');

        # earning histories
        Route::get('/earning-histories', [EarningHistoriesController::class, 'index'])->name('affiliate.earnings.index');

        # payments
        Route::get('/payments', [AffiliatePaymentsController::class, 'index'])->name('affiliate.payments.index');
    });

    Route::resource('offline-payment-methods', OfflinePaymentMethodController::class);

    Route::get('email-templates', [EmailTemplateController::class, 'index'])->name('email-templates.index');
    Route::post('email-templates/update/{id}', [EmailTemplateController::class, 'update'])->name('email-templates.update');

    Route::get('utilities', [UtilityController::class, 'index'])->name('utilities');
    Route::get('clear-cache', [UtilityController::class, 'clearCache'])->name('clear-cache');
    Route::get('clear-log', [UtilityController::class, 'clearLog'])->name('clearLog');
    Route::get('debug', [UtilityController::class, 'debug'])->name('debug');
    Route::get('maintenance', [UtilityController::class, 'maintenance'])->name('maintenance');

    Route::get('cron-list', [CronJobListController::class, 'index'])->name('cron-list');

    Route::resource('team-members', TeamMemberController::class);
    # bulk-emails

    Route::get('/bulk-emails', [NewslettersController::class ,'index'])->name('newsletters.index');
    Route::post('/bulk-emails/send', [NewslettersController::class,'sendNewsletter'])->name('newsletters.send');
    Route::resource('subscribers',SubscribersController::class)->only(['index', 'destroy']);

    Route::post('/voice-to-text-input', [Voice2TextInputController::class, 'recordVoiceToText'])->name('recordVoiceToText');
    Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us.index');
    Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact-us.index');
    Route::post('contact-us', [ContactUsController::class, 'store'])->name('contact-us.store');
    Route::get('contact-queries', [QueryController::class, 'index'])->name('queries.index');
    Route::get('/mark-as-read/{id}', [QueryController::class, 'read'])->name('queries.markRead');
    Route::delete('/delete-queries/{id}/{force?}', [QueryController::class, 'destroy'])->name('queries.delete');
    Route::get('/delete-all-queries', [QueryController::class, 'deleteAll'])->name('queries.deleteAll');
    Route::get('privacy-policy',[PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
    Route::get('terms-conditions',[TermsConditionsController::class, 'index'])->name('terms-conditions.index');
    Route::get('pwa-settings', [PWASettingsController::class, 'index'])->name('pwa-settings.index');
    Route::post('pwa-settings', [PWASettingsController::class, 'store'])->name('pwa-settings.store');
    Route::post('chat-thread-update', [ChatThreadController::class, 'update'])->name('chat-thread.update');
    Route::delete('chat-thread/{id}', [ChatThreadController::class, 'destroy'])->name('chat-thread.destroy');
    Route::get('balance-render', [BalanceController::class, 'index'])->name('balance-render');
    Route::get('download-content', [DownloadContentController::class, 'index'])->name('download-content');
    Route::group(['prefix'=>'payment-requests', 'as'=> 'payment-requests.'], function($route){
        $route->get('/', [PaymentRequestController::class, 'index'])->name('index');
        $route->post('/approve', [PaymentRequestController::class, 'approve'])->name('approve');
        $route->post('/feedback', [PaymentRequestController::class, 'feedback'])->name('feedback');
        $route->post('/reject', [PaymentRequestController::class, 'reject'])->name('reject');
        $route->post('/reSubmit', [PaymentRequestController::class, 'reSubmit'])->name('reSubmit');
    });

    /**
     * Health, License, Update
     * */

    Route::prefix("writerap")->name("systemUpdate.")->group(function () {
        Route::get("/health-check", [WriteRapController::class, "healthCheck"])->name("health-check");
        Route::get("update", [UpdateController::class, "update"])->name("update");
        Route::get("file-permission", [FilePermissionController::class, "filePermission"])->name("file-permission");
        Route::get('one-click-update', [UpdateController::class, 'oneClickUpdate'])->name('oneClickUpdate');
        Route::post('manual-update-system', [UpdateController::class, 'versionUpdateInstall'])->name('update-version');
    });
});
