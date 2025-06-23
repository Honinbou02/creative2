@extends('layouts.default')

@section('title')
    {{ localize('SEO Checker') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("SEO Checker"))

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => 'Article SEO Checker']];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    <div class="col-auto">
        <a href="{{ route('admin.articles.index') }}">
            <x-form.button type="button"><i data-feather="repeat"></i>{{localize('Blog Article List')}}</x-form.button>
        </a>
    </div>
    <div class="col-auto">
        @if (isset($article) && $article->id)
            <a href="{{ route('admin.articles.edit', $article->id) }}">
                <x-form.button type="button"><i data-feather="edit"></i>{{localize('Edit Article')}}</x-form.button>
            </a>
        @endif
    </div>
@endsection

@section('content')
    <!-- Page Content  -->
    <div class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card content-generator fullscreen-box flex-md-row">
                        @include("backend.admin.seo.article.left-article-seo-checker")

                        @include("backend.admin.seo.article.right-article-seo-checker")
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content  -->
    @if (isModuleActive('WordpressBlog'))
        @include('backend.admin.articles.published-to-wordpress-offcanvas')
    @endif
@endsection


@section("js")
    @include('backend.admin.articles.common_js')
    @include("backend.admin.seo.article.js")


@endsection