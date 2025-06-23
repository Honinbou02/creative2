<?php

use Illuminate\Support\Facades\Route;
use Modules\SocialPilot\App\Http\Controllers\Account\AccountController;
use Modules\SocialPilot\App\Http\Controllers\QuickText\QuickTextController;
use Modules\SocialPilot\App\Http\Controllers\Platform\PlatformController;
use Modules\SocialPilot\App\Http\Controllers\Post\SocialPostController;
use Modules\SocialPilot\App\Http\Controllers\SocialPilotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Route::get('cron-jobs/run', [SocialPilotController::class, 'handelCronJob']);

# social media 0auth connection
Route::group(['prefix' => 'social', 'as' => 'social.'], function () {
    Route::prefix("accounts")->controller(AccountController::class)->group(function () {
        Route::get('/{platform}/connect', "connect")->name("accounts.connect");
        Route::get('/{platform}/callback', "callback")->name("accounts.callback");
    });
});
    
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'verified', 'permission','demo.middleware']], function () {
    # platforms
    Route::prefix("platforms")->controller(PlatformController::class)->group(function () {
        // crud
        Route::get("/", "index")->name("platforms.index");
        Route::post("/edit", "edit")->name("platforms.edit");
        Route::post("/update", "update")->name("platforms.update");

        // configure
        Route::post("/open-platform-form", "renderPlatformForm")->name("platforms.configure-form");
        Route::post("/submit-platform-form", "storePlatformCredentials")->name("platforms.configure");
    });
    
    # accounts 
    Route::prefix("social-accounts")->controller(AccountController::class)->group(function () {
        Route::get("/", "index")->name("accounts.index");
        Route::get("/create", "create")->name("accounts.create");
        Route::post("/store", "store")->name("accounts.store");
        Route::delete("/delete/{id}", "destroy")->name("accounts.destroy");
    }); 

    # posts 
    Route::prefix("social-posts")->as('socials.')->controller(SocialPostController::class)->group(function () {
        Route::get("/", "index")->name("posts.index");
        Route::get("/create", "create")->name("posts.create");
        Route::post("/store", "store")->name("posts.store");
        Route::delete("/delete/{id}", "destroy")->name("posts.destroy");

        # ai assistant
        Route::get("/generation/ai-assistant", "aiAssistantForm")->name("posts.ai-assistant-form");
        Route::post("/generation/save-content", "saveAiAssistantContent")->name("posts.ai-assistant-save-contents"); 
        Route::get("/generation/streaming", "streamAiAssistant")->name("posts.ai-assistant.stream");

        # posts generation from blog-wizard article 
        Route::get("/generate-posts-from-article", "showArticlePostGenerationForm")->name("posts.show-article-post-generation-form");
        Route::post("/generate-posts-from-article", "articlePostGeneration")->name("posts.article-post-generation");
    });
 
    # quick texts 
    Route::prefix("quick-texts")->controller(QuickTextController::class)->group(function () {
        Route::get("/", "index")->name("quick-texts.index");
        Route::post("/form", "form")->name("quick-texts.form");
        Route::post("/store", "store")->name("quick-texts.store");
        Route::post("/update", "update")->name("quick-texts.update");
        Route::delete("/delete/{id}", "destroy")->name("quick-texts.destroy");
    });
});