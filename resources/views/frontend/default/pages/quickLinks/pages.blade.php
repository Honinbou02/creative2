@extends('frontend.default.layouts.default')
@section('title')
    {{ localize('Privacy Policy') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section('contents')
    <!-- Banner About -->
    <section class="about-banner pt-120 pb-60 position-relative z-1">
        <div class="container">
            <div class="pt-60">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xxl-6">
                        <div class="text-center mb-15">
                            <h2 class="text-white mb-0">{{$page->title}}</h2>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        {!! convertToHtml($page->content) !!}
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Banner About -->

@endsection
        