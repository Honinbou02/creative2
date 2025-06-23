@extends('layouts.default')

@section('title')
    {{ localize('All Documents') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("Documents")) 

@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => null, 'title' => localize('All Documents')]]; @endphp
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

                        <div class="border-bottom position-relative mt-3">
                            <span class="nav-line-tab-left-arrow text-center cursor-pointer ms-2">
                                <i data-feather="chevron-left" class="icon-16"></i>
                            </span>
                            <ul class="nav nav-line-tab fw-medium px-3" id="list">
                                <li class="nav-item">
                                    <a href="#content" class="nav-link {{@$type == 'content' ? 'active' : ''}} renderData" data-type="content"  data-bs-toggle="tab" aria-selected="true">
                                        <span data-feather="file-text" class="icon-16"></span> {{ localize('Content') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#image" class="nav-link {{@$type == 'image' ? 'active' : ''}} renderData"  data-type="image"  data-bs-toggle="tab" aria-selected="false">
                                        <span data-feather="image" class="icon-16"></span>  {{ localize('Image') }}
                                    </a>
                                </li>
                            </ul>
                            <span class="nav-line-tab-right-arrow text-center cursor-pointer me-2">
                                <i data-feather="chevron-right" class="icon-16"></i>
                            </span>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive-md">
                                <table class="table table-border border">
                                    <thead>
                                        <tr class="bg-secondary-subtle">
                                            <th>{{ localize('S/L') }}</th>
                                            <th>{{ localize('Title') }}</th>
                                            <th>{{ localize('Model') }}</th>
                                            <th>{{ localize('Generated') }}</th>
                                            <th class="text-center">{{ localize('Type') }}</th>
                                            <th class="text-center">{{ localize('Words') }}</th>
                                            <th class="text-center">{{ localize('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <x-common.empty-row colspan=7 loading=true />
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
@endsection
@section("js")
    @include('backend.admin.projects.js')
@endsection
