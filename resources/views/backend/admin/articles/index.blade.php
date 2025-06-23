@extends('layouts.default')

@section('title')
    {{ localize('Article List') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("Article List")) 
    
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => 'Article List']];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    <div class="col-auto">
        <a href="{{ route('admin.articles.create') }}">
            <x-form.button type="button"><i data-feather="plus"></i>{{localize('Generate Blog Article')}}
            </x-form.button>
        </a>
    </div>
@endsection

@section('content')
    <!-- Page Content  -->
    <section class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 bg-transparent pb-0">
                            <form action="" method="get" name="searchForm" id="searchForm">
                                <div class="row g-3">
                                    <div class="col-auto flex-grow-1">
                                        <div class="tt-search-box w-auto">
                                            <div class="input-group">
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                        data-feather="search" class="icon-16"></i></span>
                                                <input class="form-control rounded-start form-control-sm" type="text"
                                                    name="f_search" id="f_search" placeholder="Search...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="input-group">
                                            <x-form.select name="f_is_active" id="f_is_active" class="form-select-sm">
                                                <option value="">{{ localize('Status') }}</option>
                                                <option value="5">{{ localize('Completed') }}</option>
                                                <option value="1">{{ localize('Incomplete') }}</option>
                                               
                                            </x-form.select>
                                        </div>
                                    </div>
                                    @if (isModuleActive('WordpressBlog') && wpCredential())
                                        @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (!isCustomerUserGroup()))
                                            <div class="col-auto">
                                                <div class="input-group">
                                                    <x-form.select name="f_is_published_wordpress" id="f_is_published_wordpress" class="form-select-sm">
                                                        <option value="">{{ localize('Push Status') }}</option>
                                                        <option value="1">{{ localize('Pushed') }}</option>
                                                        <option value="0">{{ localize('Not Pushed') }}</option>
                                                    
                                                    </x-form.select>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="col-auto">
                                        <x-form.button color="dark" type="button" class="btn-sm" id="searchBtn">
                                            <i data-feather="search" class="icon-14"></i>
                                            {{ localize('Search') }}
                                        </x-form.button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body table-responsive-md">
                            <table class="tt-table-container table table-border border tt-footable" data-use-parent-width="true">
                                <thead>
                                    <tr class="bg-secondary-subtle">
                                        <th data-breakpoints="xs" data-type="number" class="text-center">
                                            {{ localize('S/L') }}</th>
                                        <th>{{ localize('Topic') }}</th>
                                        <th>{{ localize('Title') }}</th>
                                        <th>{{ localize('Generated') }}</th>
                                        <th>{{ localize('Words') }}</th>
                                        <th>{{ localize('Created') }}</th>
                                        <th class="text-center">{{ localize('Status') }}</th>
                                        @if (isModuleActive('WordpressBlog') && wpCredential())
                                            <th class="text-center">{{ localize('Push to WP?') }}</th>
                                            <th class="text-center">{{ localize('Last Sync') }}</th>
                                        @endif
                                        <th data-breakpoints="xs sm md" class="text-center">{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-common.empty-row colspan=@if (isModuleActive('WordpressBlog') && wpCredential())10 @else 8 @endif loading=true />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Page Content  -->

    @include('backend.admin.seo.article.sidebar-article-seo-checker')
    @if (isModuleActive('WordpressBlog'))
        @include('backend.admin.articles.published-to-wordpress-offcanvas')
    @endif

@endsection
@section('js')
    @include('backend.admin.articles.common_js')
    @include('backend.admin.articles.index_js')
@endsection
