@extends("layouts.default")
@php
    $pageTitle = localize("Brand Voice");
@endphp
@section("pagetitle", localize("Brand Voice"))
@section('title')
    {{ $pageTitle}} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection

@section("breadcrumb")
    @php
        $breadcrumbItems = [
            ["href" => null, "title" => localize("Brand Voice")]
        ];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection


@section("pageTitleButtons")
    <div class="col-auto">
        <x-form.button type="button"
                       id="addBrandVoiceFromSidebarOffCanvas"
                       data-bs-toggle="offcanvas"
                       data-bs-target="#addBrandVoiceFromSidebar">
            <i data-feather="plus"></i>{{ localize('New Brand Voice') }}
        </x-form.button>
    </div>
@endsection


@section("content")
    <!-- Page Content  -->
    <div class="tt-page-content mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ localize('Brand Voice') }}</h5>
                        </div>

                        <div class="card-body table-responsive-md">
                            <table class="table border table-sm">
                                <thead>
                                <tr class="fw-medium">
                                    <td>{{ localize("SL") }}</td>
                                    <td>{{ localize("Brand") }}</td>
                                    <td>{{ localize("Brand Website") }}</td>
                                    <td>{{ localize("Industry") }}</td>
                                    <td>{{ localize("Brand Description") }}</td>
                                    <td>{{ localize("Brand Products") }}</td>
                                    <td>{{ localize("Action") }}</td>
                                </tr>
                                </thead>
                                <tbody class="brandVoiceTbody">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<!-- Add Brand Voice start-->
@include('backend.admin.brand-voice.sidebar-add-brand-voice')
<!-- Add Brand Voice -->
@endsection

@section("styles")

@endsection


@section("js")
    @include("backend.admin.brand-voice.js")
@endsection