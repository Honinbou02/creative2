<?php

namespace App\Models;

use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;
use App\Traits\Models\User\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiVoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;

    protected $fillable = [
        'name',
        'voice_id',
        'platform',
        'model',
        'language_id',
        'is_active',
        'user_id',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
        'deleted_at',
    ];


}
