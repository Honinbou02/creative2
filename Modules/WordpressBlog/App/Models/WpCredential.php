<?php

namespace Modules\WordpressBlog\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class WpCredential extends Model
{
    use HasFactory;
    use SoftDeletes;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    protected $fillable = [
        'domain',
        'user',
        'password',
        'is_active',
        'user_id',
        'created_by_id',
        'updated_by_id'
    ];
}
