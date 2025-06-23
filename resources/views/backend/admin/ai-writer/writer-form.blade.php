@extends('layouts.default')

@section('title')
    {{ localize('AI Writer') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section('title')
    {{ localize('AI Writers') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("AI Writer")) 
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('AI Writer')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection
@section('pageTitleButtons')
@php
$totalWordBalance     = userActivePlan()["word_balance"] ?? 0;
$totalWordUsed        = userActivePlan()["word_balance_used"] ?? 0;
$totalRemainingBalance = userActivePlan()["word_balance_remaining"] ?? 0;
@endphp

@if(isCustomerUserGroup())
<div class="col-auto" id="balance-render">

    <x-common.balance-component :total="$totalWordBalance"
                            :used="$totalWordUsed"
                            :remaining="$totalRemainingBalance"
                            />
</div>
@endif

    <div class="col-auto">
        <a href="{{ route('admin.ai-writer.index') }}" class="btn btn-primary"><i class="las la-plus me-1"></i>{{ localize('All Content') }}</a>
    </div>
@endsection

@section('content')
    <section class="tt-section pb-4">
        <div class="container">
            <div class="row">
                @if(isOpenAiEngine(aiWriterEngine()))
                    <x-common.open-ai-error/>
                @endif
                <div class="col-xl-12">
                    <div class="card border-0">

                        <div class="card content-generator flex-md-row">

                            <div class="content-generator__sidebar">
                                <div class="content-generator__sidebar-header pb-0 border-bottom">
                                    <h6> {{ localize('AI Writer') }}</h6>       
                                </div>
                                <form action="{{ route('admin.ai-writer.store') }}" method="POST" class="mb-0" id="aiWriterForm">
                                    @csrf
                                    <x-form.input type="hidden" name="content_purpose" value="{{appStatic()::PURPOSE_GENERATE_TEXT}}"/>
                                    <div class="content-generator__sidebar-body overflow-y-auto tt-screen-height">
                                        <div class="row g-3">
                                            <div class="col-12">

                                                <x-form.label for="language"
                                                    label="{{ localize('Select input and output language') }}"
                                                    isRequired=true />
                                                <x-form.select name="language" id="language">
                                                    @foreach (languages() as $language)
                                                        
                                                    <option value="{{$language->name}}">{{$language->name}}</option>
                                                    @endforeach
                                                </x-form.select>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <x-form.label for="prompt"
                                                        label="{{ localize('Input your content') }}" isRequired=true />
                                                    <x-form.textarea name="prompt" class="form-control" id="textarea" rows="10" placeholder="{{ localize('Ex. Your prompt here.') }}"></x-form.textarea>
                                                </div>

                                            </div>
                                            @if(isUseOpenAiEngine())
                                            <div class="col-12">
                                                <div class="text-left">                                                    
                                                    <div class="d-flex align-items-center tt-advance-options cursor-pointer">
                                                        <x-form.label
                                                                class="form-label cursor-pointer btn btn-sm btn-secondary rounded-pill fw-medium"
                                                                for="tt-advance-options">
                                                                <i class="las la-plus"></i>
                                                                {{ localize("Advance Options") }}
                                                        </x-form.label>
                                                    </div>

                                                    <div class="toggle-next-element__is bg-secondary bg-opacity-50 p-lg-4 p-2 rounded-3 tt-advance-options-content">
                                                        <div class="row g-3">
                                                            <div class="col-12">

                                                                <x-form.label for="max_tokens"
                                                                    label="{{ localize('Max Results Length') }}" />
                                                                <x-form.input type="text" name="max_tokens"
                                                                    class="form-control form-control-sm"
                                                                    id="maxArticleLength" placeholder="10" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <x-form.label for="tone"
                                                                    label="{{ localize('Choose a Tone') }}" />
                                                                <x-form.select name="tone"
                                                                    class="form-select form-select-transparent form-select--sm"
                                                                    id="tone">
                                                                    @foreach (appStatic()::OPEN_AI_TONE as $key => $item)
                                                                        <option value="{{ $key }}">
                                                                            {{ localize($item) }}</option>
                                                                    @endforeach

                                                                </x-form.select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <x-form.label for="creativity"
                                                                    label="{{ localize('Creativity') }}" isRequired=true />
                                                                <x-form.select name="creativity"
                                                                    class="form-select form-select-transparent form-select--sm"
                                                                    id="creativity">

                                                                    @foreach (appStatic()::OPEN_AI_CREATIVITY as $key => $name)
                                                                        <option value="{{ (int) $key }}">
                                                                            {{ localize($name) }}</option>
                                                                    @endforeach

                                                                </x-form.select>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="content-generator__sidebar-footer py-3">
                                        <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
                                            <x-form.button class="btn btn-sm btn-primary rounded-pill" type="submit" id="generateContent">
                                                {{ localize('Generate Content') }}
                                                <i data-feather="rotate-cw" class="icon-14"></i>
                                            </x-form.button>
                                            <x-form.button class="btn btn-sm btn-secondary rounded-pill" id="stopGenerateContent" disabled>
                                                {{ localize('Stop Generation') }}
                                                <i data-feather="stop-circle" class="icon-14"></i>
                                            </x-form.button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="content-generator__body">
                                <div class="content-generator__body-header">
                                    <div
                                        class="p-3 py-2 border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between bg-light-subtle tt-chat-header d-none">


                                        <div class="col-auto flex-grow-1">
                                            <input class="form-control border-0 px-2 form-control-sm" type="text"
                                                id="name" name="name" placeholder="Name of the document...">
                                            <input class="form-control border-0 px-2 form-control-sm" type="hidden"
                                                id="writter_id" name="writter_id">
                                        </div>
                                        <div class="tt-chat-action d-flex align-items-center"> 
                                            <div class="dropdown tt-tb-dropdown me-2">
                                                <a href="#" class="overly-btn overly-delete bg-white text-light moveToFolder" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasMoveToFolder">
                                                    <span title="{{localize('Move To Folder')}}"><i data-feather="folder" class="icon-14 text-black"></i></span>
                                                </a>
                                            </div>
                                            <div class="dropdown tt-tb-dropdown me-2">
                                                <button type="button" class="btn p-0 copyChat"><i data-feather="copy"
                                                        class="icon-16"></i></button>
                                            </div>
                                            <div class="dropdown tt-tb-dropdown me-2">
                                                <button class="btn p-0" id="navbarDropdownUser" role="button"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                                    aria-haspopup="true" aria-expanded="true">
                                                    <i data-feather="download" class="icon-16"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end shadow">
                                                    <a class="dropdown-item downloadChatBtn" href="javascript:void(0);" data-download_type="pdf">
                                                        <i data-feather="file" class="me-2"></i> {{localize('PDF')}}
                                                    </a>
                                                    <a class="dropdown-item downloadChatBtn" href="javascript:void(0);" data-download_type="html">
                                                        <i data-feather="code" class="me-2"></i> {{localize('HTML')}}
                                                    </a>
                                                    <a class="dropdown-item downloadChatBtn" href="javascript:void(0);" data-download_type="word">
                                                        <i data-feather="file-text" class="me-2"></i>{{localize('MS Word')}}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dropdown tt-tb-dropdown me-2">
                                                <button type="button" class="btn p-0 saveChange"><i data-feather="save"
                                                        class="icon-16"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-generator__body-content">
                                    <div id="contentGenerator" class="contentGenerator"></div>
                                    
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
    @include('backend.admin.ai-writer.js')
    @include("common.move-to-folder-js")
@endsection
