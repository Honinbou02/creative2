@extends('layouts.default')

@section('title')
    {{ localize('AI Writers') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("AI Writer List")) 
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('AI Writer List')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    <div class="col-auto">
        <a href="{{ route('admin.ai-rewriter.create') }}" class="btn btn-primary"><i data-feather="plus"></i> {{ localize('Re-Write Content') }}</a>
    </div>
@endsection

@section('content')
    <section class="tt-section pb-4">
        <div class="container">
            <div class="row">
               
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 bg-transparent pb-0">
                            <div class="row g-3">
                                <div class="col-auto flex-grow-1">
                                    <div class="tt-search-box w-auto">
                                        <x-form.input name="f_search" id="f_search"
                                            placeholder="{{ localize('Search') }}" class="rounded-start form-control-sm"
                                            hasIcon=true>
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"><i
                                                    data-feather="search" class="icon-16"></i></span>
                                        </x-form.input>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <x-form.select name="f_is_active" id="f_is_active" class="form-select-sm">
                                        <option value="">{{ localize('Status') }}</option>
                                        @foreach (appStatic()::STATUS_ARR as $statusKey => $status)
                                            <option value="{{ $statusKey }}">{{ $status }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                                <div class="col-auto">
                                    <x-form.button color="dark" type="button" class="btn-sm" id="searchBtn">
                                        <i data-feather="search" class="icon-14"></i>
                                        {{ localize('Search') }}
                                    </x-form.button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table border">
                                <thead>
                                    <tr class="bg-secondary-subtle">
                                        <th>{{ localize('S/L') }}</th>
                                        <th>{{ localize('Title') }}</th>
                                        <th>{{ localize('Content') }}</th>
                                        <th>{{ localize('Created By') }}</th>
                                        <th>{{ localize('Created At') }}</th>
                                        <th>{{ localize('Updated At') }}</th>
                                        <th>{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-common.empty-row colspan=7 loading=true />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @include('backend.admin.ai-writer.js')
@endsection
