<?php

namespace App\Traits\Models\User;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserTrait
{


    #Relationships
    public function merchant() : BelongsTo {
        return $this->belongsTo(User::class,"parent_user_id");
    }

    public function categories() : HasMany {
        return $this->hasMany(Category::class,"user_id");
    }


    #Scopes
    public function scopeUserType($query, $user_type = null) {
        $user_type = empty($user_type) ? getUserType() : appStatic()::TYPE_MERCHANT;

        $query->where("user_type", $user_type);
    }


    public function scopeMerchantId($query, $user_id = null) {
        $user_id = empty($user_id) ? merchantId() : $user_id;

        $query->where("user_id", $user_id);
    }

}
