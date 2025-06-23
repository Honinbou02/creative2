@foreach ($messages as $message)
<span>[</span>{{ $message->created_at }}<span>]</span> {{ $message->createdBy->name }}: {{convertToHtml($message->title)}} <br>
   
<span>[</span>{{ $message->created_at }}<span>]</span> {{ $message->chatExpert->expert_name }} : {!! strip_tags(convertToHtml($message->response)) !!}


@endforeach