@php
    $itemNo    = 2;
    $title     = "feature_document_{$itemNo}_title";
    $short     = "feature_document_{$itemNo}_sub_title";
    $btnText   = "feature_document_{$itemNo}_btn_text";
    $btnLink   = "feature_document_{$itemNo}_btn_link";
    $itemImage = "feature_document_{$itemNo}_image";
    $headingTitle = systemSettingsLocalization($title);

    $promptH6 = "feature_document_{$itemNo}_short_title";
    $promptP  = "feature_document_{$itemNo}_short_description";
@endphp

@if(!empty($headingTitle))
    <div class="col-md-6 col-lg-4">
        <div class="p-7 rounded-2 wt_card_style h-100 wow animate__animated animate__fadeInLeft animate__delay-0_1s">
            <div class="px-5 py-8 rounded-2 text-center wt_card_style_2 mb-8">
                <h6 class="fs-20 mb-2">{{ $headingTitle }}</h6>
                <p class="fs-14 mb-5">{{ getSetting($short) }}</p>
                <a href="{{ getSetting($btnLink) }}" class="btn btn-outline-light rounded-pill border-0 fw-normal d-inlne-flex align-items-center gap-2 text-body">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" width="24" height="24" rx="12" fill="url(#paint0_linear_1806_779)" />
                        <path d="M6.9391 11.6526C6.9391 11.6526 12.9482 11.6526 18.3677 11.6526M18.3677 11.6526C14.4526 11.6526 13.73 7.65259 13.73 7.65259M18.3677 11.6526C14.4526 11.6526 13.73 15.6526 13.73 15.6526" stroke="white" stroke-width="1.1" />
                        <defs>
                            <linearGradient id="paint0_linear_1806_779" x1="0.5" y1="12" x2="24.5" y2="12" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#805AF9" />
                                <stop offset="1" stop-color="#6632F8" />
                            </linearGradient>
                        </defs>
                    </svg>
                    {{ getSetting($btnText) }}
                </a>
            </div>

            <div class="text-center">
                <img src="{{avatarImage(getSetting('feature_document_2_image'))}}"
                     alt="Image"
                     class="img-fluid"
                />
            </div>
        </div>
    </div>
@endif
