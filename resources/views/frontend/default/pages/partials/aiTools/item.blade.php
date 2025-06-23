@php
    $active           = getSetting("feature_tool_{$itemNo}_is_active");
    $title            = systemSettingsLocalization("feature_tool_{$itemNo}_title");
    $shortDescription = systemSettingsLocalization("feature_tool_{$itemNo}_short_description");
    $image            = avatarImage(getSetting("feature_tool_{$itemNo}_image"));
@endphp

@if($active)
    <div class="col-md-6 col-lg-4">
        <div class="p-9 rounded-3 wt_card_style  h-100 wow animate__animated animate__fadeInLeft">
            <div class="d-flex flex-column justify-content-between gap-4 h-100">
                <div class="text-center">
                    <h6 class="fs-20 mb-3">{{ $title }}</h6>
                    <p class="fs-14 mb-0">{{ $shortDescription }}</p>
                </div>

                <img src="{{ $image }}"
                     alt="Image"
                     class="img-fluid w-100"
                />
            </div>
        </div>
    </div>
@endif
