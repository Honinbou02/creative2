@extends('layouts.default')

@section('title')
    {{ localize('All Accounts') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("Accounts")) 

@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => null, 'title' => localize('All Accounts')]]; @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section("pageTitleButtons")
    <div class="col-auto new-account-btn {{$type ? '' : 'd-none'}}">
        <x-form.button type="button" data-bs-toggle="offcanvas" data-bs-target="#addAccountFromSidebar" class="">
            <i data-feather="plus"></i>{{ localize('New Account') }}
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

                        <div class="border-bottom position-relative mt-3">
                            <span class="nav-line-tab-left-arrow text-center cursor-pointer ms-2">
                                <i data-feather="chevron-left" class="icon-16"></i>
                            </span>
                            <ul class="nav nav-line-tab fw-medium px-3" id="list">
                                @foreach ($platforms as $platform) 
                                    @if (hasPlatformAccess($platform))
                                        <li class="nav-item">
                                            <a href="#{{ $platform->slug }}" class="d-flex align-items-center nav-link {{@$type == $platform->slug ? 'active' : ''}} renderData" data-type="{{ $platform->slug }}"  data-bs-toggle="tab" aria-selected="true">
                                                <span>
                                                    <img src="{{ mediaImage($platform->icon_media_manager_id) }}" alt="{{ $platform->name }}" class="rounded rounded-circle" width="30" >
                                                </span>
                                                <span class="ms-1">{{ $platform->name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach 
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
                                            <th>{{ localize('Name') }}</th>
                                            <th>{{ localize('Account Type') }}</th>
                                            <th>{{ localize('Platform') }}</th>
                                            <th class="text-center">{{ localize('Is Connected?') }}</th>
                                            <th class="text-center">{{ localize('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <x-common.empty-row colspan=6 loading=true />
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
    
<!-- Add Brand Voice start-->
@include('socialpilot::accounts.sidebar-add-account')
<!-- Add Brand Voice -->

@endsection
@section("js")
    @include('socialpilot::accounts.js')
@endsection
