<?php

namespace App\Services\Model\AdSense;

use App\Models\AdSense;

class AdSenseService
{

    public function index(): array
    {
        $data = [];
        $data['ad_senses'] = $this->getAll(false,true);
        return $data;
    }
    public function getAll($isPluck = null, $isGetOrPaginate = null, $onlyActives = null, $withRelationships = ["updatedBy", "createdBy"])
    {
        $query = $this->initModel()->when(getSetting('dashboard_adSense'), function ($q) {
            $q->where('is_dashboard', 1);
        });

        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if (!is_null($onlyActives)) {
            $query->isActive($onlyActives);
        }

        if ($isPluck === true) {
            return $query->pluck("name", "id");
        }

        return $isGetOrPaginate === true ? $query->paginate(maxPaginateNo()) : $query->get();
    }
    
    public function store(array $payloads)
    {
        $this->initModel()->create($payloads);
    }

    public function update($payloads, $id)
    {
       $model = $this->findById($id);
       return $model->update($payloads);
    }

    public function findById(int $id, $conditions = [], $is_active =  false)
    {
        return  $this->initModel()->where('id', $id)->when(!empty($conditions), function($q) use($conditions){
            $q->where($conditions);
        })->when($is_active, function($q) use($is_active){
            $q->where('is_active', $is_active);
        })->first();
    }

    private function initModel()
    {
        return new AdSense();
    }
}
