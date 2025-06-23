@php
    $itemNo           = 5;
    $active           = getSetting("feature_tool_{$itemNo}_is_active");
@endphp

@if(!empty($active))
    <div class="col-md-6">
        <div class="rounded-3 wt_card_style h-100 animate__fadeInUp">
            <div class="d-flex flex-column justify-content-between gap-4 h-100">
                <div class="p-9 text-center">
                    <h6 class="fs-20 mb-3">{{ systemSettingsLocalization("feature_tool_{$itemNo}_title") }}</h6>
                    <p class="fs-14 max-text-36 mx-auto mb-0">{{ systemSettingsLocalization("feature_tool_{$itemNo}_short_description") }}</p>
                </div>

                <div class="px-5 text-center">
                    <img src="{{ avatarImage(getSetting("feature_tool_{$itemNo}_image")) }}"
                         alt="Image"
                         class="img-fluid w-100"
                    />
                </div>
            </div>
        </div>
    </div>
@endif
