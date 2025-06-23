<?php

namespace App\Models;

use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatCategory extends Model
{
    use HasFactory;
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    use SoftDeletes;

    protected $table = "chat_categories";
    protected $fillable = [
        "category_name",
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
        return $this->hasMany(ChatPrompt::class,"chat_category_id");
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
            $query->where('category_name', 'like', '%' . $request->search . '%');
        }

        return $query;
    }
}
