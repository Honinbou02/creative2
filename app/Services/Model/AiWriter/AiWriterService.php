<?php

namespace App\Services\Model\AiWriter;

use App\Models\AiWriter;
use App\Models\GeneratedContent;


/**
 * Class ElevenLabService.
 */
class AiWriterService
{
    public function getAll(
        $isPaginateGetOrPluck = null,
        $onlyActives = null,
        $withRelationships = ["updatedBy", "createdBy"])
    {

        $query = GeneratedContent::query()->filters()->searchByUser()->where('content_type', appStatic()::PURPOSE_GENERATE_TEXT)->orderBy('id', 'DESC');

        // Bind Relationships
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if(!is_null($onlyActives)){
            $query->isActive($onlyActives);
        }

        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("title", "id");
        }

        return $isPaginateGetOrPluck ? $query->paginate(maxPaginateNo()) : $query->get();
    }
    public function findById($id, $withRelationships = [])
    {
        $query = GeneratedContent::query()->searchByUser();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        return $query->findOrFail($id);
    }

    public function store(array $payloads)
    {
        return GeneratedContent::query()->create($payloads);
    }
    public function save($request)
    {
        $id = $request->id;
        $model = $this->findById($id);
        if($model) {
            $model->response = $request->content;
            $model->title = $request->name;
            $model->save();
        }
        return $model;
    }

    public function delete(int $id)
    {
        $model = $this->findById($id);
        if($model){
            $model->delete();
            return true;
        }
        return false;
    }

}
