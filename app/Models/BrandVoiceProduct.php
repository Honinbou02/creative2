<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandVoiceProduct extends Model
{
    use HasFactory;

    protected $table    = 'brand_voice_products';
    protected $fillable = [
        "brand_voice_id",
        "name",
        "type",
        "features"
    ];

    public function brandVoice() : BelongsTo
    {
        return $this->belongsTo(BrandVoice::class,"brand_voice_id");
    }
}
