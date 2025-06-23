<?php

namespace App\Models;

use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;
use App\Traits\Models\Status\IsActiveTrait;
use App\Traits\Models\User\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\WordpressBlog\App\Models\WpBlogPost;

class Article extends Model
{
    use HasFactory;
    use CreatedUpdatedByRelationshipTrait;
    use CreatedByUpdatedByIdTrait;
    use UserTrait;
    use SoftDeletes;
    use IsActiveTrait;

    protected $table = "articles";
    protected $fillable = [
        "user_id",
        "title",
        "language",
        "country",
        "subscription_user_id",
        "subscription_plan_id",
        "completed_step",
        "topic",
        "selected_keyword",
        "keyword_generated_content_id",
        "focus_keyword",
        "selected_title",
        "selected_meta_description",
        "meta_description_generated_content_id",
        "title_generated_content_id",
        "selected_outline",
        "outline_generated_content_id",
        "selected_image",
        "is_article_saved_by_save_changes_at",
        "wp_media_url",
        "article",
        "article_source",
        "article_generated_content_id",
        "total_words",
        "article_source",
        "wp_post_id",
        "wp_synced_at",
        "is_published",
        "is_published_wordpress",
        "created_by_id",
        "updated_by_id",
        "deleted_at",
    ];

    public function keywordContent() : BelongsTo
    {
        return $this->belongsTo(GeneratedContent::class,"keyword_generated_content_id")->withTrashed();
    }

    public function titleContent() : BelongsTo
    {
        return $this->belongsTo(GeneratedContent::class,"keyword_generated_content_id")->withTrashed();
    }

    public function outlineContent() : BelongsTo
    {
        return $this->belongsTo(GeneratedContent::class,"keyword_generated_content_id")->withTrashed();
    }

    public function articleContent() : BelongsTo
    {
        return $this->belongsTo(GeneratedContent::class,"keyword_generated_content_id")->withTrashed();
    }
    public function generatedArticles() : HasMany
    {
        return $this->hasMany(GeneratedContent::class,"article_id")->where('content_type', appStatic()::PURPOSE_ARTICLE)->withTrashed();
    }
    public function latestArticle() : BelongsTo
    {
        return $this->belongsTo(GeneratedContent::class,"id", "article_id")->where('content_type', appStatic()::PURPOSE_ARTICLE)->latest();
    }
    public function latestOutline() : BelongsTo
    {
        return $this->belongsTo(GeneratedContent::class,"id", "article_id")->where('content_type', appStatic()::PURPOSE_OUTLINE)->latest();
    }
    public function articles()
    {
        return $this->hasMany(GeneratedContent::class, "article_id");
    }
    public function wordTotals()
    {
        return $this->articles()->sum('total_words');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,"user_id")->withTrashed();
    }

    public function wpPosts():HasMany
    {
        return $this->hasMany(WpBlogPost::class, 'article_id', 'id');
    }
    public function scopeFilters($query)
    {
       $request = request();
       $query->when($request->completed_step == 5, function($q) use($request){
            $q->where('completed_step', $request->completed_step);
        })->when($request->completed_step == 1, function($q) use($request){
            $q->where('completed_step','!=', 5);
        })->when(isset(request()->is_published_wordpress), function($q) use($request){
            $q->where('is_published_wordpress', (int) $request->is_published_wordpress);
        })->when($request->article_source, function($q) use($request){
            $q->where('article_source', (int) $request->article_source);
        })->when($request->search, function($q) use($request){
            $q->where(function($q) use($request){
                $q->where('topic', 'LIKE', "%{$request->search}%");
                $q->orwhere('selected_title', 'LIKE', "%{$request->search}%");
            });
        });
    }
}
