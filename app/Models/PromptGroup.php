<?php

namespace App\Models;

use App\Models\Prompt;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class PromptGroup extends Model
{
    use HasFactory;
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    use SoftDeletes;

    protected $table = "prompt_groups";
    protected $fillable = [
        "group_name",
        "slug",
        "icon",
        "user_id",
        "created_by_id",
        "updated_by_id",
        "is_active",
        "deleted_at"
    ];


    public function prompts() : HasMany
    {
        return $this->hasMany(Prompt::class,"prompt_group_id");
    }
    public function scopeFilters($query)
    {
        $request = request();

        // Is Active
        if ($request->has("is_active")) {
            $query->isActive($request->is_active);
        }

        // Search
        if ($request->has("search")) {
            $query->where('group_name', 'like', '%' . $request->search . '%');
        }

        return $query;
    }
}
