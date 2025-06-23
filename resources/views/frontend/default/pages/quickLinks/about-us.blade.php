@extends('frontend.default.layouts.default')
@section('title')
    {{ localize('About Us') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section('contents')
    <!-- Banner About -->
    <section class="about-banner pt-120 pb-60 position-relative z-1">
        <div class="container">
            <div class="pt-60">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xxl-6">
                        <div class="text-center mb-15">
                            <h2 class="text-white mb-0">{{localize('About Us')}}</h2>
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
                {!! systemSettingsLocalization('aboutUsContents') !!}
            </div>
        </div>
    </section>
    <!-- /Content -->


    <!-- Brand 1 -->
    @include('frontend.default.pages.partials.brand')

    <!-- /Brand 1 -->



@endsection

@section('js')
    @include('frontend.common.js')
    @include('frontend.default.pages.js')
@endsection