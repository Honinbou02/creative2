<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    </head>
    <body class="">

        <div class="row">
           
        </div>


        @if(session()->has("error"))
            <div class="text-red-500"> <h2> {{session("error")}} </h2> </div>
        @endif


        @if(session()->has("success"))
            <div class="text-red-500"> <h2> {{session("success")}} </h2> </div>
        @endif


        <a href="{{ route('connectWP') }}"
           class="mt-6 text-xl font-semibold dark:bg-gradient-to-bl text-gray-900 dark:text-white">Connect with WP</a>

            <br>
            <br>
            <br>

        <a href="{{ route('uploadAPost') }}"
           class="mt-6 text-xl font-semibold dark:bg-gradient-to-bl text-gray-900 dark:text-white"> Upload a Post </a>

        <div class="listenContents"></div>

        <div id="streamed-content"></div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


        <!-- resources/views/admin.blade.php -->
        <script>
            window.streamedContent = "";



            $(() => {
                geminiStreaming();
                let reqNo = 0;
            })


            function geminiStreaming() {

                const eventSource = new EventSource("{{ route('test',["content" => "hello"])  }}");

                eventSource.onmessage = (event) => {
                 

                    const eventData        = JSON.parse(event.data);
                    window.streamedContent = window.streamedContent + " " + eventData.data;

                    $("#streamed-content").text(window.streamedContent);
                };
            }

        </script>
    </body>
</html>
