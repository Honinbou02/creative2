<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\SocialPilot\App\Models\Platform;

class ArticlesSocialPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
