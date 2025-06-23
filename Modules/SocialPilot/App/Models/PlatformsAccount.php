<?php

namespace Modules\SocialPilot\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlatformsAccount extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];

    public function platform() {
        return $this->belongsTo(Platform::class);
    }

    public function scopeFilterByUser($q) {
        return $q->where('user_id', userID());
    }
}
