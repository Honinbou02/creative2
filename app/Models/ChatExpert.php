<?php

namespace App\Models;

use App\Traits\BootTrait\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Status\IsActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatExpert extends Model
{
    use HasFactory, SoftDeletes;
    use IsActiveTrait, CreatedByUpdatedByIdTrait;
    use FilterTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "expert_name",
        "short_name",
        "slug",
        "description",
        "role",
        "assists_with",
        "chat_training_data",
        "avatar",
        "type",
        "user_id",
        "created_by_id",
        "updated_by_id",
        "created_at",
        "updated_at",
        "is_active",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

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

    public function scopeSearch($query, $search) {
        $query = $query->when($search, function($q) use ($search) {
            $q->where(function($newQ) use ($search) {
                $newQ->name($search, true, true)
                ->description($search, true, true);
            });
        });
    }

    public function scopeName($query, $name, $isLike = true, $orWhere = false) {
        $opt = "like"; $val = '%'. $name .'%';
        if(!$isLike) {
            $opt = "="; $val = $name;
        }

        $orWhere ? $query->orWhere('expert_name', $opt, $val) : $query->where('expert_name', $opt, $val);
    }

    public function scopeIsActive($query) {
        $query->where('is_active', 1);
    }

    public function scopeDescription($query, $description, $isLike = true, $orWhere = false) {
        $opt = "like"; $val = '%'. $description .'%';
        if(!$isLike) {
            $opt = "="; $val = $description;
        }

        $orWhere ? $query->orWhere('description', $opt, $val) : $query->where('description', $opt, $val);
    }
    public function threads()
    {
        return $this->hasMany(ChatThread::class, 'chat_expert_id', 'id')->where('user_id', userID())->orderBy("id", "DESC");
    }
}
