<?php

namespace App\Services\Action;

use App\Services\Business\WordpressArticleService;
use Modules\WordpressBlog\Services\WpBasicAuthService;

/**
 * Class WordpressArticleActionService.
 */
class WordpressArticleActionService
{
    private $wordpressService;
    public function __construct()
    {
        $this->wordpressService = new WordpressArticleService();
    }

    public function getWordpressArticles($userId)
    {
        return $this->wordpressService->getWordpressArticles($userId);
    }

    public function searchWordpressPosts($searchingKeyword)
    {
        $posts = (new WpBasicAuthService())->searchPosts($searchingKeyword);

        // prepare posts array
        $data["posts"] = collect($posts)->map(function ($post) {
            return [
                'id'     => $post['id'],
                'title'  => $post['title']['rendered'],
                'link'   => $post['link'],
                'date'   => $post['date'],
                'status' => $post['status'],
                'tags'   => collect($post['tags'])->pluck('name')->implode(', '),
            ];
        })->toArray();

        $data["totalPosts"] = count($posts);

        return view("wordpressblog::articles.import.post-lists")->with($data)->render();
    }

    public function importWordpressPostContent($wp_post_id, $userId)
    {
        // Find wordpress article
        $wpArticle = (new WpBasicAuthService())->showPost((int) $wp_post_id);

        // Find WpBlogPost.php by wp_post_id. If found update the article content either create.

        // Find WpBlogPost.php by wp_post_id.
        $wpBlogPost = $this->getWpBlogPostByWpIdAndUserId($wpArticle->id, $userId);

        /**
         * Is already exists?
         * ---If yes Update the WpBlogPost.php and Update Article.php content.
         * -------Else Create a Article.php content & WpBlogPost.php Content
         */

        if(!empty($wpBlogPost)) {
            // Updating WpBlogPost.php
            $this->wordpressService->updateWpBlogPost($wpBlogPost,$wpArticle);

            // Update Article.php
            return $this->wordpressService->updateArticlePost($wpBlogPost->article, $wpArticle);
        }

        // Create a New Article
        $article = $this->wordpressService->storeArticle($wpArticle, $userId);

        // Wordpress post Article featured media update
         $this->wordpressService->updateArticlePost($article, $wpArticle);


        // Create a New WpBlogPost.php
        $this->wordpressService->storeWpBlogPost($article, $wpArticle);

        return $article;
    }

    public function getWpBlogPostByWpIdAndUserId($wp_post_id, $userId)
    {

        return $this->wordpressService->getWpBlogPostByWpId($wp_post_id, $userId);
    }

}
