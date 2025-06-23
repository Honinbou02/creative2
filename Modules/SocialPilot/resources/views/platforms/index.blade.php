@extends('layouts.default')

@section('title')
    {{ localize('All Platforms') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("Platforms")) 

@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => null, 'title' => localize('All Platforms')]]; @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('content')
    <!-- Page Content  -->

    <section class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 bg-transparent pb-0">
                            <div class="row g-3">
                                <div class="col-auto flex-grow-1">
                                    <div class="tt-search-box w-auto">
                                        <div class="input-group">
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                    data-feather="search" class="icon-16"></i></span>
                                            <input class="form-control rounded-start form-control-sm" id="f_search"
                                                type="text" placeholder="{{localize('Search...')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-dark btn-sm" id="searchBtn">
                                        <i data-feather="search" class="icon-14"></i>
                                        {{localize('Search')}}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-md">
                                <table class="table table-border border">
                                    <thead>
                                        <tr class="bg-secondary-subtle">
                                            <th>{{ localize('S/L') }}</th>
                                            <th>{{ localize('Name') }}</th>
                                            <th>{{ localize('Status') }}</th>
                                            <th class="text-center">{{ localize('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <x-common.empty-row colspan=4 loading=true />
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Page Content  -->
    
    <!-- platform required modals-->
    @include('socialpilot::platforms.sidebar-add-platform')
    @include('socialpilot::platforms.sidebar-configure-platform')

@endsection

@section("js")
    @include('common.media-manager.uppyScripts')
    @include('socialpilot::platforms.js')
@endsection
