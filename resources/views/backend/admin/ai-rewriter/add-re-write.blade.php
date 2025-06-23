@extends('layouts.default')

@section('title')
    {{ localize('AI Re-Writer') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection

@section('title')
    {{ localize('AI Re-Writers') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection

@section("pagetitle", localize("AI Re-Writer"))
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('AI Re-Writer')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    @php
        $totalWordBalance     = userActivePlan()["word_balance"] ?? 0;
        $totalWordUsed        = userActivePlan()["word_balance_used"] ?? 0;
        $totalRemainingBalance = userActivePlan()["word_balance_remaining"] ?? 0;
    @endphp

    <div class="col-auto" id="balance-render">

        <x-common.balance-component :total="$totalWordBalance"
                                    :used="$totalWordUsed"
                                    :remaining="$totalRemainingBalance"
        />
    </div>

    <div class="col-auto">
        <a href="{{ route('admin.ai-rewriter.index') }}" class="btn btn-primary"><i data-feather="list"></i> {{ localize('Content List') }}</a>
    </div>
@endsection

@section('content')
    <section class="tt-section pb-4">
        <div class="container">
            <div class="row">
                @if(isOpenAiEngine(aiReWriterEngine()))
                    <x-common.open-ai-error/>
                @endif
                <div class="col-xl-12">
                    <div class="card border-0">

                        <div class="card content-generator flex-md-row">

                            <div class="content-generator__sidebar">
                                <div class="content-generator__sidebar-header pb-0 border-bottom">
                                    <h6> {{ localize('AI Rewriter') }}</h6>       
                                </div>
                                <form action="{{ route('admin.ai-writer.store') }}" method="POST" class="mb-0" id="aiReWriterForm">
                                    @csrf
                                   @include("backend.admin.ai-rewriter.form-rewriter")
                                </form>
                            </div>

                            <div class="content-generator__body">
                                @include("backend.admin.ai-rewriter.form-right-rewrite")

                                <div class="content-generator__body-content">
                                    <div id="contentGeneratorAiReWrite" class="contentGenerator"></div>
                                </div>
                                <div class="d-flex justify-content-end mb-3 mt-4 px-3">
                                    <x-form.button class="btn btn-sm btn-primary rounded-pill saveChange" disabled id="saveChangeBtn">
                                        <i data-feather="save" class="icon-14"></i>
                                        {{ localize('Save Changes') }}
                                    </x-form.button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('common.move-to-folder-offcanvas')
@endsection
@section('js')
    @include('backend.admin.ai-rewriter.js')
    @include("common.move-to-folder-js")
@endsection
