@extends('layouts.default')

@section('title')
    {{ localize('AI Detector') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section('pagetitle')
    {{ localize('AI Detector') }}
@endsection

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('AI Detector')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    <div class="col-auto">

        <a href="{{route('admin.documents.index', ['content_purpose'=>appStatic()::PURPOSE_CONTENT_DETECTOR])}}" class="btn btn-primary"><i class="las la-plus me-1"></i>{{ localize('All Content') }}</a>
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
                                <form action="{{ route('admin.ai-detector.store') }}" method="POST" id="aiContentScan">
                                    @csrf
                                    <x-form.input type="hidden" name="content_purpose" value="{{appStatic()::PURPOSE_CONTENT_DETECTOR}}"/>
                                    <div class="content-generator__sidebar-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <x-form.label for="title" label="{{ localize('Type Text Title') }}"
                                                    isRequired=true />
                                                <x-form.input name="title" id="title" type="text"
                                                    placeholder="{{ localize('Title') }}" value="" showDiv=false />
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <x-form.label for="text"
                                                        label="{{ localize('Input your content') }}" isRequired=true />
                                                    <x-form.textarea name="text" class="form-control" id="textarea"
                                                        rows="30" />
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="content-generator__sidebar-footer py-3">
                                        <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
                                            <button class="btn btn-sm btn-primary rounded-pill" type="submit" id="scanContent">
                                                {{ localize('Scan Content') }}
                                            </button>

                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="content-generator__body">
                                <div class="tt-generate-text" id="renderChat">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card flex-column h-100 border-0 rounded-0 border-bottom">
                                                <div class="card-body d-flex flex-column h-100">
                                                    <span class="text-muted"></span>
                                                    <h4 class="fw-bold">{{ localize('Scan Report') }}</h4>
                                                    <div id="donutChat"></div>
                                                        <li>{{localize('Human Writing')}} : <strong>100</strong> </li>
                                                        <li>{{localize('AI Writing')}} :  <strong>0</strong></li>
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
    </section>
@endsection
@section('js')
    @include('backend.admin.plagiarism.detect-content.js')
@endsection
