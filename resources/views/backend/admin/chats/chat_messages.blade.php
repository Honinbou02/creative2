@forelse($messages as $key=>$message)

    {{-- My Input as Command --}}
    @include("backend.admin.chats.chat_body_me", ["message" => $message])

    {{-- Expert Response --}}
    @include("backend.admin.chats.chat_body_expert", ["message" => $message])
@empty
<span class="text-center mt-4">{{localize("Conversation has not started yet.")}}</span>
@endforelse