@extends("layouts.default")
@php
    $pageTitle = localize("AI Avatar Pro");
@endphp
@section('title')
    {{ $pageTitle}} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("AI Avatar Pro"))
@section("breadcrumb")
    @php
        $breadcrumbItems = [
            ["href" => null, "title" => localize("AI Avatar Pro")]
        ];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection


@section("pageTitleButtons")
    <div class="col-auto">
        <!-- <a href="{{ route('admin.avatarPro.create') }}" class="btn btn-primary">
            <i data-feather="video"></i> {{ localize("New Video") }}
        </a> -->
        <x-form.button type="button" id="addAvatarProFrmOffCanvas" data-bs-toggle="offcanvas"
            data-bs-target="#addAvatarProFormSidebar">
            <i data-feather="plus"></i>{{ localize('New Video') }}
        </x-form.button>
    </div>
@endsection


@section("content")
    <!-- Page Content  -->
    <div class="tt-page-content mb-4">
        <div class="container">
            <div class="row g-3 loadAvatarProVideos"></div>
        </div>
    </div>

     <!-- Avatar Pro offcanvas start-->
     @include('backend.admin.avatar-pro.add-avatar-pro')
    <!-- Avatar Pro offcanvas end -->

@endsection

@section("styles")

    <style>
        .tt-avatar-item {
            padding: 8px;
            border: 1px solid transparent;
            border-radius: 6px;
            text-align: center;
            flex: 1 0 auto;
            counter-increment: item;
            width: 120px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            border: 1px solid #ebebeb;
        }
        .tt-avatar-item:hover {
            border: 1px solid #007bff;
        }
        .tt-avatar-item:hover img {
            transition: all 0.3s ease-in-out;
            transform: scale(1.1);
        }
        .avatarImg{
            position: relative;
            display: block;
            overflow: hidden;
        }
        .avatarImg img {
            object-fit: cover !important;
            aspect-ratio: 1 / 1;
            -webkit-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
            border-radius: 6px;
        }
        .tt-avatar-item.activeAvatar{
            border: 1px solid #007bff;
        }
    </style>
@endsection



@section("js")
    @include("backend.admin.avatar-pro.js")
@endsection

