@extends('layouts.default')

@section('title')
    {{ localize('Words Report') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize('Words Report'))
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('WordS Report')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection
@section('content')
    <section class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="" method="get" name="searchForm" id="searchForm">
                            <div class="card-header border-bottom-0">
                                <div class="row justify-content-between g-3">

                                    <div class="col-auto">
                                        <div class="input-group">
                                            @php
                                                $start_date = date('m/d/Y', strtotime('7 days ago'));
                                                $end_date = date('m/d/Y', strtotime('today'));
                                                if (isset($date_var)) {
                                                    $start_date = date('m/d/Y', strtotime($date_var[0]));
                                                    $end_date = date('m/d/Y', strtotime($date_var[1]));
                                                }
                                            @endphp

                                            <input class="form-control form-control-sm date-range-picker date-range" id="date_range" type="text"
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
                                        <div class="input-group">
                                            <x-form.select name="template_id" id="template_id" class="form-select-sm select2">
                                                <option value="">{{ localize('Select Template') }}</option>
                                                @foreach ($templates as $template)                                                
                                                <option value="{{$template->id}}" {{isset($template_id) ? ($template_id ==  $template->id ? 'selected':''):''}}> {{$template->template_name}}
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
                                        <strong class="d-block">{{ formatWords($totalWordsGenerated) }}</strong>
                                        <span class="fs-sm">
                                            {{ localize('Total Words') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-body table-responsive-md">
                            <table class="table border rounded">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ localize('S/L') }} </th>
                                        <th>{{ localize('Generated On') }}</th>
                                        <th data-breakpoints="xs">{{ localize('Type') }}</th>
                                        <th data-breakpoints="xs">{{ localize('User') }}</th>
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
    @include('backend.admin.reports.js.words-js')
@endsection
