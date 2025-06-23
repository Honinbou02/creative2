@extends('layouts.default')

@section('title')
    {{ localize('Show Content') }}
@endsection
@section("pagetitle", localize("Show content")) 

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('Show Content')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    <div class="col-auto">

        <a href="{{ route('admin.ai-writer.create') }}" class="btn btn-primary">{{ localize('Generate Content') }}</a>
    </div>
@endsection

@section('content')
    <section class="tt-section pb-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card"> 
                        <div class="card-body">
                            <h2>{{ $content->title }}</h2>
                            <small class="border-bottom">{{ localize("Creation Date : ") }}: {{ $content->created_at }}</small>
                            <ul>
                                <li>{{ localize('Prompt Completion') }} : {{ $content->prompts_words }}</li>
                                <li>{{ localize('AI Response Completion') }} : {{ $content->completion_words }}</li>
                                <li>{{ localize('Total Words Completion') }} : {{ $content->total_words }}</li>
                            </ul>
                            <p>{{ localize("Prompt") }} : {{ $content->prompt }}</p>
                            <p>{{ localize("AI Response ") }} : {{ $content->response }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

