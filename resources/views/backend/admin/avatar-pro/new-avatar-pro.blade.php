@extends("layouts.default")
@php
    $pageTitle = localize("AI Avatar Pro");
@endphp
@section("pagetitle", localize("AI Avatar Pro")) 
@section('title')
    {{ $pageTitle}} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection

@section("breadcrumb")
    @php
        $breadcrumbItems = [
            ["href" => null, "title" => localize("")]
        ];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection


@section("pageTitleButtons")
    <div class="col-auto">
        <a href="{{ route('admin.avatarPro.index') }}" class="btn btn-primary">
            <i data-feather="video"></i> {{ localize("All Videos") }}
        </a>
    </div>
@endsection


@section("content")
    <!-- Page Content  -->
    <div class="tt-page-content mb-4">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ localize('New Video') }}</h5>
                        </div>

                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{ route('admin.avatarPro.createVideo') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="avatar_id" class="form-label">{{ localize("Select Video Avatar Style") }}</label>
                                        <x-form.input
                                            type="hidden"
                                            name="avatar_id"
                                            id="avatar_id"
                                        />
                                        <div class="loadAvatars d-flex flex-wrap tt-grid overflow-y-auto tt-custom-scrollbar" style="height: 350px;"></div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <x-form.label for="avatarStyle" label="Avatar Style" class="form-label"></x-form.label>
                                        <select id="avatarStyle" name="avatar_style" class="form-control form-control-sm" required>
                                            <option value="circle">{{ localize("Circle") }}</option>
                                            <option value="normal">{{ localize("Normal") }}</option>
                                            <option value="closeup">{{ localize("Close-up") }}</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <x-form.label for="matting" label="Matting" class="form-label"></x-form.label>
                                        <select id="matting" name="matting" class="form-control form-control-sm">
                                            <option value="1">{{ localize("True") }}</option>
                                            <option value="0">{{ localize("False") }}</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <x-form.label for="caption" label="Caption" class="form-label"></x-form.label>
                                        <select id="caption" name="caption" class="form-control form-control-sm" required>
                                            <option value="Yes">{{ localize("Yes") }}</option>
                                            <option value="No">{{ localize("No") }}</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label for="voice" class="form-label">{{ localize("Select Voice") }}
                                            <button type="button" class="ms-1 py-0 px-2 btn btn-secondary playAudio">
                                                {{ localize("Play Audio") }}
                                            </button>
                                        </label>
                                        <select id="voice" name="voice_id" class="form-control form-select-sm voiceHtml" required>
                                            <option value="">Loading...</option>
                                        </select>
                                    </div>

                                    

                                    <div class="mb-3">
                                        <label for="script" class="form-label">{{ localize("Video Script Text") }}</label>
                                        <x-form.textarea id="script" name="script" class="form-control" required></x-form.textarea>
                                        <span>
                                            <small>{{ localize("Please enter video script text.") }}</small>
                                        </span>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Create Video</button>
                                </div>
                            </form>

                            <div id="result" class="mt-4"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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

