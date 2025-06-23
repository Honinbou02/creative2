<?php

namespace App\Models;

use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voice extends Model
{
    use HasFactory;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    
    protected $table    = 'voices';
    protected $fillable = [
        "voice_id",
        "language",
        "gender",
        "name",
        "preview_audio",
        "support_pause",
        "emotion_support",
        "support_interactive_avatar",
        "is_active",
        "created_by_id",
        "updated_by_id",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
