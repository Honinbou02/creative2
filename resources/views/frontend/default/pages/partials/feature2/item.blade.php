@php
    $title       = "feature_{$itemNo}_title";
    $icon        = "feature_{$itemNo}_svg_code";
    $description = "feature_{$itemNo}_short_description";
    $active      = "feature_{$itemNo}_is_active";

    $defaultSvg = '<svg width="54" height="55" viewBox="0 0 54 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect y="0.271973" width="54" height="54" rx="10" fill="white" fill-opacity="0.05"/>
                    <path d="M17.0833 21.6053C23.0154 25.8426 30.9844 25.8426 36.9166 21.6053V35.772C30.7717 39.2834 23.2281 39.2834 17.0833 35.772V21.6053Z" fill="white"/>
                    <path d="M26.9999 24.4386C32.4767 24.4386 36.9166 22.5358 36.9166 20.1886C36.9166 17.8414 32.4767 15.9386 26.9999 15.9386C21.5231 15.9386 17.0833 17.8414 17.0833 20.1886C17.0833 22.5358 21.5231 24.4386 26.9999 24.4386Z" stroke="url(#paint0_linear_1860_2905)" stroke-width="1.7"/>
                    <path d="M17.0833 28.6886C17.0833 28.6886 17.0833 32.008 17.0833 34.3553C17.0833 36.7025 21.5231 38.6053 26.9999 38.6053C32.4768 38.6053 36.9166 36.7025 36.9166 34.3553C36.9166 33.1837 36.9166 28.6886 36.9166 28.6886" stroke="url(#paint1_linear_1860_2905)" stroke-width="1.7" stroke-linecap="square"/>
                    <path d="M17.0833 20.1886C17.0833 20.1886 17.0833 24.9247 17.0833 27.2719C17.0833 29.6192 21.5231 31.5219 26.9999 31.5219C32.4768 31.5219 36.9166 29.6192 36.9166 27.2719C36.9166 26.1003 36.9166 20.1886 36.9166 20.1886" stroke="url(#paint2_linear_1860_2905)" stroke-width="1.7"/>
                    <defs>
                    <linearGradient id="paint0_linear_1860_2905" x1="17.0833" y1="20.1886" x2="36.9166" y2="20.1886" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#805AF9"/>
                    <stop offset="1" stop-color="#6632F8"/>
                    </linearGradient>
                    <linearGradient id="paint1_linear_1860_2905" x1="17.0833" y1="33.6469" x2="36.9166" y2="33.6469" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#805AF9"/>
                    <stop offset="1" stop-color="#6632F8"/>
                    </linearGradient>
                    <linearGradient id="paint2_linear_1860_2905" x1="17.0833" y1="25.8553" x2="36.9166" y2="25.8553" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#805AF9"/>
                    <stop offset="1" stop-color="#6632F8"/>
                    </linearGradient>
                    </defs>
                </svg>';
@endphp

@if(getSetting($active) != 0)
    <div class="col-md-6 col-xl-4">
        <div class="p-7 rounded-3 wt_card_style h-100">
            <div class="d-flex align-items-center gap-4 mb-4">
                <span><?=  getSetting($icon) ?? $defaultSvg ?></span>
                <h6 class="fs-20 mb-0">{{ systemSettingsLocalization($title) }}</h6>
            </div>
            <p class="fs-14 mb-0">{{ systemSettingsLocalization($description) }}</p>
        </div>
    </div>
@endif