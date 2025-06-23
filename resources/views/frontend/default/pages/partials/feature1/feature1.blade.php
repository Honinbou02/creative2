@if(getSetting('feature_document_1_is_active') != 0)

    <div class="container">
    <div class="row">
        <div class="col-lg-7">
            <div class="d-inline-block text-center px-5 py-1 rounded-pill border border-1 border-primary mb-4">
                <p class="fs-14 fw-normal mb-0">{{ localize("Features") }}</p>
            </div>
            <h2 class="fs-48 mb-5">{{systemSettingsLocalization('feature_document_1_title')}}</h2>
            <div class="d-flex align-items-center gap-2 flex-wrap mb-40">
                <a href="{{ getSetting('feature_document_1_btn_link') ?? route('login') }}"
                   class="btn bg-gradient-1 rounded-pill px-3 py-2 fs-14 d-flex align-items-center gap-2 text-white fw-normal">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" rx="12" fill="white" />
                        <path d="M6.4391 11.6526C6.4391 11.6526 12.4482 11.6526 17.8677 11.6526M17.8677 11.6526C13.9526 11.6526 13.23 7.65259 13.23 7.65259M17.8677 11.6526C13.9526 11.6526 13.23 15.6526 13.23 15.6526" stroke="url(#paint0_linear_1722_4739)" stroke-width="1.1" />
                        <defs>
                            <linearGradient id="paint0_linear_1722_4739" x1="12.1534" y1="7.65259" x2="12.1534" y2="15.6526" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#805AF9" />
                                <stop offset="1" stop-color="#6632F8" />
                            </linearGradient>
                        </defs>
                    </svg>
                    {{systemSettingsLocalization('feature_document_1_btn_text') ?? localize('Try it Now')}}
                </a>
                <a href="{{ getSetting('feature_document_1_btn_link_2') ?? route('register') }}"
                   class="btn btn-lg btn-outline-light px-3 py-2 fs-14 rounded-pill border-primary btn-svg-hover d-flex align-items-center gap-2 fw-normal text-heading">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="-0.00732422" width="24" height="24" rx="12" fill="url(#paint0_linear_1780_21102)"></rect>
                        <path d="M6.43178 11.6523C6.43178 11.6523 12.4408 11.6523 17.8604 11.6523M17.8604 11.6523C13.9453 11.6523 13.2227 7.65234 13.2227 7.65234M17.8604 11.6523C13.9453 11.6523 13.2227 15.6523 13.2227 15.6523" stroke="white" stroke-width="1.1"></path>
                        <defs>
                            <linearGradient id="paint0_linear_1780_21102" x1="-0.00732422" y1="12" x2="23.9927" y2="12" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#805AF9"></stop>
                                <stop offset="1" stop-color="#6632F8"></stop>
                            </linearGradient>
                        </defs>
                    </svg>
                    {{systemSettingsLocalization('feature_document_1_btn_text_2') ?? localize('Explore More')}}
                </a>
            </div>
        </div>
    </div>
</div>
@endif