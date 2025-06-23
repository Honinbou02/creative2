<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleSEO extends Model
{
    use HasFactory;

    protected $table = 'article_s_e_o_s';

    protected $fillable = [
        'article_id',
        'article_json',
        'seo_json',
        'seo_request_body',
        'seo_operator_url',
        'created_by_id',
    ];

    public function article() : BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
