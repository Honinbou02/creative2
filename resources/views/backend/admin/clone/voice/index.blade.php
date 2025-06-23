@extends("layouts.default")
@php
    $pageTitle = localize("AI Voice Clone");
@endphp
@section("pagetitle", localize("AI Voice Clone"))
@section('title')
    {{ $pageTitle}} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection

@section("breadcrumb")
    @php
        $breadcrumbItems = [
            ["href" => null, "title" => localize("AI Voice Clone")]
        ];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection


@section("pageTitleButtons")
    <div class="col-auto">
        <x-form.button type="button" id="addBrandVoiceFromSidebarOffCanvas" data-bs-toggle="offcanvas"
            data-bs-target="#addVoiceCloneSidebar">
            <i data-feather="plus"></i>{{ localize('New Voice Clone') }}
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
                            <h5 class="mb-0">{{ localize('All Cloned Voice') }}</h5>
                        </div>

                        <div class="card-body table-responsive-md">
                            <table class="table table-border border">
                                <thead>
                                    <tr>
                                        <th>{{ localize("SL") }}</th>
                                        <th>{{ localize('Voice Name') }}</th>
                                        <th>{{ localize('Voice ID') }}</th>
                                        <th>{{ localize('Created At') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($voices as $key=>$voice)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $voice->name }}</td>
                                            <td>{{ $voice->voice_id }}</td>
                                            <td>{{ $voice->created_at }}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<!-- Add Brand Voice start-->
@include('backend.admin.clone.voice.sidebar-ai-voice-clone')
<!-- Add Brand Voice -->
@endsection

@section("styles")

@endsection


@section("js")
    @include("backend.admin.clone.voice.js")
@endsection

