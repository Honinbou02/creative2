<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class TemplateCategory extends Model
{
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    use SoftDeletes;

    protected $table = "template_categories";

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
    public function templates()
    {
        return $this->hasMany(Template::class, 'template_category_id', 'id');
    }
    public function adminTemplates()
    {
        return $this->hasMany(Template::class, 'template_category_id', 'id')->where('created_by_id', appStatic()::TYPE_ADMIN);
    }
    public function scopeFilters($query)
    {
        $request = request();

        // Search
        if ($request->has("search")) {
            $query->where('category_name', 'like', '%' . $request->search . '%');
        }

        // Active
        if ($request->has("is_active")) {
            $query->isActive((int) ($request->is_active));
        }

        return $query;
    }

}
