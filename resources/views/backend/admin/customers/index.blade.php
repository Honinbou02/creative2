@extends('layouts.default')

@section('title')
    {{ localize('Customer List') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize('Customers'))

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => 'Customers']];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    <div class="col-auto">
        <a href="{{ route('admin.customers.export') }}" class="btn btn-secondary"><i
            data-feather="arrow-down"></i> {{ localize('Export Customers') }}</a>
    </div>
    <div class="col-auto">
        <x-form.button type="button" id="addCustomerBtnForOffCanvas" data-bs-toggle="offcanvas"
            data-bs-target="#addCustomerSideBar"><i data-feather="plus"></i>{{ localize('Add Customer') }}</x-form.button>
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
                                            <x-form.select name="f_plan" id="f_plan" class="form-select-sm">
                                                <option value="">{{ localize('Plan Type') }}</option>
                                                @foreach ($plans as $plan)
                                                    <option value="{{ $plan->id }}" data-price="{{ $plan->price }}">{{ $plan->title }} [{{localize('Price')}} ({{$plan->price}}) ] [<span class="text-capitalize">{{$plan->package_type}}</span>]</option>
                                                @endforeach
                                            </x-form.select>
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
                            <table class="table tt-footable border rounded" data-use-parent-width="true">
                                <thead>
                                    <tr class="bg-secondary-subtle">
                                        <th data-breakpoints="xs" data-type="number" class="text-center">{{localize('S/L')}}</th>
                                        <th>{{ localize('Profile') }}</th>
                                        <th>{{ localize('Name') }}</th>
                                        <th>{{ localize('Email') }}</th>
                                        <th>{{ localize('Phone') }}</th>
                                        <th>{{ localize('Acitve Package') }}</th>
                                        <th>{{ localize('Created At') }}</th>
                                        <th class="text-center">{{ localize('Status') }}</th>
                                        <th data-breakpoints="xs sm md" class="text-center">{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-common.empty-row colspan=9 loading=true />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Page Content  -->

    <!-- Add Customer start-->
    @include('backend.admin.customers.add-customer')
    @include('backend.admin.customers.assign-package-sidebar')
    <!-- Add Customer -->
@endsection
@push('scripts')
    @include('common.media-manager.uppyScripts')
@endpush
@section('js')
    @include('backend.admin.customers.js')
@endsection
