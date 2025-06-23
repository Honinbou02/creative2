@forelse($chats as $key=>$chat)
    <x-chat.chat-thread-li
            totalWords="{{ $chat->total_words }}"
            id="{{ $chat->id }}"
            chat_thread_id="{{ $chat_thread_id ?? null }}"
            active="{{ isset($chat_thread_id) && $chat_thread_id == $chat->id ? true :false }}"
            created_at="{{ $chat->created_at->diffForHumans() }}"
            title="{{ $chat->title }}"></x-chat.chat-thread-li>
@empty
@endforelse