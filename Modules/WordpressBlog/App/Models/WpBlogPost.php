<?php

namespace Modules\WordpressBlog\App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;
use Modules\WordpressBlog\Database\factories\WpBlogPostFactory;

class WpBlogPost extends Model
{
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    use SoftDeletes;

    protected $table = "wp_blog_posts";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "article_id", 
        "website",
        "preview_post_url",
        "date", 
        "is_updated", 
        "tags", 
        "categories",
        "author_id",
        "featured_media",
        "wp_id",
        "status",
        "user_site_id", 
        "user_id", 
        "created_by_id",
        "updated_by_id",
        "deleted_at"
    ];


    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    protected static function newFactory(): WpBlogPostFactory
    {
        //return WpBlogPostFactory::new();
    }
}
