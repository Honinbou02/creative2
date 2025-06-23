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
    @php
        $totalWordBalance      = userActivePlan()["word_balance"] ?? 0;
        $totalWordUsed         = userActivePlan()["word_balance_used"] ?? 0;
        $totalRemainingBalance = userActivePlan()["word_balance_remaining"] ?? 0;

        $articleListRoute = route("admin.articles.index");
        $wpBlogEdit = false;
        if(!in_array(currentRoute(), ["admin.articles.edit", "admin.articles.create"])){
            $articleListRoute = route("admin.wordpress.list");
            $wpBlogEdit = true;
        }

    @endphp
    <div class="col-auto" id="balance-render">
        <x-common.balance-component :total="$totalWordBalance" :used="$totalWordUsed" :remaining="$totalRemainingBalance" />
    </div>
    <div class="col-auto">
        <a href="{{ $articleListRoute }}">
            <x-form.button type="button"><i data-feather="list"></i>{{localize('Article List')}}</x-form.button>
        </a>
    </div>
@endsection

@section("content")
    <!-- Page Content  -->
    <div class="section-space-xsm-bottom"> 
        <div class="container">
            <div class="row">
                @if(isOpenAiEngine(aiBlogWizardEngine()))
                    <x-common.open-ai-error/>
                @endif
                <div class="col-12">
                    <div class="card content-generator fullscreen-box flex-md-row">
                        @include("backend.admin.articles.article_left")
                        @include("backend.admin.articles.article_right")
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content  -->

    @include("backend.admin.articles.sidebar_article")
    @include('backend.admin.seo.article.sidebar-article-seo-checker')
    @include("backend.admin.articles.offcanvas.offcanvas-selected-image")
    @include('backend.admin.chats.send_mail')
    @if (isModuleActive('WordpressBlog'))
        @include('backend.admin.articles.published-to-wordpress-offcanvas')
    @endif
    
    @if (isModuleActive('SocialPilot'))
        @include('backend.admin.articles.social-post-offcanvas')
    @endif
@endsection

@section("js")
    @include("commonJs.balance-render-js")
    @include('backend.admin.articles.common_js')
    @include("backend.admin.articles.js")
@endsection

@section("styles")
    <style>
        .unsplashImageDiv{
            cursor: pointer;
        }

    </style>
@endsection
