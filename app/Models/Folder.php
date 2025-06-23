<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CreatedByIdAllGlobalScope;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class Folder extends Model
{
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    use SoftDeletes;

    protected $table = "folders";

    protected $fillable = [
        "folder_name",
        "slug",
        "icon",
        "user_id",
        "created_by_id",
        "updated_by_id",
        "is_active",
        "deleted_at"
    ];
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
  
        static::addGlobalScope(new CreatedByIdAllGlobalScope);
      
    }

    public function generateContents():HasMany
    {
        return $this->hasMany(GeneratedContent::class, 'folder_id', 'id');
    }

    public function generateImages():HasMany
    {
        return $this->hasMany(GeneratedImage::class, 'folder_id', 'id');
    }

    public function scopeFilters($query)
    {
        $request = request();

        // Search
        if ($request->has("search")) {
            $query->where('folder_name', 'like', '%' . $request->search . '%');
        }
        return $query;
    }
}
