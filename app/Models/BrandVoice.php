<?php

namespace App\Models;

use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandVoice extends Model
{
    use HasFactory;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    
    protected $table    = 'brand_voices';
    protected $fillable = [
        "brand_name",
        "brand_website",
        "industry",
        "brand_tagline",
        "brand_audience",
        "brand_tone",
        "brand_description",
        "user_id",
        "created_by_id",
        "updated_by_id",
        "deleted_by_id",
        "deleted_at"
    ];


    public function products() : HasMany
    {
        return $this->hasMany(BrandVoiceProduct::class, 'brand_voice_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,"user_id");
    }
}
