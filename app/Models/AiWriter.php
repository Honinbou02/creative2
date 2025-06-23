<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class AiWriter extends Model
{
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    use SoftDeletes;
    protected $table = "ai_writers";
    protected $fillable = [
        "title",
        "slug",
        "model_name",
        "prompt",
        "response",
        "prompts_words",
        "completion_words",
        "total_words",
        "prompts_token",
        "completion_token",
        "total_token",
        "folder_id",
        "content_type",
        "platform",
        "subscription_user_id",
        "subscription_plan_id",
        "user_id",
        "created_by_id",
        "updated_by_id"
    ];
    public function scopeFilters($query)
    {
        $request = request();

        // Is Active
        if ($request->has("is_active")) {
            $query->isActive($request->is_active);
        }

        // Search
        if ($request->has("search")) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return $query;
    }
}
