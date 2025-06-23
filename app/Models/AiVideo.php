<?php

namespace App\Models;

use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiVideo extends Model
{
    use HasFactory;
    
    use SoftDeletes;
    use CreatedUpdatedByRelationshipTrait;
    use CreatedByUpdatedByIdTrait;
    
    protected $table = 'ai_videos';
    
    protected $fillable = [
        "is_active",
        "platform",
        "model",
        "language_id",
        "prompt",
        "title",
        "voice_id",
        "avatar_id",
        "avatar_style",
        "video_script",
        "caption",
        "matting",
        "video_id",
        "background_type",
        "background_value",
        "video_dimension",
        "generated_thumbnail",
        "generated_video_url",
        "generated_video_gif_url",
        "generated_video_url_caption",
        "generated_video_duration",
        "generated_video_status",
        "user_id",
        "created_by_id",
        "updated_by_id",
        "deleted_by_id",
        "deleted_at",
        "created_at",
        "updated_at"
    ];
}
