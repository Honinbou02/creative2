<?php

namespace Modules\SocialPilot\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SocialPilot\Database\factories\PlatformFactory;

class Platform extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function scopeIsActive($q) {
        return $q->where('is_active', appStatic()::ACTIVE);
    }
}
