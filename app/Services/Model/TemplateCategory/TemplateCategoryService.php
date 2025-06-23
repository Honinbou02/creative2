<?php

namespace App\Services\Model\TemplateCategory;

use App\Models\TemplateCategory;

class TemplateCategoryService
{

    public function getAll($isPaginateGetOrPluck = null, $onlyActives = null, $withRelationships = ["updatedBy", "createdBy"]) {
        $request = Request();
        $query = TemplateCategory::query()->filters();
      
        // Bind Relationships
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if(!is_null($onlyActives)){
            $query->isActive($onlyActives);
        }

        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("category_name", "id");
        }

        return $isPaginateGetOrPluck === 'get' ?  $query->get() : $query->paginate(maxPaginateNo());
    }

    public function findTemplateCategoryById($id, $withRelationships = []) {
        $query = TemplateCategory::query();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        return $query->findOrFail($id);
    }

    public function store(array $payloads) {
        return TemplateCategory::query()->create($payloads);
    }

    public function update(object $templateCategory, array $payloads) {
        $templateCategory->update($payloads);

        return $templateCategory;
    }
}
