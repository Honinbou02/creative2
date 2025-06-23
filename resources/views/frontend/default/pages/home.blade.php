@extends('frontend.default.layouts.default')

@section('title')
    {{ localize('Home') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <!-- Hero 1 -->
        @include('frontend.default.pages.partials.hero')
    <!-- /Hero 1 -->

    <!-- Brand 1 -->
        @include('frontend.default.pages.partials.brand')
    <!-- /Brand 1 -->

    <!-- Feature 1 -->
        @include('frontend.default.pages.partials.feature-1')
    <!-- /Feature 1 -->

    <!-- Feature 2 -->
        @include('frontend.default.pages.partials.feature-2')
    <!-- /Feature 2 -->

    <!-- Logo -->
    @if(getSetting('integration_is_active') != 0)
        @include('frontend.default.pages.partials.logo-section')
    @endif
    <!-- /Logo -->

    <!-- AI Tools -->
        @include('frontend.default.pages.partials.ai-tools')
    <!-- /AI Tools -->

    <!-- Template 1 -->
        @include('frontend.default.pages.partials.template-section')
    <!-- /Template 1 -->

    <!-- Price 1 -->
        @include('frontend.default.pages.partials.pricing')
    <!-- /Price 1 -->

    <!-- Feedback 1 -->
        @include('frontend.default.pages.partials.feedback-section')
    <!-- /Feedback 1 -->

    <!-- Faq 1 -->
        @include('frontend.default.pages.partials.faq')
    <!-- /Faq 1 -->
      @include('frontend.default.inc.contact-us-form')
      @include('frontend.default.inc.subscribe-area')
    <!-- Footer 1 -->

    @include("common.modal.package-payment-modal")

@endsection

@section('js')
    @include('frontend.common.js')
    @include('frontend.default.pages.js')
    @include('frontend.default.pages.subscribe-js')
    @include('frontend.default.pages.pricing-js')
@endsection
