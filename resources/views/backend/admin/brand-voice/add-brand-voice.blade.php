@extends("layouts.default")
@php
    $pageTitle = localize("Brand Voice");
@endphp
@section("pagetitle", localize("Create Brand Voice"))
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
        <a href="{{ route('admin.brand-voices.index') }}" class="btn btn-primary">
            <i data-feather="rss"></i> {{ localize("All Brand Voices") }}
        </a>
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

                        <div class="card-body">
                            <form action="{{ route('admin.brand-voices.store') }}" method="POST" id="addBrandVoiceForm" enctype="multipart/form-data">
                                @csrf
                                @include("backend.admin.brand-voice.form-brand-voice")
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section("styles")

@endsection


@section("js")
    @include("backend.admin.brand-voice.js")
@endsection

