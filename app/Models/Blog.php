<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class Blog extends Model
{
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    use SoftDeletes;
    
    protected $table = "blogs";

    protected $fillable = [
        "title", 
        'slug',            
        "blog_category_id",    
        "is_active",       
        "short_description", 
        "description",      
        "blog_image",      
        "meta_title",       
        "meta_description", 
        "meta_image",        
        "user_id",
        "created_by_id",
        "updated_by_id",
        "is_active",
        "deleted_at"
    ];

    public function scopeFilters($query)
    {
        $request = request();

        // Search
        if ($request->has("search")) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return $query;
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tags', 'blog_id', 'tag_id');
    }
    public function pluckTags()
    {
        return $this->tags()->select('tag_id');
    }
    public function pluckTagIds()
    {
        return $this->hasMany(BlogTag::class, 'blog_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id')->withDefault([
            'category_name'=>'Not found'
        ]);
    }
}
