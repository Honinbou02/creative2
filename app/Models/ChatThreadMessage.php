<?php

namespace App\Models;

use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;
use App\Traits\BootTrait\FilterTrait;
use App\Traits\Models\Status\IsActiveTrait;
use App\Traits\Models\User\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatThreadMessage extends Model
{
    use HasFactory;
    use IsActiveTrait;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    use UserTrait;
    use SoftDeletes;
    use FilterTrait;

    
    protected $table    = "chat_thread_messages";
    protected $fillable = [
        "is_active",
        "random_number",
        "title",
        "platform",
        "type",
        "prompt",
        "file_path",
        "file_content",
        "file_embedding_content",
        "prompt_embedding_content",
        "response",
        "prompts_words",
        "completion_words",
        "total_words",
        "prompts_token",
        "completion_token",
        "total_token",
        "subscription_user_id",
        "subscription_plan_id",
        "chat_thread_id",
        "chat_expert_id",
        "user_id",
        "created_by_id",
        "updated_by_id",
        'generated_image_id',
        "deleted_at"
    ];

    protected $casts = [
      "file_embedding_content"   => "array",
      "prompt_embedding_content" => "array",
    ];

    public function scopeRandomNumber($query, $random_number)
    {
        $query->where("random_number",$random_number);
    }
    public function chatExpert()
    {
        return $this->belongsTo(ChatExpert::class, 'chat_expert_id', 'id')->withDefault();
    }
    public function chatThread()
    {
        return $this->belongsTo(ChatThread::class, 'chat_thread_id', 'id')->withDefault();
    }
}
