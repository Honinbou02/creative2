<?php

namespace App\Services\Model\ChatThread;

use App\Models\ChatThread;
use App\Models\ChatThreadMessage;
use App\Services\Core\AiConfigService;
use App\Services\File\FileService;
use App\Services\Model\ChatExpert\ChatExpertService;

/**
 * Class ChatThreadService.
 */
class ChatThreadService
{

    public $sessionLab;
    public function __construct()
    {
        $this->sessionLab = sessionLab();
    }

    public function getAll(
        $isPaginateOrGet = false,
        $withRelationShip = [],
    )
    {
        $query = ChatThread::query()->latest()->filters();

        // Relationship Add
        (!empty($withRelationShip) ? $query->with($withRelationShip) : true);

        info("AI Image Query : ".json_encode($query->toRawSql()));

        return $isPaginateOrGet ? $query->paginate(maxPaginateNo()) : $query->get();
    }
   
    public function getThreadType()
    {
        if(currentRoute() == "admin.chats.aiVisionChat"){
            return "vision";
        }
    }

    public function store(array $payloads)
    {
        return ChatThread::query()->create($payloads);
    }

    public function findById($id, $findOrFail = true, $withRelationShip = [])
    {
        $query = ChatThread::query();

        // Relationship Add
        (!empty($withRelationShip) ? $query->with($withRelationShip) : true);

        return $findOrFail ? $query->findOrFail($id) : $query->find($id);
    }

    public function update($id, $payloads)
    {
        $model = $this->findById($id);
        $model->update($payloads);
    }
    /**
     *
     * */
    public function updateChatThreadWordsAfterNewMessageStore(object $chatThread, object $chatThreadMessage)
    {
        $chatThread->update([
            "prompts_words"    => $chatThread->prompts_words + $chatThreadMessage->prompts_words,
            "completion_words" => $chatThread->completion_words + $chatThreadMessage->completion_words,
            "total_words"      => $chatThread->total_words + $chatThreadMessage->total_words,
        ]);
    }


    public function getChatThreadByExpertIdAndUserId(int $expertId, int | null $userId = null)
    {
        $userId = !is_null($userId) ? $userId : userID();

        return ChatThread::query()
                ->chatExpertId($expertId)
                ->userId($userId)
                ->select("id", "chat_expert_id", "user_id","title")
                ->latest()
                ->get();

    }


    public function getChatThreadMessagesByChatThreadIdAndChatExpertIdAndAndUserId(
        int | null $chatExpertId = null,
        int | null $chatThreadId = null,
        int | null $chatUserId = null
    ) {
        return ChatThreadMessage::query()
                ->filters()
                ->get();
    }


    public function storeChatThreadMessage($request, $embedParams = [])
    {
        $chatExpertId    = session($this->sessionLab::SESSION_CHAT_EXPERT_ID);
        $chatThreadId    = session($this->sessionLab::SESSION_CHAT_THREAD_ID);
        $contentPurpose  = $request->content_purpose ?? appStatic()::PURPOSE_CHAT;
        $chatThread      = (new ChatThreadService())->findById($chatThreadId);

        $payloads = [
            "random_number"    => randomStringNumberGenerator(20,true,true),
            "title"            => $request->message ?? $chatThread->title,
            "platform"         => (new AiConfigService())->setPlatForm(appStatic()::ENGINE_OPEN_AI),
            "type"             => $contentPurpose,
            "chat_thread_id"   => $chatThread->id,
            "is_active"        => 1
        ];

        if(!empty($embedParams)){
            $payloads = array_merge($payloads, $embedParams);
        }

        if(isAiChat($contentPurpose) ){
            $chatExpert                 = (new ChatExpertService())->getChatExpertById($chatExpertId, false);
            $payloads["chat_expert_id"] = $chatExpert->id;
        }

        $filePath = [];

        if(isAiVision($contentPurpose)){
            if($request->has("images")){
                $filePath[] =  (new FileService())->tempFileProcessing($request->file("images"));
                info("All Images : ".json_encode($filePath));
                session()->put([
                    sessionLab()::SESSION_AI_VISION_IMAGES => $filePath
                ]);
            }
        }

        if(!empty($filePath)){
            $payloads["file_path"] = json_encode($filePath, JSON_THROW_ON_ERROR);
        }

        //$payloads = array_merge($payloads, $filePath);

        return ChatThreadMessage::query()->create($payloads);
    }

    public function getChatThreadMessageByRandomNumber(string $randomNumber)
    {
        return ChatThreadMessage::query()->randomNumber($randomNumber)->firstOrFail();
    }
    public function defaultThreadCreate($chat_expert_id, $type = 'chat')
    {
        $data = [
            'chat_expert_id' => $chat_expert_id,
            'type'           => $type,
            'user_id'        => userId(),
            'is_active'      => 1
        ];

        $checkExitThread = ChatThread::query()->where($data)->latest()->first();

        if(!$checkExitThread) {

          return  ChatThread::query()->updateOrCreate($data,
                ['title'=> "untitled-conversation"]
          );
        }

        return $checkExitThread;
    }
}
