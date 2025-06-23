@extends('layouts.default')

@section('title')
    {{ localize('Most Used Templates') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section("pagetitle", localize('Most Used Templates'))
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('Most Used Templates')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection


@section('content')
    <section class="tt-section">
        <div class="container">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card mb-4" id="section-1">
                        <form action="" method="get" name="searchForm" id="searchForm">
                            <div class="card-header border-bottom-0">
                                <div class="row justify-content-between g-3">
                                    <div class="col-auto flex-grow-1">
                                        <div class="tt-search-box">
                                            <div class="input-group">
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                        data-feather="search"></i></span>
                                                <input class="form-control form-control-sm rounded-start w-100" type="text"
                                                    id="search" name="search" placeholder="{{ localize('Search') }}"
                                                    @isset($searchKey)
                                                value="{{ $searchKey }}"
                                                @endisset>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="input-group">
                                            <select class="form-select form-select-sm select2" id="order" name="order"
                                                data-minimum-results-for-search="Infinity">
                                                <option value="DESC"
                                                    @isset($order)
                                                         @if ($order == 'DESC') selected @endif
                                                        @endisset>
                                                    {{ localize('High ⟶ Low') }}</option>

                                                <option value="ASC"
                                                    @isset($order)
                                                         @if ($order == 'ASC') selected @endif
                                                        @endisset>
                                                    {{ localize('Low ⟶ High') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                                <x-form.button color="dark" type="button" class="btn-sm" id="searchBtn">
                                                    <i data-feather="search" class="icon-14"></i>
                                                    {{ localize('Search') }}
                                                </x-form.button>
                                            </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body table-responsive-md">
                            <table class="table tt-footable border border-top" data-use-parent-width="true">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ localize('S/L') }}
                                        </th>
                                        <th>{{ localize('Template Name') }}</th>
                                        <th class="text-end">{{ localize('Total Words') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-common.empty-row colspan=3 loading=true/>
                                </tbody>
                            </table>
                        </div>
                        <!--pagination start-->
                     
                        <!--pagination end-->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
@include('backend.admin.reports.js.most-used-js')
@endsection