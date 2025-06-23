@extends('layouts.default')

@section('title')
    {{ localize('All Quick Texts') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("Quick Texts")) 

@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => null, 'title' => localize('All Quick Texts')]]; @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection


@section("pageTitleButtons")
    <div class="col-auto new-account-btn">
        <x-form.button type="button" data-bs-toggle="offcanvas" data-bs-target="#addQuickTextFromSidebar" class="addQuickTextBtn">
            <i data-feather="plus"></i>{{ localize('New Quick Text') }}
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
                                            <th>{{ localize('Title') }}</th>
                                            <th >{{ localize('Description') }}</th>
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
    @include('socialpilot::quick-texts.sidebar-add-quick-texts')

@endsection

@section("js")
    @include('socialpilot::quick-texts.js')
@endsection
