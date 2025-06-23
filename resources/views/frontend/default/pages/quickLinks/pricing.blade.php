@extends('frontend.default.layouts.default')

@section('title')
    {{ localize('Pricing') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('page-header-title')
    {{ localize('Pricing Us') }}
@endsection

@section('contents')

    <div class="pt-120">
        @include('frontend.default.pages.partials.pricing')
    </div>

    @include('frontend.default.pages.partials.faq')

    @include("common.modal.package-payment-modal")
@endsection

@section('js')
    @include('frontend.common.js')
    @include('frontend.default.pages.quickLinks.contactUs.js')
    @include('frontend.default.pages.pricing-js')
    @include('frontend.default.pages.subscribe-js')
@endsection
