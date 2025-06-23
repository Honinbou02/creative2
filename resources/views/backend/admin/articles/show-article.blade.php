@extends('layouts.default')

@section('title')
    {{ localize('SEO Optimization') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("SEO Optimization"))

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => 'Article List']];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    <div class="col-auto">
        <a href="{{ route('admin.articles.create') }}">
            <x-form.button type="button"><i data-feather="plus"></i>{{localize('Generate Blog Article')}}
            </x-form.button>
        </a>
    </div>
@endsection

@section('content')
    <!-- Page Content  -->
    <div class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card content-generator flex-md-row">
                        <div class="content-generator__body order-2 order-md-1">
                            <div class="content-generator__body-header">
                                <div
                                        class="p-3 border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between bg-light-subtle tt-chat-header">


                                    <div class="col-auto flex-grow-1">
                                        <input class="form-control border-0 px-2 form-control-sm" type="text"
                                               id="text-input" placeholder="Name of the document...">
                                    </div>
                                    <div class="tt-chat-action d-flex align-items-center">

                                        <div class="dropdown tt-tb-dropdown me-2">
                                            <button type="button" class="btn p-0" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" title="Send in Email"><i
                                                        data-feather="send" class="icon-16"></i></button>
                                        </div>
                                        <div class="dropdown tt-tb-dropdown me-2">
                                            <button type="button" class="btn p-0"><i data-feather="copy"
                                                                                     class="icon-16"></i></button>
                                        </div>
                                        <div class="dropdown tt-tb-dropdown me-2">
                                            <button class="btn p-0" id="navbarDropdownUser" role="button"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="download" class="icon-16"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end shadow">
                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i data-feather="file" class="me-2"></i> PDF
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i data-feather="code" class="me-2"></i> HTML
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i data-feather="file-text" class="me-2"></i>MS Word
                                                </a>
                                            </div>
                                        </div>

                                        <div class="dropdown tt-tb-dropdown me-2">
                                            <button type="button" class="btn p-0 "><i data-feather="trash"
                                                                                      class="icon-16"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content-generator__body-content">
                                <div id="contentGenerator"></div>
                            </div>
                            <div class="content-generator__sidebar-footer">
                                <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
                                    <button class="btn btn-sm rounded-pill btn-primary">
                                        Save Content
                                    </button>
                                    <button class="btn btn-sm rounded-pill btn-secondary">
                                        Check SEO
                                    </button>

                                    <small class="text-muted"> <i data-feather="info" class="icon-14 me-1"></i> If Collaboration and idea sharing</small>
                                </div>
                            </div>
                        </div>
                        <div class="content-generator__sidebar content-generator__sidebar--end order-1 oreder-md-2">
                            <div class="content-generator__sidebar-header pb-0">
                                <h5>
                                    SEO Checker
                                </h5>
                            </div>
                            <div class="content-generator__sidebar-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div id="seoChart"></div>
                                                <div class="mt-4 w-100">
                                                    <div class="row g-3">
                                                        <div class="col-12 col-md-6">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="mb-0">Title</p>
                                                                <span class="fw-medium">30%</span>
                                                            </div>
                                                            <div class="progress w-100" style="height: 6px;">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="mb-0">Heading</p>
                                                                <span class="fw-medium">30%</span>
                                                            </div>
                                                            <div class="progress w-100" style="height: 6px;">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="mb-0">Terms</p>
                                                                <span class="fw-medium">30%</span>
                                                            </div>
                                                            <div class="progress w-100" style="height: 6px;">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="mb-0">Word</p>
                                                                <span class="fw-medium">30%</span>
                                                            </div>
                                                            <div class="progress w-100" style="height: 6px;">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="tt-custom-scrollbar overflow-y-auto overflow-x-hidden" style="height: 420px;">
                                            <div class="tt-seo-report">
                                                <h5>Reports</h5>
                                                <hr class="mb-3">
                                                <div class="row g-2">
                                                    <div class="col-6 col-md-4">
                                                        <div class="border rounded p-3 d-flex flex-column h-100 text-center justify-content-center">
                                                            <div class="rounded-circle badge bg-soft-primary text-center mx-auto mb-1" style="width: 22px; height: 22px;">4</div>
                                                            <span>Earning</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-4">
                                                        <div class="border rounded p-3 d-flex flex-column h-100 text-center justify-content-center">
                                                            <div class="rounded-circle badge bg-soft-warning text-center mx-auto mb-1" style="width: 22px; height: 22px;">8</div>
                                                            <span>Warnings</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-4">
                                                        <div class="border rounded p-3 d-flex flex-column h-100 text-center justify-content-center">
                                                            <div class="rounded-circle badge bg-soft-success text-center mx-auto mb-1" style="width: 22px; height: 22px;">10</div>
                                                            <span>Optimized</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion mt-3" id="accordionStyle1">
                                                <div class="accordion-item border card shadow-none">
                                                    <h2 class="accordion-header">
                                                        <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                                                data-bs-target="#accordionStyle1-1" aria-expanded="false">
                                                            Title Tags : 90/100
                                                        </button>
                                                    </h2>

                                                    <div id="accordionStyle1-1" class="accordion-collapse collapse show" data-bs-parent="#accordionStyle1">
                                                        <div class="accordion-body">
                                                            <p><span class="text-success fw-medium"><i data-feather="check-circle"
                                                                                                       class="icon-14"></i> Length:</span> Quickly transition team building paradigms after worldwide ideas. Monotonectally engineer 2.0 information through resource-leveling channels. </p>
                                                            <p><span class="text-danger fw-medium"><i data-feather="x-circle"
                                                                                                      class="icon-14"></i> Earning:</span> Phosfluorescently engage synergistic strategic theme areas via web-enabled synergy. Assertively plagiarize progressive architectures vis-a-vis user friendly information. Seamlessly empower effective sources after plug-and-play interfaces.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item border card shadow-none">
                                                    <h2 class="accordion-header">
                                                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                                                data-bs-target="#accordionStyle1-2" aria-expanded="false">
                                                            Meta Description 90/100
                                                        </button>
                                                    </h2>
                                                    <div id="accordionStyle1-2" class="accordion-collapse collapse" data-bs-parent="#accordionStyle1">
                                                        <div class="accordion-body">
                                                            Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake dragée
                                                            ice
                                                            cream
                                                            halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly beans candy canes
                                                            carrot
                                                            cake.
                                                            Fruitcake chocolate chupa chups.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item border card shadow-none">
                                                    <h2 class="accordion-header">
                                                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                                                data-bs-target="#accordionStyle1-3" aria-expanded="true">
                                                            Page headers 80/100
                                                        </button>
                                                    </h2>
                                                    <div id="accordionStyle1-3" class="accordion-collapse collapse" data-bs-parent="#accordionStyle1">
                                                        <div class="accordion-body">
                                                            Oat cake toffee chocolate bar jujubes. Marshmallow brownie lemon drops cheesecake. Bonbon gingerbread
                                                            marshmallow
                                                            sweet jelly beans muffin. Sweet roll bear claw candy canes oat cake dragée caramels. Ice cream wafer
                                                            danish
                                                            cookie caramels muffin.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content  -->
@endsection


@section("js")
    <script src="{{ asset('assets/js/vendors/apexcharts.min.js') }}"></script>

    <script>
        var options1 = {
            chart: {
                height: 280,
                type: "radialBar",
            },
            series: [65],
            colors: ["#451ac7"],
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    track: {
                        background: '#333',
                        startAngle: -135,
                        endAngle: 135,
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            fontSize: "30px",
                            show: true
                        }
                    }
                }
            },
            fill: {
                // type: "gradient",
                // gradient: {
                //     shade: "dark",
                //     type: "horizontal",
                //     gradientToColors: ["#87D4F9"],
                //     stops: [0, 100]
                // }
            },
            stroke: {
                lineCap: "butt"
            },
            labels: ["Progress"]
        };

        new ApexCharts(document.querySelector("#seoChart"), options1).render();
    </script>

@endsection