<?php

namespace App\Http\Controllers\Admin\Chat;

use App\Mail\EmailManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChatThreadMessage;
use App\Services\Chat\ChatService;
use App\Services\Model\Article\ArticleService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Support\Facades\Mail;

class ChatHistoryController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $chatService;
    public function __construct()
    {
        $this->appStatic   = appStatic();
        $this->chatService = new ChatService;
    }
    # SEND IN EMAIL
    public function sendInEmail(Request $request)
    {
        if ($request->email == null) {
            flash(localize('Please type an email'))->error();
            return back();
        }
        $subject = localize('Chat Message');
        if($request->article_id) {
            $article  = (new ArticleService())->findArticleById($request->article_id);
            $subject  = $article->title;
            $messages = convertToHtml($article->article);
        }else {
            $conversation = $this->chatService->getDataForAjaxRequest($request);
            $messages     = $conversation['messages'];
            if (is_null($conversation)) {
                flash(localize('Chat not found'))->error();
                return back();
            }
        }

        try {
            $array['view']     = 'emails.chat';
            $array['from']     = env('MAIL_FROM_ADDRESS');
            $array['subject']  = $subject;
            $array['messages'] = $messages;

            Mail::to($request->email)->queue(new EmailManager($array));
            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Send to email successfully"),
             
            );
        } catch (\Throwable $th) {
         
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed Send to email"),
                [],
                errorArray($th)
            );
        }
        return back();
    }
    // download, copy chat history
    public function downloadChatHistory(Request $request)
    {
        try {
            $basePath = public_path('/');
            $type = $request->type;
            $conversations = $this->chatService->getDataForAjaxRequest($request);
            $conversation =  null;
            if (is_null($conversations)) {
                $msg = localize('Chat not found');
            }
            $messages = null;
            $name   = 'ai_chat';

            if ($conversations) {
                $messages  = $conversations['messages'];
            }

            if (!$messages) {
                flash(localize('No Message Fund'));
                return redirect()->back();
            }
            $data = ['messages' => $messages, 'conversation' => $conversation, 'type' => $type, 'download' => $request->share ? 'share' :'print'];
            if ($type == 'html') {
                $name =  str_replace(' ', '_', $name) . '.html';
                $file_path = public_path($name);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }

                $view = view('download.ai_chat_bot', $data)->render();
                file_put_contents($file_path, $view);
                return response()->download($file_path, $name);
            }
            if ($type == 'word') {
                $name =  str_replace(' ', '_', $name) . '.doc';
                $file_path = public_path($name);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }

                $view = view('download.ai_chat_bot', $data)->render();
                file_put_contents($file_path, $view);
              
                return response()->download($file_path);
            }
            if ($type == 'pdf') {
                return  view('download.ai_chat_bot', $data);
            }

            if ($type == 'copyChat') {
                return  view('download.copyChat', $data)->render();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteConversation(Request $request)
    {
        $chat_thread_id = $request->chat_thread_id;
        $chat_expert_id = $request->chat_expert_id;
        if($chat_thread_id && $chat_expert_id) {
            ChatThreadMessage::where('chat_thread_id', $chat_thread_id)->where('chat_expert_id', $chat_expert_id)->where('created_by_id', userID())->delete();
            return redirect()->route('admin.chats.index', ['chat_expert_id'=>$chat_expert_id]);
        }
    }
}
