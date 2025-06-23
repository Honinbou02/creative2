@extends("layouts.default")
@section('title')
    {{ localize('Generate Article') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize('Generate Article'))

@section("breadcrumb")
@php
    $breadcrumbItems = [
        ["href"  => route('admin.articles.index'), "title" => "Blog List"],
        ["href"  => null, "title" => "Generate Article"]
    ];
@endphp
<x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section("pageTitleButtons")

    @if(isCustomerUserGroup())
        @php
            $totalWordBalance     = userActivePlan()["word_balance"] ?? 0;
            $totalWordUsed        = userActivePlan()["word_balance_used"] ?? 0;
            $totalRemainingBalance = userActivePlan()["word_balance_remaining"] ?? 0;
        @endphp


        <div class="col-auto" id="balance-render">
            <x-common.balance-component :total="$totalWordBalance"
                                    :used="$totalWordUsed"
                                    :remaining="$totalRemainingBalance"
                                    />
        </div>
    @else
        <div class="col-auto">
            <a href="{{ route('admin.articles.index') }}">
                <x-form.button type="button"><i data-feather="list"></i>{{localize('Blog Article List')}}
                </x-form.button>
            </a>
        </div>
    @endif
@endsection

@section("content")
    <!-- Page Content  -->
    <div class="section-space-xsm-bottom">
        <div class="container">
            <div class="row">
                @if(isOpenAiEngine())
                    <x-common.open-ai-error/>
                @endif
                <div class="col-12">
                    <div class="card content-generator flex-md-row">
                        @include("backend.admin.articles.article_left")
                        @include("backend.admin.articles.article_right")
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content  -->

    @include("backend.admin.articles.sidebar_article")
    @include('backend.admin.chats.send_mail')

@endsection

@section("js")
    @include("commonJs.balance-render-js")
    @include("backend.admin.articles.js")
@endsection
