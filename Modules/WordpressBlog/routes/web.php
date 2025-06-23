<?php

use Illuminate\Support\Facades\Route;
use Modules\WordpressBlog\App\Http\Controllers\Wp\WpTagController;
use Modules\WordpressBlog\App\Http\Controllers\Wp\WpPostController;
use Modules\WordpressBlog\App\Http\Controllers\WordpressBlogController;
use Modules\WordpressBlog\App\Http\Controllers\Wp\WpCategoryController;
use Modules\WordpressBlog\App\Http\Controllers\Wp\WpBlogPostPublishedController;
use Modules\WordpressBlog\App\Http\Controllers\Settings\WordpressSettingController;
use Modules\WordpressBlog\App\Http\Controllers\Credentials\WordpressCredentialsController;
use App\Http\Controllers\Authentication\Wp\WpBasicAuthController;
use Modules\WordpressBlog\App\Http\Controllers\Wp\WordpressArticleController;
use Modules\WordpressBlog\App\Http\Controllers\Wp\Author\WpAuthorController;


Route::group([], function () {
    Route::resource('wordpressblog', WordpressBlogController::class)->names('wordpressblog');
});
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'verified', 'permission']], function () {
    Route::get("connect-wp", [WpBasicAuthController::class, "connectWp"])->name("connectWP");

    Route::resource('wordpress-settings', WordpressSettingController::class)->only(['index', 'store']);
    Route::resource('wordpress-credentials', WordpressCredentialsController::class);
    Route::resource('wordpress-tags', WpTagController::class);
    Route::resource('wordpress-posts', WpPostController::class);
    Route::resource('wordpress-categories', WpCategoryController::class);
    Route::get('sync-all-users', [WpAuthorController::class, 'syncAllUsers'])->name('sync.all.users');
    Route::get('sync-all-tags', [WpTagController::class, 'syncAllTags'])->name('sync.all.tags');
    Route::get('sync-all-categories', [WpCategoryController::class, 'syncAllCategories'])->name('sync.all.categories');
    Route::resource('wordpress-posts-published', WpBlogPostPublishedController::class);


    Route::prefix("wordpress")->name("wordpress.")->group(function () {

        // Wordpress Authors
        Route::prefix("authors")->group(function () {
            Route::get("/", [WpAuthorController::class, "index"])->name("authorLists");
            Route::get("sync-all-users",[WpAuthorController::class, "syncAllUsers"])->name("syncAllUsers");
        });

        //Wordpress Articles
        Route::prefix("articles")->group(function () {
            Route::get("/", [WordpressArticleController::class, "index"])->name("list");
            Route::get("edit/{id}/wordpress-article", [WordpressArticleController::class, "edit"])->name("articles.edit");
            Route::post("import-article",[WordpressArticleController::class, "importArticle"])->name("importArticle");
        });
    });
});