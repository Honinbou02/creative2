@extends('layouts.default')

@section('title')
    {{ localize('All Posts') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("Posts")) 

@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => null, 'title' => localize('All Posts')]]; @endphp
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
                                    <div class="input-group">
                                        <x-form.select name="f_post_status" id="f_post_status" class="form-select-sm text-capitalize">
                                            <option value="">{{localize('Status')}}</option>
                                            @foreach (appStatic()::POST_STATUS_BY_VALUE as $statusKey => $status)
                                                <option value="{{ $statusKey }}">{{ strtolower($status) }}</option>
                                            @endforeach
                                        </x-form.select>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <button type="button" class="btn btn-dark btn-sm" id="searchBtn">
                                        <i data-feather="search" class="icon-14"></i>
                                        {{localize('Filter')}}
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
                                            <th>{{ localize('Platform') }}</th>
                                            <th >{{ localize('Account') }}</th>
                                            <th >{{ localize('Created At') }}</th>
                                            <th >{{ localize('Schedule Time') }}</th>
                                            <th >{{ localize('Status') }}</th>
                                            <th >{{ localize('Post Type') }}</th>
                                            <th class="text-center">{{ localize('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <x-common.empty-row colspan=8 loading=true />
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
    @include('socialpilot::posts.js')
@endsection
