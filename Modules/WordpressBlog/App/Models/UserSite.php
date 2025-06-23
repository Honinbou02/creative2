<?php

namespace Modules\WordpressBlog\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class UserSite extends Model
{
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    protected $fillable = [
        'url',
        'site_name',
        'user_name',
        'password',
        'is_active',
        'is_connection',
        'user_id',
        'created_by_id',
        'updated_by_id'
    ];
}
