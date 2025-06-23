@extends('layouts.default')

@section('title')
    {{ localize('Templates') }}
@endsection

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('Templates')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    @if(isCustomerUserGroup())
        @php
        $totalWordBalance     = userActivePlan()["word_balance_t2s"] ?? 0;
        $totalWordUsed        = userActivePlan()["word_balance_used_t2s"] ?? 0;
        $totalRemainingBalance = userActivePlan()["word_balance_remaining_t2s"] ?? 0;
        @endphp
        <div class="col-auto" id="balance-render">

        <x-common.balance-component :total="$totalWordBalance"
                                :used="$totalWordUsed"
                                :remaining="$totalRemainingBalance"
        />
        </div>
    @endif
    <div class="col-auto">

        <a href="{{ route('admin.ai-writer.create') }}" class="btn btn-primary btn-sm">{{ localize('Generate Content') }}</a>
    </div>
@endsection
@section('pageTitleButtons')

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
                                        <x-form.input name="f_search" id="f_search"
                                            placeholder="{{ localize('Search') }}" class="rounded-start form-control-sm"
                                            hasIcon=true>
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"><i
                                                    data-feather="search" class="icon-16"></i></span>
                                        </x-form.input>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <x-form.select name="f_is_active" id="f_is_active" class="form-select-sm">
                                        <option value="">{{ localize('Status') }}</option>
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

                        <div class="card-body table-responsive-md">
                            <table class="table border">
                                <thead>
                                    <tr class="bg-secondary-subtle">
                                        <th>{{ localize('S/L') }}</th>
                                        <th>{{ localize('Title') }}</th>
                                        <th>{{ localize('Content') }}</th>
                                        <th>{{ localize('Created By') }}</th>
                                        <th>{{ localize('Created At') }}</th>
                                        <th>{{ localize('Updated At') }}</th>
                                        <th>{{ localize('Action') }}</th>
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
    </section>
@endsection
@section('js')
    @include('backend.admin.ai-writer.js')
@endsection
