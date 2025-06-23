@extends('layouts.default')

@section('title')
    {{ localize('Show Content') }}
@endsection

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
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

