@extends('layouts.default')

@section('title')
    {{ localize('Users') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize('WordPress Authors'))

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => 'WordPress Authors']]; @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    @if (isModuleActive('WordpressBlog') && wpCredential())
        @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (!isCustomerUserGroup()))
            <div   div class="col-auto">
                @if(isset($lastSyncTime) && $lastSyncTime)
                    <span class="text-muted">{{localize('Last Synced')}}: {{manageDateTime($lastSyncTime, 7)}}</span>
                @endif

                <a href="#" class="btn btn-primary btn-sm ms-2" id="syncAllUsersBtn"> 
                    <i data-feather='repeat'></i> <span>{{ localize('Sync Authors from WordPress') }}</span>
                </a>
            </div>
        @endif
    @endif
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
                                        <x-form.button color="dark" type="button" class="btn-sm" id="searchBtn">
                                            <i data-feather="search" class="icon-14"></i>
                                            {{ localize('Search') }}
                                        </x-form.button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body table-responsive-md">
                            <table class="table border rounded">
                                <thead>
                                <tr class="bg-secondary-subtle">
                                    <th>{{ localize('S/L') }}</th>
                                    <th>{{ localize('Name') }}</th>
                                    <th>{{ localize('Email') }}</th>
                                    <th>{{ localize('Username') }}</th>
                                </tr>
                                </thead>
                                <tbody id="authors-list">
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
@endsection
@section('js')
    @include('wordpressblog::authors.js')
@endsection
