<?php

namespace App\Http\Controllers\Admin\Chat;

use App\Utils\AppStatic;
use Illuminate\Http\Request;
use App\Services\Chat\ChatService;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Balance\BalanceService;
use App\Services\Integration\IntegrationService;
use App\Http\Requests\Admin\Chat\ChatStoreRequest;
use App\Services\Model\ChatThread\ChatThreadService;
use App\Http\Requests\Admin\ChatThread\ChatThreadRequest;
use App\Http\Resources\Admin\ChatThread\ChatThreadResource;

class ChatController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request, ChatService $chatService, AppStatic $appStatic)
    {
        $threadId = (int)session(sessionLab()::SESSION_CHAT_THREAD_ID);
        $request['content_purpose'] = $appStatic::PURPOSE_CHAT;
        $request["type"]            = $appStatic::PURPOSE_CHAT;
       
        $data                       = $chatService->aiChatGetData($request);
        if ($request->ajax()) {
            $chat_threads = $request->render_type == 'threads' ?  view("backend.admin.chats.chat_threads", $data)->render() : false;

            return $this->sendResponse(
                \appStatic()::SUCCESS_WITH_DATA,
                localize("Chats fetched successfully."),
                $chat_threads,
                [],
                [
                    "messages"       => view("backend.admin.chats.chat_messages", ["messages" => $data['messages'], ["chat_thread_id" => $data['chat_thread_id']]])->render(),
                    "chat_thread_id" => $data['chat_thread_id']
                ]
            );
        }

        return view("backend.admin.chats.index")->with($data);
    }

    public function aiImageChat(Request $request, ChatService $chatService, AppStatic $appStatic)
    {
    
        $request["type"]            = $appStatic::PURPOSE_AI_IMAGE;
        $request['content_purpose'] = $appStatic::PURPOSE_AI_IMAGE;
        $data                       = $chatService->aiImageChatGetData($request); 
      
        if ($request->ajax()) {
            $chat_threads = $request->render_type == 'threads' ?  view("backend.admin.chats.chat_threads", $data)->render() : false;
            return $this->sendResponse(
                \appStatic()::SUCCESS_WITH_DATA,
                localize("Vision Chats fetched successfully."),
                $chat_threads,
                [],
                [
                    "messages" => view("backend.admin.chats.chat_messages", ["messages" => $data['messages'], ["chat_thread_id" => $data['chat_thread_id']]])->render(),
                    "chat_thread_id" => $data['chat_thread_id']
                ]
            );
        }
        return view("backend.admin.chats.index")->with($data);
    }
    public function aiVisionChat(Request $request, ChatService $chatService, AppStatic $appStatic)
    {

        $request["type"]            = $appStatic::PURPOSE_VISION;
        $request['content_purpose'] = $appStatic::PURPOSE_VISION;
        $data                       = $chatService->aiVisionChatGetData($request);
       
        if ($request->ajax()) {
            $chat_threads = $request->render_type == 'threads' ?  view("backend.admin.chats.chat_threads", $data)->render() : false;
            return $this->sendResponse(
                \appStatic()::SUCCESS_WITH_DATA,
                localize("Vision Chats fetched successfully."),
                $chat_threads,
                [],
                [
                    "messages" => view("backend.admin.chats.chat_messages",  ["messages" => $data['messages'], ["chat_thread_id" => $data['chat_thread_id']]])->render(),
                    "chat_thread_id" => $data['chat_thread_id']
                ]
            );
        }
        return view("backend.admin.chats.index")->with($data);
    }

    public function store(ChatStoreRequest $request, ChatThreadService $chatThreadService, AppStatic $appStatic): \Illuminate\Http\JsonResponse
    {
        try {

            $chatThread = $chatThreadService->store($request->getData());

            return $this->sendResponse(
                $appStatic::SUCCESS_WITH_DATA,
                localize("Chat Thread created successfully."),
                ChatThreadResource::make($chatThread)
            );
        } catch (\Throwable $e) {
            wLog("Failed to store Chat Thread", errorArray($e));

            return $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }

    public function getFeatureName($sourceRoute, $featureName)
    {
        // PDF Chat
        if(isPdfChatRoute($sourceRoute)){
            $featureName = allowPdfChat();
        }

        // Vision Chat
        if(isVisionRoute($sourceRoute)){
            $featureName = allowAiVision();
        }

        // AI Image Chat
        if(isImageChatRoute($sourceRoute)){
            $featureName = allowImageChat();
        }

        return $featureName;
    }

    public function conversation(ChatThreadRequest $request, IntegrationService $integrationService, AppStatic $appStatic)
    {
        try {
            // Check balance
            checkWordBalance();

            //Is AiChat || PDF Chat Allowed || AI Vision
            $featureName = allowAiChat();

            if($request->has("sourceRoute")){
               $featureName = $this->getFeatureName($request->sourceRoute, $featureName);
            }

            // Check Valid Feature.
            checkValidCustomerFeature($featureName);
      
            $request["stream"]          = $request->content_purpose == $appStatic::PURPOSE_AI_IMAGE ? false : true;
            $request["content_purpose"] = $request->content_purpose ?? $appStatic::PURPOSE_CHAT;
            setChatThreadId();
            setChatExpertId();
            $response = [];
            $sessionLab      = sessionLab();
            session()->forget($sessionLab::SESSION_OPEN_AI_ERROR);

            $response['file_path'] = urlVersion('uploads/openAi/dall-e-2/f9D8Z0R3O0.png');
            $response['title']     = $request->message;
            $engine = $request["content_purpose"]==  $appStatic::PURPOSE_CHAT ?  aiChatEngine() : $appStatic::ENGINE_OPEN_AI;

            // Image Generate
            if (isAiImage($request->content_purpose)) {

                $data = $integrationService->contentGenerator($appStatic::ENGINE_OPEN_AI, $request);

                if ($data->response) {
                    $request["ai_image_prompt"] = $data->response;
                    $request["content_purpose"] = $appStatic::DALL_E_2;

                    $imageGenerator = $integrationService->imageGenerator($appStatic::ENGINE_OPEN_AI, $request);

                    // Image Balance Update
                    (new BalanceService())->updateImageBalance(getUserObject(), 1);

                    //TODO Image Generation
                    return (new ChatService())->aiImageStore($imageGenerator[0], $request);
                }
            }

            // Regular Chats/ Streaming
            return $integrationService->contentGenerator($engine, $request);
        } catch (\Throwable $e) {

            wLog("Failed to store chat thread conversation", errorArray($e));

            return $this->streamErrorResponse($e->getMessage());
        }
    }

    public function chatThreadConversation(ChatThreadRequest $request, ChatThreadService $chatThreadService, AppStatic $appStatic)
    {
        try {
            // Check balance
            checkWordBalance();

            //Is AiChat Allowed
            checkValidCustomerFeature(allowAiChat());

            $chatThread = $chatThreadService->findById($request->chat_thread_id, false);
            if(!$chatThread){
                return $this->sendResponse(
                    $appStatic::VALIDATION_ERROR,
                    localize('Conversation not found'),                 
                );
            }
            $request["stream"]          = true;
            $request["content_purpose"] = $request->content_purpose ?? $appStatic::PURPOSE_CHAT;
            setChatThreadId();
            setChatExpertId();

            $contentPurpose = $request->content_purpose;

            $chatThreadMessage = $chatThreadService->storeChatThreadMessage($request);

            // Set Random Number into Session to use it in next request while updating words.
            setAiChatRandomNumber($chatThreadMessage->random_number);

            return $this->sendResponse(
                $appStatic::SUCCESS_WITH_DATA,
                localize("Chat thread conversation stored successfully."),
                view("backend.admin.chats.chat_body_me", ["message" => $chatThreadMessage])->render()
            );
        } catch (\Throwable $e) {

            return $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}
