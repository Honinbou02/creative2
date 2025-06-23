@extends('layouts.default')

@section('title')
    {{ localize('Chat Experts') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize('Chat Experts'))

@section('breadcrumb')
    @php
        $breadcrumbItems = [
            ["href"  => null, "title" => localize('Chat Experts')]
        ];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems"/>
@endsection

@section('pageTitleButtons')
    @if (!isCustomerUserGroup())
        <div class="col-auto">
            <x-form.button type="button" id="addExpertFormSidebarForOffCanvas" data-bs-toggle="offcanvas" data-bs-target="#addExpertFormSidebar"><i data-feather="plus"></i>Add Chat Expert
            </x-form.button>
        </div>
    @endif
@endsection

@section('content')
    <section class="tt-section pb-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 bg-transparent pb-0">
                            <div class="row g-3">
                                <div class="col-auto flex-grow-1">
                                    <div class="tt-search-box w-auto">
                                        <x-form.input name="f_search" id="f_search" placeholder="{{ localize('Search') }}" class="rounded-start form-control-sm" hasIcon=true>
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"><i data-feather="search" class="icon-16"></i></span>
                                        </x-form.input>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <x-form.select name="f_is_active" id="f_is_active" class="form-select-sm">
                                        <option value="">Status</option>
                                        @foreach (appStatic()::STATUS_ARR as $statusKey => $status)
                                            <option value="{{ $statusKey }}">{{ $status }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                                <div class="col-auto">
                                    <x-form.button color="dark" type="button" class="btn-sm" id="searchBtn">
                                        <i data-feather="search" class="icon-14"></i>
                                        {{ localize('Search') }}
                                    </x-form.button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 data-list">
                                <x-common.empty-div loading=true />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('backend.admin.chat-experts.sidebar-add-chat-expert')

@endsection
@push('scripts')
    @include('common.media-manager.uppyScripts')
@endpush
@section('js')
    @include('backend.admin.chat-experts.js')
@endsection
