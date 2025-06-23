@php
    $itemNo           = 4;
    $active           = getSetting("feature_tool_{$itemNo}_is_active");
    $title            = systemSettingsLocalization("feature_tool_{$itemNo}_title");
    $shortDescription = systemSettingsLocalization("feature_tool_{$itemNo}_short_description");
    $image            = avatarImage(getSetting("feature_tool_{$itemNo}_image"));
@endphp

@if($active)

    <div class="col-md-6">
        <div class="rounded-3 wt_card_style h-100 wow animate__animated animate__fadeInUp">
            <div class="d-flex align-items-center justify-content-between gap-4 h-100">
                <div class="p-9 pe-0">
                    <h6 class="fs-20 mb-3">
                        {{ $title }}
                    </h6>
                    <p class="fs-14 max-text-40 mb-0">
                        {{ $shortDescription }}
                    </p>
                </div>
                <div class="pe-6 text-center d-none d-lg-block">
                    <img src="{{ $image }}"
                         alt="Image"
                         class="img-fluid"
                    />
                </div>
            </div>
        </div>
    </div>
@endif
