<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CreatedByIdAllGlobalScope;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TextToSpeech extends Model
{
    use HasFactory, SoftDeletes;
    use IsActiveTrait, CreatedByUpdatedByIdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "title",
        "slug",
        "language",
        "voice",
        "speed",
        "break",
        "text",
        "response",
        "speech",
        "file_path",
        "hash",
        "credits",
        "words",
        "storage_type",
        "type",
        "model",
        "subscription_user_id",
        "user_id",
        "created_by_id",
        "updated_by_id",
        "is_active",
        "updated_at",

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    protected static function booted()
    {
  
        static::addGlobalScope(new CreatedByIdAllGlobalScope);
      
    }
    public function scopeSearch($query, $search)
    {
        $query = $query->when($search, function ($q) use ($search) {
            $q->where(function ($newQ) use ($search) {
                $newQ->title($search, true, true);
            });
        });
    }
    public function scopeEngine($query, $engine)
    {
        $query = $query->when($engine, function ($q) use ($engine) {
            $q->where(function ($newQ) use ($engine) {
                $newQ->where('type', $engine);
            });
        });
    }

    public function scopeTitle($query, $name, $isLike = true, $orWhere = false)
    {
        $opt = "like";
        $val = '%' . $name . '%';
        if (!$isLike) {
            $opt = "=";
            $val = $name;
        }

        $orWhere ? $query->orWhere('title', $opt, $val) : $query->where('title', $opt, $val);
    }


}
