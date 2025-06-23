<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
@if($type == 'pdf'  && $download == 'print')
    <script>
        var is_chrome = function () { return Boolean(window.chrome); }
        if(is_chrome){
            window.print(); 
        }else{
            window.print();
        }
    </script>
@endif
<body  @if($type == 'pdf') onLoad="loadHandler();" @endif id="downloadChat" style="padding: 85px">

    @foreach ($messages as $message)
        <div style="margin-bottom: 20px;"><span style="font-weight: bold;">[{{ $message->created_at }}] {{ $message->createdBy->name }}:</span> {{$message->title}} </div>
   
        <div><span style="font-weight: bold;">[{{ $message->created_at }}] {{ $message->chatExpert->expert_name }} :</span> 
          
            @if ($message->type == appStatic()::PURPOSE_AI_IMAGE)
             <img src=" {{urlVersion($message->response)}}" alt="" height="100" width="100">
               
            @else 
            {{$message->response}}
            @endif
        </div>
    
    @endforeach
</body>
@if($type == 'pdf' && $download == 'print')
<script>
    function chatPrint() {
        window.print();
    }
</script>
@endif
</html>
