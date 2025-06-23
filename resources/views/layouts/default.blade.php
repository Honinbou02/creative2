<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <!--required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--meta-->
    <meta name="description" content="@yield('description', 'WriteBot ai content generator and writing assistant for saas platform'))">
    <meta name="keywords" content="@yield('keywords', 'ai, ai assistant, ai content writer, ai copywriting, ai image generator, ai speech to text, ai writer, chat gpt3, chatgpt, content generation, dall-e, openai, openai dalle, openai davinci, Text Generation'))">
    <meta name="author" content="ThemeTags">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <!--favicon icon-->
    <link rel="icon" href="{{ avatarImage(getSetting('favicon')) ?? asset('assets/img/favicon.png') }}" type="image/png" sizes="16x16">

    <!--title-->
    <title>@yield('title', config('app.name', 'WriteRap AI'))</title>
    <!-- recaptcha -->


    <!-- recaptcha -->
    @if (getSetting('enable_google_analytics') == 1)
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('TRACKING_ID') }}"></script>

        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ env('TRACKING_ID') }}');
        </script>
    @endif
    <!--build:css-->
    @include('common.css')
    <!-- endbuild -->
    @php
        echo getSetting('header_custom_css');
    @endphp

    @php
        echo getSetting('header_custom_scripts');
    @endphp

    @stack('css')
    @yield('styles')

    <style>
        .swal2-container{
            z-index: 99999999999!important;
        }

        .chatBodyPdfImg{
            height: 50px;
        }
    </style>
    @laravelPWA
</head>

<body>
    <input type="hidden" value="{{env('PWA_URL')}}" id="PWA_URL">
    <!--preloader start-->
    @if(getSetting('enable_preloader') !=0)
        @include('common.preloader')
    @endif
    <!--preloader end-->
    @include('common.sidebar')

    <!--main content wrapper start-->
    <main class="tt-main-wrapper bg-content" id="content">
        @include('common.media-manager.media-manager')
        @include('common.header')
        @include('common.pageTitle')

        <div class="container">
            <div class="row">
                <div class="col-12">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            <strong><?= session('error') ?> </strong>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            <strong><?= session('success') ?> </strong>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                </div>
            </div>
        </div>

        @yield('content')

        @include('common.footer')

        @include("common.modal.loading-modal")
    </main>
    <!--main content wrapper end-->

    <!--build:js-->
    @include('common.js')

    @yield("js")
    @php
        echo getSetting('footer_custom_scripts');
    @endphp
</body>
</html>
