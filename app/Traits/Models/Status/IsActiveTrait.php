<?php
namespace App\Traits\Models\Status;
use Illuminate\Database\Eloquent\Builder;

trait IsActiveTrait{

    public function scopeIsActive(Builder $builder, $isActive = true) {
        $builder->where('is_active', $isActive ? 1 : 0);
    }
}
