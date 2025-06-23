<?php

namespace Modules\WordpressBlog\Services\Posts;

use Modules\WordpressBlog\Services\WpBasicAuthService;

class WpPostService
{

    public function getAll()
    {
        return self::wpAuthService()->getPosts();
    }

    public function findWpPostById($id)
    {
        return self::wpAuthService()->showPost($id);
    }

    public function uploadWordpressPost(array $payloads)
    {   
        return self::wpAuthService()->uploadAPost($payloads);
    }

    public function update(array $payloads, $id)
    {
        return self::wpAuthService()->updatePost($payloads, $id);
    }
    public function delete($id)
    {
        return self::wpAuthService()->deletePost($id);
    }

    public function getMediaByMediaId($id)
    {
        return self::wpAuthService()->getMediaByMediaId($id);
    }


    public static function wpAuthService()
    {
        return new WpBasicAuthService();
    }
    public function syncPosts()
    {

    }

}
