<?php

namespace App\Services\Model\Blog;

use App\Models\Blog;
use App\Services\Model\Tag\TagsService;

class BlogService
{

    public function getAll(
        $isPaginateGetOrPluck = null,
        $onlyActives = null,
        $withRelationships = ["updatedBy", "createdBy"])
    {

        $query = Blog::query()->filters()->orderBy('id', 'DESC');

        // Bind Relationships
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if(!is_null($onlyActives)){
            $query->isActive($onlyActives);
        }

        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("_name", "id");
        }

        return $isPaginateGetOrPluck ? $query->paginate(maxPaginateNo()) : $query->get();
    }

    public function findBlogById($id, $withRelationships = [], $conditions = [])
    {
        $query = Blog::query();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        return $query->findOrFail($id);
    }

    public function store(array $payloads)
    {
        $blog = Blog::query()->create($payloads);

        if(isset($payloads["tag_ids"])){
            $blog->tags()->attach($payloads['tag_ids']);
        }

        return $blog;
    }

    public function update(object $blog, array $payloads)
    {
        $blog->update($payloads);

        if(isset($payloads["tag_ids"])){
            $blog->tags()->sync($payloads['tag_ids']);
        }

        return $blog;
    }
    public function index():array
    {
        $data = [];
        $data['tags']            = (new TagsService)->getAll(null, true);
        $data['blogs']           = $this->getAll(true, null);
        $data['blog_categories'] = (new BlogCategoryService)->getAll(null, true);
        return $data;
    }
}
