@extends('frontend.default.layouts.default')
@section('title')
    {{ localize('Terms & Conditions') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section('contents')
    <section class="about-banner pt-120 pb-60 position-relative z-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xxl-6">
                    <div class="text-center mb-15">
                        <h2 class="text-white mb-0">{{ localize('WriterAP: Your AI Writing Assistant') }}</h2>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="text-center">
                        {!! systemSettingsLocalization('termsConditions') !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection
