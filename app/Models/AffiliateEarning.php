<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateEarning extends Model
{
    use HasFactory;

    protected $table = "affiliate_earnings";
    protected $fillable = [
        "user_id",
        "referred_user_id",
        "subscription_user_id",
        "amount",
        "commission_rate",
        "is_active",
        "created_by_id",
        "updated_by_id",
        "deleted_at"
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function referredUser() : BelongsTo
    {
        return $this->belongsTo(User::class, "referred_user_id");
    }

    public function referredBy() : BelongsTo
    {
        return $this->belongsTo(User::class, "referred_user_id");
    }

    public function subscriptionPlan() : BelongsTo
    {
        return $this->belongsTo(SubscriptionUser::class, "subscription_user_id");
    }

}
