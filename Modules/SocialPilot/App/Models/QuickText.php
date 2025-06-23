<?php

namespace Modules\SocialPilot\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SocialPilot\Database\factories\QuickTextFactory;

class QuickText extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function scopeFilterByUser($q) {
        return $q->where('user_id', userID());
    }
}
