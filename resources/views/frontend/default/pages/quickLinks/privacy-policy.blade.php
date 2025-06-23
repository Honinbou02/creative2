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
                            <h2 class="text-white mb-0">{{localize('Privacy Policy')}}</h2>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-center">
                            <img src="{{asset('frontend/assets/img/banner-about.png')}}" alt="image" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Banner About -->
    <!-- Content -->
    <section class="pt-60 pb-60">
        <div class="container">
            <div class="row">
                {!! convertToHtml(systemSettingsLocalization('privacyPolicy')) !!}
            </div>
        </div>
    </section>
    <!-- /Content -->
@endsection
