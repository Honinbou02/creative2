@extends('layouts.default')

@section('title')
    {{ localize('Create New Post') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("Create Post")) 

@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => null, 'title' => localize('Create New Post')]]; @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('content')
    <!-- Page Content  -->
    <div class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12"> 
                    <form action="{{ route('admin.socials.posts.store') }}" method="POST" class="card flex-md-row" id="createPostForm">
                        @include('socialpilot::posts.inc.post-create-form')
                        @include('socialpilot::posts.inc.accounts-and-preview')
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content  -->
    
    <!-- platform required modals-->
    @include('socialpilot::posts.sidebar-generate-ai-content')

@endsection

@section("js")
    @include('common.media-manager.uppyScripts')
    @include('socialpilot::posts.create-js')
@endsection
