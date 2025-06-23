<?php

namespace App\Services\Model\ChatCategory;

use App\Models\ChatCategory;
use App\Models\TemplateCategory;

/**
 * Class ChatCategoryService.
 */
class ChatCategoryService
{
    public function getAll(
        $isPaginateGetOrPluck = null,
    )
    {
        $query = ChatCategory::query()->filters();

        
        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("category_name", "id");
        }

        return $isPaginateGetOrPluck ? $query->paginate() : $query->get();
    }

    public function findChatCategoryById($id, $withRelationships = [])
    {
        $query = ChatCategory::query();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        return $query->findOrFail($id);
    }

    public function store(array $payloads)
    {
        return ChatCategory::query()->create($payloads);
    }

    public function update(object $chatCategory, array $payloads)
    {
        $chatCategory->update($payloads);

        return $chatCategory;
    }

}

