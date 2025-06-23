<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <!--required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--meta-->
    <meta name="title" content="@yield('meta_title', getSetting('global_meta_title'))">
    <meta name="description" content="@yield('meta_description', getSetting('global_meta_description'))">
    <meta name="author" content="{{ getSetting('system_title') }}">
    <meta name="keywords" content="{{ getSetting('global_meta_keywords') }}">
    <meta property="og:image" content="@yield('meta_image', avatarImage(getSetting('global_meta_image')))" />

    <!--favicon icon-->
    <link rel="icon" href="{{ avatarImage(getSetting('favicon')) ?? asset('assets/img/favicon.png') }}" type="image/png" sizes="16x16">

    <!--title-->
    <title> @yield('title', getSetting('system_title'))</title>

    <!--build:css-->
    @include('frontend.default.inc.css')
    <!-- endbuild -->

    @php   
        echo getSetting('header_custom_css');
    @endphp

    @php
        echo getSetting('header_custom_scripts');
    @endphp
    @if (getSetting('enable_google_adsense') == 1 && getSetting('adsense_code_snippet'))
        @php
            echo getSetting('adsense_code_snippet');
        @endphp
    @endif
    @laravelPWA

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
</head>

<body class="bg-secondary">

    {!! adSense_header_top() !!}
    <!--preloader start-->
    @if (getSetting('enable_preloader') != '0')

        @php
            $preLoaderMediaManagerId = getSetting('preloader');
            $mediaFile               = mediaImage($preLoaderMediaManagerId);

            if(empty($mediaFile)){
                $mediaFile = asset('frontend/assets/img/logo-dark.png');
            }
        @endphp

        <div class="preloader bg-light-subtle">
            <div class="preloader-wrap">
                <img src="{{ $mediaFile }}" alt="logo" class="img-fluid">
                <div class="loading-bar"></div>
            </div>
        </div>
    @endif
    <!--preloader end-->
    
    <!-- Header -->
    @include('frontend.default.inc.header')
    <!-- /Header -->
    @include('flash::message')
    @yield('contents')


    @include('frontend.default.inc.footer') 

    <!--enable_cookie_consent-->
    @if (getSetting('enable_cookie_consent') == '1')
        <div class="cookie-alert">
            <div class="p-3 bg-white rounded shadow-lg">
                <div class="mb-3">
                    {!! getSetting('cookie_consent_text') !!}
                </div>
                <button class="btn btn-primary cookie-accept">
                    {{ localize('I Understood') }}
                </button>
            </div>
        </div>
    @endif

    @include('frontend.default.inc.js')
    
    @yield('js')
    @php
        echo getSetting('footer_custom_scripts');
    @endphp

</body>
</html>