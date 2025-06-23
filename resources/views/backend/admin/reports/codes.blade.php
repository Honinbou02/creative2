@extends('layouts.default')

@section('title')
    {{ localize('Codes Report') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize('Codes Report'))
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('Codes Report')]];
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

                                    <div class="col-4">
                                        <div class="input-group">
                                            @php
                                                $start_date = date('m/d/Y', strtotime('7 days ago'));
                                                $end_date = date('m/d/Y', strtotime('today'));
                                                if (isset($date_var)) {
                                                    $start_date = date('m/d/Y', strtotime($date_var[0]));
                                                    $end_date = date('m/d/Y', strtotime($date_var[1]));
                                                }
                                            @endphp

                                            <input class="form-control form-control-sm date-range-picker date-range" type="text"
                                                placeholder="{{ localize('Start date - End date') }}" name="date_range"
                                                data-startdate="'{{ $start_date }}'"
                                                data-enddate="'{{ $end_date }}'">
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="input-group">                                            
                                            <x-form.select name="user_id" id="user_id" class="form-select-sm select2">
                                                <option value="">{{ localize('Select User') }}</option>
                                                @foreach ($users as $user)                                                
                                                    <option value="{{$user->id}}" {{isset($user_id) ? ($user_id ==  $user->id ? 'selected':''):''}}> {{$user->name}}
                                                    </option>
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
                                    <div class="col-auto flex-grow-1"></div>
                                    <div class="col-auto text-end">
                                        <strong class="d-block">
                                            {{ formatWords($totalWordsGenerated) }}
                                        </strong>
                                        <span class="fs-sm">
                                            {{ localize('Total Codes Generated') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body table-responsive-md">
                            <table class="table tt-footable border-top border align-middle" data-use-parent-width="true">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ localize('S/L') }}
                                        </th>
                                        <th>{{ localize('Title') }}</th>
                                        <th>{{ localize('User') }}</th>
                                        <th>{{ localize('Generated On') }}</th>
                                        <th data-breakpoints="xs" class="text-end">{{ localize('Words') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-common.empty-row colspan=5 loading=true />
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
@include('backend.admin.reports.js.codes-js')
@endsection