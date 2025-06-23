<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class AdSense extends Model
{
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;

    protected $table = "ad_senses";
    protected $fillable = [
        'slug',
        'size',
        'name',
        'code',
        'is_active',
        'is_dashboard',
        'user_id',
        'created_by_id',
        'updated_by_id'
    ];
}
