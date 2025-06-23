@extends('layouts.default')

@section('title')
    {{ localize('Text To Speech') }}{{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("Text To Speech")) 

@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => null, 'title' => localize('Text To Speech')]]; @endphp
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
@endsection

@section('content')
    <!-- Page Content  -->
    <section class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card content-generator flex-md-row">
                        <div class="content-generator__body order-2 order-md-1">
                            <div class="content-generator__body-header p-3">
                                <form action="" method="get" name="searchForm" id="searchForm">

                                    <div class="row g-3">
                                        <div class="col-auto flex-grow-1">
                                            <div class="tt-search-box w-auto">
                                                <div class="input-group">
                                                    <span class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                        <i data-feather="search" class="icon-16"></i></span>
                                                    <input class="form-control rounded-start form-control-sm" type="text"
                                                        name="f_search" id="f_search" placeholder="Search..." />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">

                                                <x-form.select class="form-select form-select-sm" name="f_engine"
                                                    id="f_engine">
                                                    <option value="">{{localize('All')}}</option>
                                                    <option value="{{ appStatic()::ENGINE_OPEN_AI }}">OpenAi</option>
                                                    <option value="{{ appStatic()::ENGINE_ELEVEN_LAB }}">ElevenLabs</option>
                                                    <option value="{{ appStatic()::ENGINE_AZURE }}">Azure</option>
                                                    <option value="{{ appStatic()::ENGINE_GOOGLE_TTS }}">Google</option>
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
                            <div class="content-generator__body-content p-3 pt-0">
                                <div class="table-responsive-md">
                                    <table class="table border table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">{{ localize('S/L') }}</th>
                                                <th>{{ localize('Title') }}</th>
                                                <th>{{ localize('Date') }}</th>
                                                <th>{{ localize('Type') }}</th>
                                                <th class="text-center">{{ localize('audio') }}</th>
                                                <th class="text-center">{{ localize('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <x-common.empty-row colspan=6 loading=true tdClass="py-9" />
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        @include('backend.admin.textToSpeeches.add-text-to-speech')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Page Content  -->
@endsection

@section('js')
    @include('backend.admin.textToSpeeches.js')
@endsection
