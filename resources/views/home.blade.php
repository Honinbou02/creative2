@extends('layouts.default')
@section('title')
    {{ localize('Dashboard') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
    @endsection

@section('content')
    <section class="tt-section">
        <div class="container">
            <div class="row mb-2 g-2">

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <div class="me-3">
                                    <div class="avatar avatar-lg tt-avater-info">
                                        <img class="rounded rounded-circle" width="50" src="{{ avatarImage(user()->avatar) }}" alt="avatar" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h2 class="h5 mb-1">{{ user()->name }}</h2>
                                    <ul class="d-flex flex-wrap list-unstyled mb-0">
                                        <li class="me-3"><i data-feather="briefcase"
                                                class="me-1 text-muted icon-14"></i>{{ appStatic()::USER_TYPES[user()->user_type] }}
                                        </li>
                                        @if (user()->mobile_no)
                                            <li class="me-3"><i data-feather="phone-call"
                                            class="me-1 text-muted icon-14"></i>{{ user()->mobile_no }}</li>
                                        @endif
                                        
                                        <li class="me-3"><i data-feather="mail"
                                                class="me-1 text-muted icon-14"></i>{{ user()->email }}</li>
                                    </ul>

                                    {{-- When logged in user is a Customer --}}
                                    @include("common.dashboard.customer.balance.word-remaining")
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="row g-2">

                        {{-- When Admin or Admin staff logged in --}}
                        @include("common.dashboard.admin.total-customers")

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2 flex-shrink-0">
                                            <div class="text-center rounded-circle shadow-sm bg-light">
                                                <span><i data-feather="file-text" class="icon-16"></i></span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $total_words }}</h6>
                                            <span class="fs-sm">{{ localize('Total Words Generated') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2 flex-shrink-0">
                                            <div class="text-center rounded-circle shadow-sm bg-light">
                                                <span><i data-feather="image" class="icon-16"></i></span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $total_images }}</h6>
                                            <span class="fs-sm">{{ localize('Total Image Generated') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2 flex-shrink-0">
                                            <div class="text-center rounded-circle shadow-sm bg-light">
                                                <span><i data-feather="image" class="icon-16"></i></span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $total_ai_chat_images }}</h6>
                                            <span class="fs-sm">{{ localize('Total Chat Image Generated') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2 flex-shrink-0">
                                            <div class="text-center rounded-circle shadow-sm bg-light">
                                                <span><i data-feather="code" class="icon-16"></i></span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $total_codes }}</h6>
                                            <span class="fs-sm">{{ localize('Total Code Generated') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-3 col-12 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2 flex-shrink-0">
                                            <div class="text-center rounded-circle shadow-sm bg-light">
                                                <span><i data-feather="mic" class="icon-16"></i></span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $total_speech_to_texts }}</h6>
                                            <span class="fs-sm">{{ localize('Total Speech To Text') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-12 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2 flex-shrink-0">
                                            <div class="text-center rounded-circle shadow-sm bg-light">
                                                <span><i data-feather="volume-2" class="icon-16"></i></span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $total_text_to_speeches }}</h6>
                                            <span class="fs-sm">{{ localize('Total Text To Speech') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-xl-8">
                    <div class="card flex-column h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted">{{ localize('Words Generated This Months') }}</span>
                                <div class="dropdown tt-tb-dropdown fs-sm">
                                    <a class="dropdown-toggle text-muted" href="#"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        @if (isset($timelineText))
                                            {{ $timelineText }}
                                        @else
                                            {{ localize('Last 7 days') }}
                                        @endif
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                        <a class="dropdown-item active" href="{{ route('dashboard') }}">{{ localize('Last 7 days') }}</a>
                                        <a class="dropdown-item "
                                            href="{{ route('dashboard') }}?&timeline=30">{{ localize('Last 30 days') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('dashboard') }}?&timeline=90">{{ localize('Last 3 months') }}</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="fw-bold">{{ formatWords($totalWordsData->totalWords) }} {{ localize('Words') }}</h4>
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card h-100 flex-column">
                        <div class="card-body d-flex flex-column h-100">
                            <span class="text-muted">{{ localize('Total Created Words Top 5 Templates') }}</span>
                            <h4 class="fw-bold">  {{ getSetting('truncate_price') == 1 ? formatWords($totalTemplateWordsData->totalTemplateWordsCount) : $totalTemplateWordsData->totalTemplateWordsCount }} {{ localize('Words') }}</h4>
                            <div id="donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom-0">
                            <div class="row justify-content-between align-items-center g-3">
                                <div class="col-auto flex-grow-1">
                                    <h5 class="mb-lg-0">{{ localize('Recent Project and Images Generated') }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="card-header border-0 bg-transparent pb-0">
                            <div class="row g-3">
                                <div class="col-auto flex-grow-1">
                                    <div class="tt-search-box w-auto">
                                        <div class="input-group">
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                    data-feather="search" class="icon-16"></i></span>
                                            <input class="form-control rounded-start form-control-sm" id="f_search"
                                                type="text" placeholder="{{ localize('Search') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-dark btn-sm" id="searchBtn">
                                        <i data-feather="search" class="icon-14"></i>
                                        {{ localize('Search') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="border-bottom position-relative mt-3">
                            <span class="nav-line-tab-left-arrow text-center cursor-pointer ms-2">
                                <i data-feather="chevron-left" class="icon-16"></i>
                            </span>
                            <ul class="nav nav-line-tab fw-medium px-3" id="list">
                                <li class="nav-item">
                                    <a href="#content"
                                        class="nav-link active renderData"
                                        data-type="content" data-bs-toggle="tab" aria-selected="true">
                                        <span data-feather="file-text" class="icon-16"></span> {{ localize('Content') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#image" class="nav-link  renderData"
                                        data-type="image" data-bs-toggle="tab" aria-selected="false">
                                        <span data-feather="image" class="icon-16"></span> {{ localize('Image') }}
                                    </a>
                                </li>
                            </ul>
                            <span class="nav-line-tab-right-arrow text-center cursor-pointer me-2">
                                <i data-feather="chevron-right" class="icon-16"></i>
                            </span>
                        </div>
                        <div class="table-responsive-md p-3">
                            <table class="table border rounded">
                                <thead>
                                    <tr class="bg-secondary-subtle">
                                        <th>{{ localize('S/L') }}</th>
                                        <th>{{ localize('Title') }}</th>
                                        <th>{{ localize('Model Name') }}</th>
                                        <th>{{ localize('Created Date') }}</th>
                                        <th class="text-center">{{ localize('Type') }}</th>
                                        <th class="text-center">{{ localize('Words/Size') }}</th>
                                        <th class="text-center">{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-common.empty-row colspan=7 loading=true />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('js')
    @include('backend.admin.projects.js')
    <script src="{{ asset('assets/js/vendors/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/apex-scripts.js') }}"></script>
    <script>
        "use strict";
        // total earning chart
        var totalSales = {
            chart: {
                type: "area",
                height: 80,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "smooth",
                width: 2,
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: '{{ localize('Words') }}',
                data: [{!! $totalWordsData->words !!}],
            }, ],
            labels: [{!! $totalWordsData->labels !!}],
            xaxis: {
                type: "datetime",
            },
            yaxis: {
                min: 0,
            },
            colors: ["#9333ea"],
        };
        new ApexCharts(document.querySelector("#chart"), totalSales).render();

            //pie chart top five
            var optionsTopFive = {
                chart: {
                    type: "donut",
                    height: 100,
                    offsetY: 15,
                    offsetX: -20,
                },
                series: {!! $totalTemplateWordsData->series !!},
                labels: [{!! $totalTemplateWordsData->labels !!}],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200,
                        },
                        legend: {
                            position: "bottom",
                            show: false,
                        },
                        dataLabels: {
                            enabled: false,
                        },
                    },
                }, ],
            };

            var chartTopFive = new ApexCharts(
                document.querySelector("#donut"),
                optionsTopFive
            );
            chartTopFive?.render();
    </script>
@endsection
