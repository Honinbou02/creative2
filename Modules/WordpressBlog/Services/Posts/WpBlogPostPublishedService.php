<?php

namespace Modules\WordpressBlog\Services\Posts;

use App\Services\Action\WordpressArticleActionService;
use App\Services\Model\Article\ArticleService;
use Modules\WordpressBlog\App\Models\WpBlogPost;
use Modules\WordpressBlog\Services\WpMedia\WpMediaService;

class WpBlogPostPublishedService {
    
    public function loadData()
    {
        $wp_post_id                = request()->wp_post_id;
        $article_source            = request()->article_source;
        $id                        = request()->id;
        $articleObj                = $this->article($id);
        
        $data                      = [];
        $data['article_id']        = $id;        
        $data["is_wordpress_post"] = request()->has("isWordpressPost");
        $data['wp_post_id']        = $wp_post_id;
        $data['article']           = $this->article($id);
        $data                     += (new ArticleService())->getWordPressFormFieldData();

        return $data;
    }

    public function index($id, $isGetOrFirst = null, $isArticleId = true)
    {
        if($isArticleId) {
            $query = self::initModel()->where('article_id', $id);

            return $isGetOrFirst ? $query->first() : $query->get();
        }

        return WpBlogPost::query()->findOrFail($id);
    }

    /**
     * @throws \Exception
     */
    public function published(array $payloads)
    {
        $id                  = $payloads['article_id'];
        $articleObj          = $this->article($id);

        $payloads['title']   = $articleObj->selected_title;
        $payloads['slug']    = slugMaker($articleObj->selected_title);
        $payloads['content'] = convertToHtml($articleObj->article);


        if($articleObj->selected_image && !request()->has("wp_post_id")) {
            $media = (new WpMediaService())->uploadImageToWordPress(asset($articleObj->selected_image));

            $payloads['featured_media'] = is_object($media) ? $media->id : $media["id"];
        }

        // Wordpress Post Uploading
        $post = (new WpPostService())->uploadWordpressPost($payloads);

        // Wordpress Post Response saving to the Database.
        $payloads['wp_id']            = $post->id;
        $payloads['categories']       = json_encode($payloads['categories']);
        $payloads['tags']             = json_encode($payloads['tags']);
        $payloads['author_id']        = $payloads['author'];
        $payloads['user_site_id']     = $articleObj->user?->site?->id;
        $payloads["preview_post_url"] = $post->guid->rendered;
        $payloads["date"]             = $post->date;
        $payloads["synced_at"]        = now();
        $payloads["status"]           = $post->status;
        $payloads["article_id"]       = $articleObj->id;

        $wpBlogPost = (new WordpressArticleActionService())->getWpBlogPostByWpIdAndUserId($post->id, $articleObj->user_id);

        if(empty($wpBlogPost)) {
            $payloads["is_updated"] = appStatic()::NEW_POST;
            $this->store($payloads);
        } else {
            $this->updateWpBlogPost($wpBlogPost, $payloads);
        }

        // Updating the Article
        $articleObj->update([
            'wp_post_id'             => $post->id,
            'is_published_wordpress' => 1,
            "wp_synced_at"           => now(),
        ]);

        return $articleObj;
    }

    public function article($id)
    {
        return (new ArticleService())->findArticleById($id);
    }
    public function store(array $payloads)
    {
      return  WpBlogPost::query()->create($payloads);
    }

    public function updateWpBlogPost(object $wpBlogPost, array $payloads)
    {
        $wpBlogPost->update($payloads);

        return $wpBlogPost;
    }

    private static function initModel()
    {
        return new WpBlogPost();
    }
    
}