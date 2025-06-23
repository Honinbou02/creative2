@extends('layouts.default')

@php
    $pageTitle = $pageTitle ??  localize("AI Chats");
@endphp

@section('title')
    {{ localize($pageTitle) }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", $pageTitle)
@section('breadcrumb')
    @php
        $breadcrumbItems = [
            ["href"  => null, "title" => $pageTitle]
        ];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems"/>
@endsection
@section('pageTitleButtons')
    @if(isCustomerUserGroup())
        @php
            $totalWordBalance      = userActivePlan()["word_balance"] ?? 0;
            $totalWordUsed         = userActivePlan()["word_balance_used"] ?? 0;
            $totalRemainingBalance = userActivePlan()["word_balance_remaining"] ?? 0;
        @endphp
        <div class="col-auto" id="balance-render">
            <x-common.balance-component :total="$totalWordBalance"
                                    :used="$totalWordUsed"
                                    :remaining="$totalRemainingBalance"
                                    />
        </div>
    @endif

    <div class="col-auto">
        <a href="{{ route('admin.chat-experts.index') }}" class="btn btn-primary">
            <i data-feather="list"></i> {{ localize('Chat Experts') }}
        </a>
    </div>

@endsection
@section('content')
    <section class="tt-section pb-4">
        <div class="container">
            <div class="row">
                @if(isOpenAiEngine(aiChatEngine()))
                    <x-common.open-ai-error/>
                @endif
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div id="tt-ai-chat" class="d-flex fullscreen-box bg-light-subtle" style="height: 80vh;">
                                <!-- chat right box start -->
                                <div class="tt-chat-right d-flex w-100">
                                    @include("backend.admin.chats.left_chat_threads")

                                    <div class="w-100 d-flex flex-column">
                                        <!-- chat header top start -->
                                        @include("backend.admin.chats.chat_header_top")
                                        <!-- chat header top end -->

                                        <!-- chat conversation start -->
                                        @include("backend.admin.chats.chat_body")

                                        <!-- chat footer start -->
                                        @include("backend.admin.chats.chat_footer")
                                        <!-- chat footer end -->
                                    </div>
                                    <div class="downloadChat" id="downloadChat">

                                    </div>
                                </div>
                                <!-- chat right box end -->

                                <!-- chat right with preloader start -->
                                <div class="tt-chat-right d-flex w-100 d-none">
                                    <!-- text preloader start -->
                                    <div class="tt-text-preloader tt-preloader-center">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <!-- text preloader end -->
                                </div>
                                <!-- chat right with preloader end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('backend.admin.chats.send_mail')
    @include('backend.admin.chats.prompt-modal')

    @include("backend.admin.chats.modal_image")
@endsection
@push('scripts')
    @include('common.media-manager.uppyScripts')
@endpush
@section("js")
    @include("backend.admin.chats.js")
    @include("common.voice-to-text-input-js")
@endsection