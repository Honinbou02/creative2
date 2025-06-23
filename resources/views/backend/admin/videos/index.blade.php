@extends("layouts.default")

@section('title')
{{ localize('AI Video') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("AI Video Generator"))

@section("breadcrumb")
    @php
        $breadcrumbItems = [
        ["href" => null, "title" => "AI Video Generator"]
        ];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section("pageTitleButtons")
        @if(isCustomerUserGroup())

            @php
            $totalImageBalance     = userActivePlan()["video_balance"] ?? 0;
            $totalImageUsed        = userActivePlan()["video_balance_used"] ?? 0;
            $totalRemainingBalance = userActivePlan()["video_balance_remaining"] ?? 0;
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
            <i data-feather="image"></i> {{ localize("Generate Video") }}
        </x-form.button>
    </div>
@endsection

@section("content")
    <!-- Page Content  -->
    <div class="tt-page-content mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 bg-transparent pb-0">
                            @include("backend.admin.images.search_bar_image")
                        </div>

                        <div class="border-bottom position-relative mt-3">
                            <span class="nav-line-tab-left-arrow text-center cursor-pointer ms-2">
                                <i data-feather="chevron-left" class="icon-16"></i>
                            </span>

                            <span class="nav-line-tab-right-arrow text-center cursor-pointer me-2">
                                <i data-feather="chevron-right" class="icon-16"></i>
                            </span>
                        </div>

                        <div class="card-body table-responsive-md">
                            <table class="table border rounded">
                                <thead>
                                    <tr class="bg-secondary-subtle">
                                        <th>{{ localize('S/L') }}</th>
                                        <th>{{ localize('Title') }}</th>
                                        <th>{{ localize('Model Name') }}</th>
                                        <th>{{ localize('Created Date') }}</th>
                                        <th class="text-center">{{ localize('Type') }}</th>
                                        <th class="text-center">{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="vedio-list">
                                    <x-common.empty-row colspan=7 loading=true />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content  -->

    @include("backend.admin.videos.sidebar_video")
@endsection

@section("js")
    @include("backend.admin.videos.js")
@endsection
