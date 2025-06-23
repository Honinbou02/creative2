@extends('layouts.default')

@section('title')
    {{ localize('Blog Category') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize('Blog Category'))
@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => null, 'title' => 'Category']]; @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    @if (isModuleActive('WordpressBlog') && wpCredential())
        @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (!isCustomerUserGroup()))
            <div class="col-auto">
                @if($lastSyncUp)
                    <span>{{localize('Last Syncup')}} : {{$lastSyncUp}}</span>
                @endif
                <a href="" class="btn btn-secondary btn-sm ms-2" id="syncAllCategory"> <i data-feather="refresh-cw"
                        class="me-1"></i> <span id="syncText">{{ localize('Sync') }}</span></a>

            </div>
        @endif
    @endif
    <div class="col-auto">
        <x-form.button type="button" id="addBlogCategoryFrmOffCanvas" data-bs-toggle="offcanvas"
            data-bs-target="#addBlogCategoryFormSidebar">
            <i data-feather="plus"></i>{{ localize('Add Category') }}
        </x-form.button>
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
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                    <i data-feather="search" class="icon-16"></i></span>
                                                <input class="form-control rounded-start form-control-sm" type="text"
                                                    name="f_search" id="f_search" placeholder="Search..." />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="input-group">
                                            <x-form.select name="f_is_active" id="f_is_active" class="form-select-sm">
                                                <option value="">{{ localize('Status') }}</option>
                                                @foreach (appStatic()::STATUS_ARR as $statusKey => $status)
                                                    <option value="{{ $statusKey }}">{{ $status }}</option>
                                                @endforeach
                                            </x-form.select>
                                        </div>
                                    </div>
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
                            <table class="table table-border border">
                                <thead>
                                    <tr class="bg-secondary-subtle">
                                        <th>{{ localize('S/L') }}</th>
                                        <th>{{ localize('Name') }}</th>
                                        <th class="">{{ localize('Status') }}</th>
                                        <th class="">{{ localize('Is WP Sync ?') }}</th>
                                        <th class="text-center">{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-common.empty-row colspan=5 loading=true />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Page Content  -->

    <!-- Add tag Category start-->
    @include('backend.admin.blog-categories.add-blog-category')
    <!-- Add tag Category -->
@endsection
@section('js')
    @include('backend.admin.blog-categories.js')
@endsection
