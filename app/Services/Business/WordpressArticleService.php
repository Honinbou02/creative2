<?php

namespace App\Services\Business;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Modules\WordpressBlog\App\Models\WpBlogPost;
use Modules\WordpressBlog\Services\Posts\WpPostService;

/**
 * Class WordpressArticleService.
 */
class WordpressArticleService
{
    public function getWordpressArticles($userId)
    {

        return Article::query()
            ->filters()
            ->latest()
            ->paginate(maxPaginateNo());

//        return WpBlogPost::query()
//            ->with("article")
//            ->when(!isAdmin(), function ($query) use ($userId) {
//                $query->where("user_id", $userId);
//            })
//            ->latest()
//            ->paginate(maxPaginateNo());
    }

    public function getWpBlogPostByWpId($wp_id, $userId)
    {
        return WpBlogPost::query()
            ->where('wp_id', $wp_id)
            ->where("user_id", $userId)
            ->whereNull("deleted_at")
            ->first();
    }

    public function updateWpBlogPost(object $wpBlogPost, $wpArticle)
    {
        $wpBlogPost->update([
            "date"           => $wpArticle->date,
            "status"         => $wpArticle->status,
            "is_updated"     => 1,
            "tags"           => json_encode($wpArticle->tags),
            "categories"     => json_encode($wpArticle->categories),
            "wp_id"          => $wpArticle->id,
            "featured_media" => $wpArticle->featured_media
        ]);


        return $wpBlogPost;
    }


    public function updateArticlePost(object $article, $wpArticle): object
    {
        $appStatic = appStatic();

        $articleArr =[
            "title"                  => $wpArticle->title->rendered,
            "topic"                  => $wpArticle->title->rendered,
            "selected_title"         => $wpArticle->title->rendered,
            "completed_step"         => 0,
            "is_published_wordpress" => 0,
            "is_published"           => 0,
            "article"                => $wpArticle->content?->rendered,
            "total_words"            => totalWords($wpArticle->content?->rendered),
            "article_source"         => $appStatic::ARTICLE_SOURCE_WP,
            "wp_post_id"             => $wpArticle->id,
        ];

        $articleArr+= $this->getWordpressArticleFeaturedMedia($wpArticle, $article);

        $article->update($articleArr);

        return $article;
    }

    public function getWordpressArticleFeaturedMedia($wpArticle, object $article): array
    {
        $featuredMediaArr = [
            "selected_image" => null,
            "wp_media_url"   => null,
        ];
        // Check if the $wpArticle has featured_media
        if (!empty($wpArticle->featured_media)) {

            // Get The Featured Media
            $wpMedia = (new WpPostService())->getMediaByMediaId($wpArticle->featured_media);

            if (isset($wpMedia->data) && isset($wpMedia->data->status) && $wpMedia->data->status == appStatic()::NOT_FOUND) {
                // DO Nothing
            }else{
                $wpArticleImageUrl = $wpMedia->guid?->rendered;

                if($article->wp_media_url != $wpArticleImageUrl) {
                    // Save the Image to the MediaManager
                    $uploadDir = fileService()::DIR_WORDPRESS."/user_id_{$article->user_id}";

                    $filename = "wordpress_article_{$wpArticle->id}_".md5(time()).".jpg";

                    $localFile = $uploadDir."/".$filename;

                    if(!file_exists($localFile)) {
                        createDynamicDir($uploadDir);

                        $response = Http::get($wpArticleImageUrl);
                        file_put_contents($localFile, $response->body());
                    }

                    $featuredMediaArr["selected_image"] = $localFile;
                    $featuredMediaArr["wp_media_url"]   = $wpArticleImageUrl;
                }
            }
        }

        return $featuredMediaArr;
    }


    public function storeArticle($wpArticle, $userId): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $appStatic = appStatic();

        return Article::query()->create([
           "title"                  => $wpArticle->title->rendered,
           "completed_step"         => 0,
           "is_published_wordpress" => 0,
           "is_published"           => 0,
           "article"                => $wpArticle->content?->rendered,
           "total_words"            => totalWords($wpArticle->content?->rendered),
           "user_id"                => $userId,
           "topic"                  => $wpArticle->title->rendered,
           "selected_title"         => $wpArticle->title->rendered,
           "article_source"         => $appStatic::ARTICLE_SOURCE_WP,
           "wp_post_id"             => $wpArticle->id,
        ]);
    }

    public function storeWpBlogPost(object $article, $wpArticle)
    {

        $userSite = $article->user?->site;

        return WpBlogPost::query()->create([
            "article_id"       => $article->id,
            "preview_post_url" => $wpArticle->link,
            "website"          => $userSite->url,
            "date"             => $wpArticle->date,
            "is_updated"       => appStatic()::NEW_POST,
            "tags"             => json_encode($wpArticle->tags),
            "categories"       => json_encode($wpArticle->categories),
            "author_id"        => $wpArticle->author,
            "featured_media"   => $wpArticle->featured_media,
            "wp_id"            => $wpArticle->id,
            "status"           => $wpArticle->status,
            "user_site_id"     => $userSite->id,
            "user_id"          => $article->user_id,
        ]);
    }

}
