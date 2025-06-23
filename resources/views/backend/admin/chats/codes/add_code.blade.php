@extends('layouts.default')

@section('title')
    {{ localize('Generate Code') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("AI Generate Code")) 
@section('breadcrumb')
    @php
        $breadcrumbItems = [
            ["href"  => null, "title" => "Generate Code"]
        ]; @endphp
    <x-common.breadcumb :items="$breadcrumbItems"/>
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
@endsection

@section('content')
    <!-- Page Content  -->
    <section class="mb-4">
        <div class="container">

            <div class="row">
                @if(isOpenAiEngine(generateCodeEngine()))
                <x-common.open-ai-error/>
            @endif
                <div class="col-12">
                    <div class="card content-generator flex-md-row">
                        
                        <div class="content-generator__sidebar content-generator__sidebar--end">
                            <form action="{{ route('admin.openai.chats.contentGenerator') }}" method="POST" id="addCodeGenerator">
                                @csrf
                                @if (generateCodeEngine() == appStatic()::ENGINE_DEEPSEEK_AI)
                                    <input type="hidden" name="temperature" value="0.0">
                                @endif
                                @include("backend.admin.chats.codes.form_code")
                            </form>
                        </div>
                        <div class="content-generator__body">
                            {{-- @include("backend.admin.chats.codes.output-code-top-bar") --}}
                            <div class="content-generator__body-content padding-5">
                                <pre class="code-view hljs content-generator__sidebar-body rounded-0">
                                    <code class="language-markup"> </code>
                                </pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /Page Content  -->
@endsection


@push('scripts')
    @include('backend.admin.chats.codes.js')
@endpush
