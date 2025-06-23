@extends('layouts.default')

@section('title')
    {{ localize('Audio To Text') }}{{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("Audio To Text")) 

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('Audio To Text')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    @if(isCustomerUserGroup())
        @php
        $totalWordBalance     = userActivePlan()["speech_balance"] ?? 0;
        $totalWordUsed        = userActivePlan()["speech_balance_used"] ?? 0;
        $totalRemainingBalance = userActivePlan()["speech_balance_remaining"] ?? 0;
        @endphp
        <div class="col-auto" id="balance-render">

            <x-common.balance-component :total="$totalWordBalance"
                                    :used="$totalWordUsed"
                                    :remaining="$totalRemainingBalance"
            />
        </div>
    @endif
    <div class="col-auto">

        <a href="{{route('admin.documents.index', ['content_purpose'=>appStatic()::PURPOSE_VOICE_TO_TEXT])}}" class="btn btn-primary btn-sm"><i
                class="las la-plus me-1"></i>{{ localize('All Generated Content') }}</a>
    </div>
@endsection

@section('content')
    <section class="tt-section pb-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card border-0">

                        <div class="card content-generator flex-md-row">

                            <div class="content-generator__sidebar">
                                <div class="content-generator__sidebar-header pb-0 border-bottom">
                                    <h6> {{ localize('Voice to Text') }}</h6>       
                                </div>
                                <form action="{{ route('admin.voice-to-text.store') }}" method="POST" id="aiVoiceToText" enctype="multipart/form-data">
                                    @csrf
                                    <x-form.input type="hidden" name="content_purpose" id="content_purpose"
                                        value="{{ appStatic()::PURPOSE_VOICE_TO_TEXT }}" />
                                    <div class="content-generator__sidebar-body tt-custom-scrollbar overflow-y-auto tt-screen-height">
                                        <div class="row g-3">
                                            <div class="col-12">

                                                <x-form.label for="title" label="{{ localize('Type Text Title') }}"
                                                    isRequired=true />
                                                <x-form.input name="title" id="title" type="text"
                                                    placeholder="{{ localize('Title') }}" value="" showDiv=false />
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="file-drop-area file-upload text-center rounded-3">
                                                    <input type="file" class="file-drop-input" name="audio"
                                                        id="audio" />
                                                    <div class="file-drop-icon ci-cloud-upload">
                                                        <i data-feather="image"></i>
                                                    </div>
                                                    <p class="text-dark fw-bold mb-2 mt-3">
                                                        {{ localize('Drop your files here or') }}
                                                        <a href="javascript::void(0);"
                                                            class="text-primary">{{ localize('Browse') }}</a>
                                                    </p>
                                                    <p class="mb-0 file-name text-muted">
                                                        <small>* {{ localize('Allowed file types: ') }} .mp3, .mp4, .mpeg,
                                                            .mpga, .m4a,
                                                            .wav, .webm @if (isCustomerUserGroup())
                                                                | {{ localize('Max Size: ') }} MB
                                                            @endif </small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-generator__sidebar-footer">
                                        <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
                                            <button class="btn btn-sm btn-primary rounded-pill" type="submit"
                                                id="generateContent">
                                                {{ localize('Generate Content') }}
                                            </button>

                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="content-generator__body">
                                <div class="content-generator__body-header">
                                    <div
                                        class="p-3 py-2 border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between bg-light-subtle tt-chat-header">


                                        <div class="col-auto flex-grow-1">
                                            <input class="form-control border-0 px-2 form-control-sm" type="text"
                                                id="name" name="name" placeholder="Name of the document...">
                                            <input class="form-control border-0 px-2 form-control-sm" type="hidden"
                                                id="generate_content_id" name="generate_content_id">
                                        </div>
                                        <div class="tt-chat-action d-flex align-items-center">

                                           

                                            <div class="dropdown tt-tb-dropdown me-2">
                                                <button type="button" class="btn p-0 copyChat" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy"><i data-feather="copy"
                                                        class="icon-16"></i></button>
                                            </div>
                                           
                                            <div class="dropdown tt-tb-dropdown me-2">
                                                <button type="button" class="btn p-0 saveChange" data-bs-toggle="tooltip" data-bs-placement="top" title="Save"><i data-feather="save"
                                                        class="icon-16"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-generator__body-content">
                                    <div id="contentGenerator" class="contentGenerator"></div>

                                </div>
                                <div class="d-flex justify-content-end mb-3 px-3">
                                    <button
                                        class="btn btn-primary px-3 py-1 rounded-pill saveChange" disabled>{{ localize('Save Changes') }}</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @include('backend.admin.voice2Text.js')
@endsection
