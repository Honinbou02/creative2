<?php

namespace App\Services\Model\Blog;

use App\Models\BlogCategory;
use Modules\WordpressBlog\Services\Categories\WpCategoryService;

class BlogCategoryService
{
    public function index()
    {
        $data                    = [];
        $data["blog_categories"] = $this->getAll(true, null,["updatedBy", "createdBy"],['user_id' => userID()]);
        $data['lastSyncUp']      = $this->lastSyncUpTime();
        return $data;
    }
    public function getAll(
        $isPaginateGetOrPluck = null,
        $onlyActives = null,
        $withRelationships = ["updatedBy", "createdBy"], 
        $conditions = [])
    {

        $query = BlogCategory::query()->filters()->orderBy('id', 'DESC');
        if(!empty($conditions)) {
            $query->where($conditions);
        }
        // Bind Relationships
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if(!is_null($onlyActives)){
            $query->isActive($onlyActives);
        }

        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("category_name", "id");
        }

        return $isPaginateGetOrPluck ? $query->paginate(maxPaginateNo()) : $query->get();
    }

    public function findBlogCategoryById($id, $withRelationships = [], $conditions = [])
    {
        $query = BlogCategory::query();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        return $query->findOrFail($id);
    }

    public function store(array $payloads)
    {
        if(isModuleActive('WordpressBlog') && wpCredential()) {
            $payloads['name'] = $payloads['category_name'];
            try {
                $blogCategory = (new WpCategoryService())->store($payloads);         
                $payloads['wp_id'] = $blogCategory->id;
            } catch (\Throwable $th) {
               
            }

        }
        return BlogCategory::query()->create($payloads);
    }

    public function update(object $blogCategory, array $payloads)
    {
        $blogCategory->update($payloads);
     
        if(isModuleActive('WordpressBlog') && $blogCategory->wp_id && wpCredential()) {           
            $payloads['name'] = $payloads['category_name'];
            (new WpCategoryService())->update($payloads, $blogCategory->wp_id);
        }
        return $blogCategory;
    }

    private function lastSyncUpTime()
    {
        $time = null;
        if(isModuleActive('WordpressBlog') && wpCredential()) {
            $blogCategory = BlogCategory::whereNotNull('wp_id')->latest()->first();
            if($blogCategory){
                return $blogCategory->created_at;
            }
        }
        return $time;
    }
}
