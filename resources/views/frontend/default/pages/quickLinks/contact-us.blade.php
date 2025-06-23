@extends('frontend.default.layouts.default')

@section('title')
    {{ localize('Contact Us') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('page-header-title')
    {{ localize('Contact Us') }}
@endsection

@section('contents')
    <!-- Banner About -->
    <section class="about-banner pt-120 pb-60 position-relative z-1">
        <div class="container">
            <div class="pt-60">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xxl-6">
                        <div class="text-center mb-15">
                            <h2 class="text-white mb-0">{{localize('Contact Us')}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Banner About -->


    @include('frontend.default.inc.contact-us-form')

    @include('frontend.default.pages.partials.faq')

    @include('frontend.default.inc.subscribe-area')



@endsection




@section('js')
    @include('frontend.common.js')
    @include('frontend.default.pages.quickLinks.contactUs.js')
@endsection
