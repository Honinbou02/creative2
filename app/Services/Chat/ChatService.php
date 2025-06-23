<?php

namespace App\Services\Chat;

use App\Models\ChatExpert;
use App\Models\ChatThread;
use App\Services\Model\Prompt\PromptService;
use App\Services\Model\Prompt\PromptGroupService;
use App\Services\Model\ChatExpert\ChatExpertService;
use App\Services\Model\ChatThread\ChatThreadService;

class ChatService
{
    public function aiChatGetData($request):array
    {
        $data["chat_thread_id"]     = $request->chat_thread_id;
        $data["content_purpose"]    = $request->content_purpose;
        $data['chat_expert_id']     = $request->chat_expert_id ?? null;
        $data['groups']             = (new PromptGroupService())->getAll(null, true);
        $data['groupPrompts']       =  (new PromptService())->getAll(true, true);
        if($request->chat_expert_id && ($request->chat_thread_id == "null" || empty($request->chat_thread_id))) {
            $chatThread             = self::chatThreadService()->defaultThreadCreate($request->chat_expert_id, $data["content_purpose"]);
            $data["chat_thread_id"] = $chatThread->id ?? null;
        }
        $data['chatExpert']         = $data['chat_expert_id'] ? findById(new ChatExpert(), $request->chat_expert_id): null;
        $data['chats']              = $data['chatExpert'] ? $data['chatExpert']->threads : null;

        if($request->ajax()){
            $request['chat_thread_id'] = array_key_exists('chat_thread_id', $data) ? $data['chat_thread_id'] : null;
            $dataTemp = $this->getDataForAjaxRequest($request);
            $data     = array_merge($data, $dataTemp);

            return $data;
        }
      
        $data["experts"] = self::chatExpertService()->getAll(false, true, 'chat');

        return $data;
    }

    public function aiImageChatGetData($request):array
    {
        $data["chatExpert"]      = ChatExpert::where('type', 'image')->first();
        $data['chat_expert_id']  = $data['chatExpert']->id;

        $data["content_purpose"] = $request->content_purpose; 
        $data["pageTitle"]       = localize("AI-Image Chat");
        $data["search"]          = $request->content_purpose;
        $data["chat_thread_id"]  = $request->chat_thread_id;
        if($data['chat_expert_id'] && ($request->chat_thread_id == "null" || empty($request->chat_thread_id))) {
            $chatThread             = self::chatThreadService()->defaultThreadCreate($data['chat_expert_id'], $data["content_purpose"]);
            $data["chat_thread_id"] = $chatThread->id ?? null;          
        }
        $data["chats"]           =  $data['chatExpert'] ? $data['chatExpert']->threads : null;
        if($request->ajax()){
            $request['chat_thread_id'] = array_key_exists('chat_thread_id', $data) ? $data['chat_thread_id'] : null;
            $data += $this->getDataForAjaxRequest($request);
            return $data;
        }
        
        $data["experts"]         = self::chatExpertService()->getAll(false,true, 'image');

        return $data;
    }
    public function aiVisionChatGetData($request):array
    {
        $data["chatExpert"]      = ChatExpert::where('type', 'vision')->first();
        $data['chat_expert_id']  = $data['chatExpert']->id;
        $data["content_purpose"] = $request->content_purpose;
        $data["search"]          = $request->content_purpose;
        $data["pageTitle"]       = localize("AI-Vision Chat");
        $data["chat_thread_id"]  = $request->chat_thread_id;
        if($data['chat_expert_id'] && ($request->chat_thread_id == "null" || empty($request->chat_thread_id))) {
            $chatThread             = self::chatThreadService()->defaultThreadCreate($data['chat_expert_id'], $data["content_purpose"]);
            $data["chat_thread_id"] = $chatThread->id ?? null;          
        }
        $data["chats"]           = $data['chatExpert'] ? $data['chatExpert']->threads : null;

        if($request->ajax()){
            $request['chat_thread_id'] = array_key_exists('chat_thread_id', $data) ? $data['chat_thread_id'] : null;
            $data += $this->getDataForAjaxRequest($request);
            return $data;
        }
        return $data;
    }
    public function aiPdfChatGetData($request):array
    {
        $data["chatExpert"]      = ChatExpert::where('type', 'pdf')->first();
        $data['chat_expert_id']  = $data['chatExpert']->id;
        $data["content_purpose"] = $request->content_purpose;
        $data["search"]          = $request->content_purpose;
        $data["pageTitle"]       = localize("AI-PDF Chat");
        $data["chat_thread_id"]  = $request->chat_thread_id;
        if($data['chat_expert_id'] && ($request->chat_thread_id == "null" || empty($request->chat_thread_id))) {
            $chatThread             = self::chatThreadService()->defaultThreadCreate($data['chat_expert_id'], $data["content_purpose"]);
            $data["chat_thread_id"] = $chatThread->id ?? null;          
        }
        $data["chats"]           =  $data['chatExpert'] ? $data['chatExpert']->threads : null;

        if($request->ajax()){
            $request['chat_thread_id'] = array_key_exists('chat_thread_id', $data) ? $data['chat_thread_id'] : null;
            $data += $this->getDataForAjaxRequest($request);
            return $data;
        }

        return $data;
    }
    public function getDataForAjaxRequest($request):array
    {
        $chat_thread_id = $request->chat_thread_id;
        $chat_expert_id = $request->chat_expert_id;


        info("Chat Thread ID: ".$chat_thread_id." Chat Expert ID: ".$chat_expert_id);
        $data['messages'] = (new ChatThreadService())->getChatThreadMessagesByChatThreadIdAndChatExpertIdAndAndUserId();

        return $data;
    }
    public function defaultThreadCreate($chat_expert_id, $type = 'chat')
    {
        $data = [
            'chat_expert_id' => $chat_expert_id,
            'type'           => $type,
            'user_id'        => userId(),
        ];
        $checkExitThread = ChatThread::where($data)->latest()->first();
        if (!$checkExitThread) {
            return  ChatThread::updateOrCreate(
                $data,
                ['title' => "untitled-conversation"]
            );
        }
        return $checkExitThread;
    }
    public function aiImageStore(object $generateImage, object $request)
    {
        $chatThreadMessage = (new ChatThreadService())->getChatThreadMessageByRandomNumber(session(sessionLab()::SESSION_CHAT_RANDOM_NUMBER));
        $payloads = [
            'chat_thread_id'     => $request->chat_thread_id,
            'chat_expert_id'     => $request->chat_expert_id,
            'generated_image_id' => $generateImage->id,
            "prompt"             => $request->message,
            "platform"           => $generateImage->platform,
            "type"               => appStatic()::PURPOSE_AI_IMAGE,
            "response"           => $generateImage->file_path,
            "file_path"          => $generateImage->file_path,
            "prompts_words"      => $generateImage->prompts_words ?? 0,
            "completion_words"   => $generateImage->completion_words ?? 0,
            "prompts_token"      => $generateImage->prompts_token ?? 0,
            "completion_token"   => $generateImage->completion_token ?? 0,
            "total_token"        => $generateImage->total_token ?? 0,
        ];

        info("Before AI Image Store: " . json_encode($payloads));

         $chatThreadMessage->update($payloads);
         $response = [];
         $response['file_path'] = urlVersion($generateImage->file_path);
         $response['title'] = $request->message;

         info("Before Return the Response Params: ".json_encode($response));

         return $response;


    }
    private static function chatThreadService()
    {
        return new ChatThreadService();
    }
    private static function chatExpertService()
    {
        return new ChatExpertService();
    }
}
