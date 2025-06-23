<?php

namespace App\Services\Model\Tag;

use App\Models\Tag;
use Modules\WordpressBlog\Services\Tags\WpTagService;

class TagsService
{

    public function getAll(
        $isPaginateGetOrPluck = null,
        $onlyActives = null,
        $withRelationships = ["updatedBy", "createdBy"], $conditions = [])
    {

        $query = Tag::query()->filters()->orderBy('id', 'DESC');
        if(!empty($conditions)) {
            $query->where($conditions);
        }
        // Bind Relationships
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if(!is_null($onlyActives)){
            $query->isActive($onlyActives);
        }

        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("name", "id");
        }

        return $isPaginateGetOrPluck ? $query->paginate(maxPaginateNo()) : $query->get();
    }
    public function findTagById($id, $withRelationships = [], $conditions = [])
    {
        $query = Tag::query();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        return $query->findOrFail($id);
    }

    public function store(array $payloads)
    {
        if(isModuleActive('WordpressBlog') && wpCredential()) {
            try {
                $wpTag = (new WpTagService())->store($payloads);
                $payloads['wp_id'] = $wpTag->id;
            } catch (\Throwable $th) {
                
            }

        }
        return Tag::query()->create($payloads);
    }

    public function update(object $tag, array $payloads)
    {
        $tag->update($payloads);
        if(isModuleActive('WordpressBlog') && $tag->wp_id) {
            (new WpTagService())->update($payloads, $tag->wp_id);
        }
        return $tag;
    }
    public function index()
    {
        $data = [];
        $data["tags"] = $this->getAll(true, null,["updatedBy", "createdBy"],['user_id' => userID()]);
        $data['lastSyncUp'] = $this->lastSyncUpTime();
        return $data;
    }
    private function lastSyncUpTime()
    {
        $time = null;
        if(isModuleActive('WordpressBlog')) {
            $tag = Tag::whereNotNull('wp_id')->latest()->first();
            if($tag){
                return $tag->created_at;
            }
        }
        return $time;
    }

}

