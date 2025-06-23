@extends("layouts.default")

@section('title')
    {{ localize('AI Product Shot') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("AI Product Shot"))

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
        <a href="{{ route('admin.images.index') }}" class="btn btn-primary btn-sm">
            <i data-feather="image"></i> {{ localize("All Images") }}
        </a>
    </div>
@endsection

@section("content")
    <!-- Page Content  -->
    <div class="tt-page-content mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card min-height-600">
                        <div class="card-body">
                            <form action="{{ route('admin.images.productShot.generateProductShotImage') }}"
                                  enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <x-form.input
                                                type="hidden"
                                                value=""
                                                name="theme_id"
                                        />
                                        <div class="productBackgroundDiv d-flex flex-wrap tt-grid tt-custom-scrollbar"></div>
                                    </div>

                                    <div class="col-lg-12 uploadImageDiv">
                                        <div class="form-input">
                                            <label for="upload" class="form-label">{{ localize("Upload Image") }}</label>
                                            <div class="file-drop-area file-upload text-center rounded-3 mb-5">
                                                <x-form.input
                                                        type="file"
                                                        class="file-drop-input"
                                                        name="image" />
                                                <div class="file-drop-icon ci-cloud-upload">
                                                    <i data-feather="image"></i>
                                                </div>
                                                <p class="mb-0 file-name text-muted">
                                                    ({{ localize("Only *jpg, png, webp will be accepted") }}) {{ $dimensions }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <x-form.button class="btn btn-primary" id="frmActionBtn" type="submit">
                                            {{ localize('Generate Image') }}
                                        </x-form.button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section("styles")
    <style>

        .tt-grid {
            display: grid;
            gap: 10px;
            width: 100%;  /* Use full width instead of calc */
            counter-reset: item;
            text-align: center;
            max-height: 450px;
            overflow-y: auto;
            grid-template-columns: repeat(8, 1fr); /* 8 columns by default */
            transition: all 0.3s ease-in-out;
        }

        .tt-item {
            padding: 8px;
            border: 1px solid transparent;
            border-radius: 6px;
            text-align: center;
            flex: 1 0 auto;
            counter-increment: item;
            width: 160px;
            transition: all 0.3s ease-in-out;
        }
        .tt-item img {  transition: all 0.3s ease-in-out;
        }
        .tt-item:hover{
            border-color: #007bff;
            cursor: pointer;
        }
        .tt-item:hover img{
            transition: all 0.3s ease-in-out;
            transform: scale(1.1);
        }
        /* Responsive adjustments using media queries */
        @media (max-width: 1200px) {
            .tt-grid {
                grid-template-columns: repeat(6, 1fr); /* 6 columns for medium screens */
            }

            .tt-item {
                width: calc(100% / 6 - 20px); /* Adjust width for 6 columns */
            }
        }

        @media (max-width: 992px) {
            .tt-grid {
                grid-template-columns: repeat(4, 1fr); /* 4 columns for tablets */
            }

            .tt-item {
                width: calc(100% / 4 - 20px); /* Adjust width for 4 columns */
            }
        }

        @media (max-width: 768px) {
            .tt-grid {
                grid-template-columns: repeat(3, 1fr); /* 3 columns for smaller screens */
            }

            .tt-item {
                width: calc(100% / 3 - 20px); /* Adjust width for 3 columns */
            }
        }

        @media (max-width: 576px) {
            .tt-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 columns for very small screens */
            }

            .tt-item {
                width: calc(100% / 2 - 20px); /* Adjust width for 2 columns */
            }
        }

        @media (max-width: 400px) {
            .tt-grid {
                grid-template-columns: 1fr; /* 1 column for the smallest screens */
            }

            .tt-item {
                width: 100%; /* Full width for single column */
            }
        }
        .themeDiv.active {
            border: 1px solid #007bff; /* Example active state styling */
        }

    </style>
@endsection


@section("js")
    <script>
        // $(document).on('click', '.themeDiv', function(e) {
        //     var themeId = $(this).attr('data-theme_id');

        //     $("input[name='theme_id']").val(themeId);
        // });

        // $(() => {
        //     loadThemes();
        // });

        // async function loadThemes(){
        //     $(".productBackgroundDiv").html("Loading.....");

        //     let callParams = {};
        //     callParams.type = "GET";
        //     callParams.url = "{{ route('admin.images.productShot.index') }}?loadThemes=true";
        //     callParams.dataType="json";

        //     await ajaxCall(callParams, function (response){
        //         $(".productBackgroundDiv").html(response.data);
        //     });
        // }

        $(document).on('click', '.themeDiv', function(e) {
            var themeId = $(this).attr('data-theme_id');
        
            // Set the theme ID in the input field
            $("input[name='theme_id']").val(themeId);

            // Add 'active' class to the clicked .themeDiv
            $(this).addClass('active');
            
            // Remove 'active' class from other .themeDiv elements
            $(this).siblings('.themeDiv').removeClass('active');
            
            // Ensure the image is properly loaded if lazy-loading is the issue
            var img = $(this).find('img');
            if (img.length) {
                img[0].src = img.attr('src');  // Trigger the image to load if it's not yet loaded
            }
        });

        $(() => {
            loadThemes();
        });

        async function loadThemes(){
            $(".productBackgroundDiv").html("Loading.....");

            let callParams = {};
            callParams.type = "GET";
            callParams.url = "{{ route('admin.images.productShot.index') }}?loadThemes=true";
            callParams.dataType="json";

            await ajaxCall(callParams, function (response){
                $(".productBackgroundDiv").html(response.data);
            });
        }
    </script>

@endsection

