@extends('layouts.default')

@section('title')
    {{ localize('SEO Checker') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("SEO Checker"))

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => 'WordPress Imported Posts']];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    <div class="col-auto">
        <a href="{{ route('admin.wordpress.list') }}">
            <x-form.button type="button"><i data-feather="list"></i>{{localize('WordPress Post List')}}</x-form.button>
        </a>
    </div>
@endsection

@section('content')
    <!-- Page Content  -->
    <div class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card content-generator flex-md-row fullscreen-box">
                        @include("backend.admin.seo.article.left-article")

                        @include("backend.admin.seo.article.right-article")
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