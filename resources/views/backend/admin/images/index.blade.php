@extends("layouts.default")

@section('title')
    {{ localize('AI Images') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("AI Image Generator")) 

@section("breadcrumb")
    @php
        $breadcrumbItems = [
        ["href" => null, "title" => localize("AI Image List")]
        ];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section("pageTitleButtons")
    @if(isCustomerUserGroup())
        @php
            $totalImageBalance     = userActivePlan()["image_balance"] ?? 0;
            $totalImageUsed        = userActivePlan()["image_balance_used"] ?? 0;
            $totalRemainingBalance = userActivePlan()["image_balance_remaining"] ?? 0;
        @endphp

        <div class="col-auto" id="balance-render">
            <x-common.balance-component :total="$totalImageBalance"
                                        :used="$totalImageUsed"
                                        :remaining="$totalRemainingBalance"
            />
        </div>
    @endif
    <div class="col-auto">
        <x-form.button type="button" data-bs-toggle="offcanvas" data-bs-target="#addFormSidebar" class="btn btn-primary">
            <i data-feather="image"></i> {{ localize("Generate Image") }}
        </x-form.button>
    </div>
@endsection

@section("content")
<!-- Page Content  -->
<div class="tt-page-content mb-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card min-height-600">
                    <div class="card-header border-0 bg-transparent pb-0">
                        @include("backend.admin.images.search_bar_image")
                    </div>

                    <div class="border-bottom position-relative mt-3">
                        <span class="nav-line-tab-left-arrow text-center cursor-pointer ms-2">
                            <i data-feather="chevron-left" class="icon-16"></i>
                        </span>
                        <ul class="nav nav-line-tab fw-medium px-3">
                            <li class="nav-item">
                                <button class="nav-link showImage allImage active">
                                    {{localize('All Images')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                   class="nav-link  showImage" data-content="dall-e-2">
                                    {{localize('Dall E 2')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                        class="nav-link  showImage " data-content="dall-e-3">
                                    {{localize('Dall E 3')}}
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link  showImage" data-content="sd-text-2-image">
                                    {{localize('Text to Image')}}
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link  showImage " data-content="sd-image-2-image">
                                    {{localize('Image to Image')}}
                                </button>
                            </li>


                            <li class="nav-item">
                                <button
                                   class="nav-link showImage " data-content="sd-image-2-image-upscalling">
                                    {{localize('Image Upscale')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link showImage " data-content="sd-multi-prompt-image">
                                    {{localize('Multi Prompt')}}
                                </button>
                            </li>
                        </ul>
                        <span class="nav-line-tab-right-arrow text-center cursor-pointer me-2">
                            <i data-feather="chevron-right" class="icon-16"></i>
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade active show " id="allImage">

                            </div>
                        </div>

                        <div class="row g-2 allImageRow">
                            @include("backend.admin.images.image-list")
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content  -->

@include("backend.admin.images.modal_image")
@include("backend.admin.images.sidebar_image")
@include("common.move-to-folder-offcanvas")
@endsection

@section("js")
    @include("backend.admin.images.js")
    @include("common.move-to-folder-js")
@endsection
