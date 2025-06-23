<?php

namespace App\Models;

use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;
use App\Traits\BootTrait\FilterTrait;
use App\Traits\Models\Status\IsActiveTrait;
use App\Traits\Models\User\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatThread extends Model
{
    use HasFactory;
    use CreatedUpdatedByRelationshipTrait;
    use CreatedByUpdatedByIdTrait;
    use UserTrait;
    use IsActiveTrait;
    use SoftDeletes;

    protected $table    = "chat_threads";
    protected $fillable = [
        "is_active",
        "type",
        "title",
        "prompts_words",
        "completion_words",
        "total_words",
        "prompts_token",
        "completion_token",
        "total_token",
        "chat_expert_id",
        "user_id",
        "created_by_id",
        "updated_by_id",
        "deleted_at"
    ];

    public function chatExpert() : BelongsTo
    {
        return $this->belongsTo(ChatExpert::class, "chat_expert_id");
    }

    public function chats($limit = null) : HasMany
    {
        if($limit){
            return $this->hasMany(ChatThreadMessage::class, "chat_thread_id")
                    ->latest("id")
                    ->limit($limit);
        }

        return $this->hasMany(ChatThreadMessage::class, "chat_thread_id")->latest("id");
    }

    public function scopeChatExpertId($query, $chat_expert_id)
    {
        $query->where("chat_expert_id", $chat_expert_id);
    }

    public function scopeType($query, $type = "chat", $isLike = false)
    {
        if($isLike){
            $query->where("type", "like", "%$type%");
        }
        else{
            $query->where("type", $type);
        }
    }

    public function scopeFilters($query)
    {
        $request = request();

        
        // Chat Expert ID
          if($request->has("chat_expert_id") && !empty($request->chat_expert_id)){
            $query->where("chat_expert_id",(int)$request->chat_expert_id);
        }

        //Search
        if($request->has("search")){
            $query->where("search",$request->search);
        }
      
        // Type
        if($request->has("type")){
            $query->type($request->type);
        }

        // chat_thread_id
        if($request->has("chat_thread_id") && !empty($request->chat_thread_id)){
            $query->where("id", $request->chat_thread_id);
        }
        $query->where('user_id', userID());

    }
}
