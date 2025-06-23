<?php

namespace Modules\WordpressBlog\Services\Tags;

use App\Models\Tag;
use Modules\WordpressBlog\App\Models\WpCredential;
use Modules\WordpressBlog\Services\WpBasicAuthService;

class WpTagService
{

    public function getAll()
    {
        return self::wpAuthService()->getTags();
    }

    public function findWpTagById($id)
    {
        return self::wpAuthService()->findTag($id);
    }

    public function store(array $payloads)
    {        
        return self::wpAuthService()->storeTag($payloads);
    }

    public function update(array $payloads, $id)
    {
        return self::wpAuthService()->updateTag($payloads, $id);
    }
    public function delete($id)
    {
        return self::wpAuthService()->deleteTag($id);
    }
    public static function wpAuthService()
    {
        return new WpBasicAuthService();
    }
    public function syncTags()
    {
        $tags = $this->getAll();
        foreach($tags as $tag) {
            Tag::query()->updateOrCreate([
                'slug'  => $tag->slug,
                'wp_id' => $tag->id,
            ], [
                'name'         => $tag->name,
                'is_active'    => 1,
                "slug"         => $tag->slug,
                "is_wp_sync"   => 1,
                "user_site_id" => user()->site?->id
            ]);
        }
    }
}
