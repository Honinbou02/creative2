<?php

namespace Modules\SocialPilot\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilterByUser($q) {
        return $q->where('user_id', userID());
    }

    public function scopeCanBePosted($q) {
        return $q->whereIn('post_status',[appStatic()::POST_STATUS['PENDING'], appStatic()::POST_STATUS['SCHEDULED']]);
    }
    
    function platform() {
        return $this->belongsTo(Platform::class);
    }
    
    function platformAccount() {
        return $this->belongsTo(PlatformsAccount::class);
    }
}
