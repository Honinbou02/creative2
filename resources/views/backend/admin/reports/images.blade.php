@extends('layouts.default')

@section('title')
    {{ localize('Images Report') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section("pagetitle", localize('Images Report'))
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('Images Report')]];
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
                                        <div class="input-group">
                                            <select class="form-select select2" id="platform" name="platform">
                                                <option value="">{{ localize('Select Engine') }}</option>                                                                                   
                                                    <option value="{{appStatic()::ENGINE_STABLE_DIFFUSION}}" {{isset($platform) ? ($platform ==  appStatic()::ENGINE_STABLE_DIFFUSION ? 'selected':''):''}}> Stable Diffusion
                                                       </option>
                                                    <option value="{{appStatic()::ENGINE_OPEN_AI}}" {{isset($platform) ? ($platform ==   appStatic()::ENGINE_OPEN_AI ? 'selected':''):''}}> Open AI
                                                       </option>                                               

                                            </select>
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
                                            {{ localize('Total Images Generated') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body table-responsive-md">
                            <table class="table tt-footable border-top border align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ localize('S/L') }} </th>
                                        <th>{{ localize('Title') }}</th>
                                        <th >{{ localize('Size') }}</th>
                                        <th>{{ localize('Type') }}</th>
                                        <th>{{ localize('User') }}</th>
                                        <th data-breakpoints="xs" class="text-end">{{ localize('Generated On') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <x-common.empty-row colspan=6 loading=true/>
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
@include('backend.admin.reports.js.images-js')
@endsection