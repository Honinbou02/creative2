@extends('layouts.default')

@section('title')
    {{ localize('Content') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection

@section('pagetitle')
    {{ localize('Contents Details') }}
@endsection

@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => route('admin.documents.index'), 'title' => localize('Documents')],['href' => null, 'title' => localize('Show')]]; @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection
@section('content')
    <!-- Page Content  -->
    <section class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                @if (!checkEditableContentType($content->content_type))
                                    <h2 class="h4">{{ $content->title }}</h2>
                                    <br>
                                @endif
                                @if (is_array($content->response) && ($content->content_purpose = appStatic()::PURPOSE_CONTENT_PLAGIARISM))
                                    @foreach ($content->response['results'] ?? [] as $key => $item)
                                        <div class="mb-4">
                                            <label for="title" class="form-label"> {{ $key + 1 }} .<span
                                                    class="fw-bold tt-promot-number fw-bold fs-4 me-2"></span>{{ @$item->title }}<span
                                                    class="text-danger ms-1">*</span> </label>
                                            <p><a href="{{ @$item->url }}">{{ @$item->url }}</a></p>
                                            @foreach ($item['excerpts'] as $data)
                                                <p>{!! @$data !!}</p>
                                            @endforeach
                                            <p>{{ @$item->date }}</p>

                                        </div>
                                    @endforeach
                                @else
                                    @if (!checkEditableContentType($content->content_type))
                                        {!! convertToHtml($content->response) !!}
                                    @else
                                        @include('backend.admin.generatedContent.edit')
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Page Content  -->

    @include('common.sidebar.sidebar_move_to_folder')
@endsection

@section("js")  
    @include('backend.admin.generatedContent.js')
    @include('common.sidebar.move_folder_js')
@endsection
