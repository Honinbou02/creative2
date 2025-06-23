<?php

namespace App\Services\Model;

use App\Models\Tag;
use App\Utils\AppStatic;

class TagService
{

    public function storeUpdateTags(array $tags)
    {

        foreach ($tags as $key=>$tag){

           $getSlug = $this->getBySlug($tag->slug);

           $payloads = [
               "name"       => $tag->name,
               "slug"       => $tag->slug,
               "is_wp_sync" => AppStatic::IS_WP_SYNC
           ];

           (!empty($getSlug) ? $this->updateTag($getSlug,$payloads) : $this->storeTag($payloads));
        }

        return true;
    }

    public function storeTag(array $payloads)
    {
        return Tag::query()->create($payloads);
    }

    public function updateTag(object $tag, array $payloads)
    {
        $tag->update($payloads);

        return $tag;
    }

    public function getBySlug($slug, $isFirst = true)
    {
        $query = Tag::query()->slug($slug);

        return $isFirst ? $query->first() : $query->firstOrFail();
    }
}
