<section class="pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="text-center mb-40">
                    <div class="d-inline-block text-center px-5 py-1 rounded-pill border border-1 border-primary mb-4">
                        <p class="fs-14 fw-normal mb-0">{{ localize('Pricing Plans') }}</p>
                    </div>

                    <h2 class="fs-48 mb-0">{{ localize('Flexible Pricing That Suits Your Needs') }}</h2>
                </div>
            </div>
        </div>
        <div class="tab-nav d-flex justify-content-center">
            <ul class="nav nav-pills d-inline-flex justify-content-center align-items-center gap-1 wt_card_style_nhover rounded-pill px-3 py-2"
                id="myTab2" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#" class="nav-link text-body fw-normal px-4 py-1 rounded-pill  planType active" data-type="{{appStatic()::PLAN_TYPE_MONTHLY}}"
                        data-bs-toggle="pill" data-bs-target="#price-1" type="button" role="tab"
                        aria-selected="true">
                        <span>
                            {{ localize('Monthly') }}
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#" class="nav-link text-body fw-normal px-4 py-1 rounded-pill planType" data-type="{{appStatic()::PLAN_TYPE_YEARLY}}" data-bs-toggle="pill"
                        data-bs-target="#price-2" type="button" role="tab" aria-selected="true">
                        <span>
                            {{ localize('Yearly') }}
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#" class="nav-link text-body fw-normal px-4 py-1 rounded-pill planType" data-type="{{appStatic()::PLAN_TYPE_LIFETIME}}" data-bs-toggle="pill"
                        data-bs-target="#price-3" type="button" role="tab" aria-selected="true">
                        <span>
                            {{ localize('Lifetime') }}
                        </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#" class="nav-link text-body fw-normal px-4 py-1 rounded-pill planType" data-type="{{appStatic()::PLAN_TYPE_PREPAID}}" data-bs-toggle="pill"
                        data-bs-target="#price-4" type="button" role="tab" aria-selected="true">
                        <span>
                            {{ localize('Prepaid') }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content mt-10" id="myTabContent2">
            <div class="tab-pane fade active show" id="price-1" role="tabpanel">
                <div class="row justify-content-center overflow-hidden mb-3 g-0 g-x-0" id="plan-list">
                    @foreach ($plans as $package)
                        @php
                            $package_type = $package->package_type == appStatic()::PLAN_TYPE_STARTER ? '' : $package->package_type;
                            $price =
                                $package->discount_status && $package->discount_price
                                    ? $package->discount_price
                                    : $package->price;
                        @endphp
                        <div class="col-md-6 col-xl-3">
                            <div
                                class="price-item bg-white bg-opacity-5 p-8 border border-white border-opacity-5 position-relative h-100">
                                @if ($package->is_featured == 1)
                                    <div class="discount-badge bg-gradient-1"><i class="las la-check"></i></div>
                                @endif
                                <h6 class="text-gradient-2 mb-3"> <?= html_entity_decode($package->title) ?> </h6>
                                <small class="text-body mb-4 d-inline-block"> {!! html_entity_decode($package->description) !!} </small>
                                <h3 class="text-body mb-8 d-flex align-items-center gap-2">
                                    <span class="text-gradient-2 fs-14 -mt-10"></span>
                                    @if ($package->package_type == 'starter')
                                            {{ localize('Free') }}
                                    @else
                                            {{ $price ? formatPrice($price) : localize('Free') }}
                                        <del class="">
                                            {{ $package->discount_status && $package->discount_price ? formatPrice($package->price) : '' }}
                                        </del>
                                    @endif

                                    @if($price)
                                        <span class="text-gradient-2 fs-14 fw-normal">
                                            {{ localize('per') }} {{ localize(ucfirst($package_type)) }}
                                        </span>
                                    @endif
                                </h3>


                                <button type="button"
                                        class="btn border border-white border-opacity-25 px-3 py-2 fw-normal rounded-pill d-inline-flex align-items-center gap-3 mb-10"
                                        data-package-id="{{ $package->id }}" data-price="{{ $package->price }}"
                                        data-package-type="{{ $package->package_type }}"
                                        data-previous-package-type="{{ $package->package_type }}"
                                        data-user-type="{{ isLoggedIn() ? appStatic()::USER_TYPES[user()->user_type] : 'unauthorized' }}"
                                        onclick="handlePackagePayment(this)"
                                   @if(isLoggedIn())
                                       role="button"
                                   @endif
                                >
                                    @if ($package->package_type == 'starter')
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="0.5" width="24" height="24" rx="12" fill="white"/>
                                        <path d="M6.43862 12.1525C6.43862 12.1525 12.4477 12.1525 17.8672 12.1525M17.8672 12.1525C13.9522 12.1525 13.2295 8.15253 13.2295 8.15253M17.8672 12.1525C13.9522 12.1525 13.2295 16.1525 13.2295 16.1525" stroke="#553BF9" stroke-width="1.1"/>
                                        </svg> {{ localize('Try For Free') }}
                                    @else
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.5" width="24" height="24" rx="12" fill="white"/>
                                    <path d="M6.43862 12.1525C6.43862 12.1525 12.4477 12.1525 17.8672 12.1525M17.8672 12.1525C13.9522 12.1525 13.2295 8.15253 13.2295 8.15253M17.8672 12.1525C13.9522 12.1525 13.2295 16.1525 13.2295 16.1525" stroke="#553BF9" stroke-width="1.1"/>
                                    </svg>
                                        {{ localize('Subscribe Now') }}
                                    @endif
                                </button>

                                <h6 class="text-heading fs-16 mb-5">
                                    {{ localize('Included Featured:') }}</h6>
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                                    @if ($package->show_open_ai_model != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i class="las la-check"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ openAiModelName($package->openai_model) }}</p>
                                        </li>
                                    @endif
                                    @if ($package->allow_words != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_words == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_words == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal"> <strong class="me-1">
                                                    {{ $package->allow_unlimited_word == 1 ? localize('Unlimited') : $package->total_words_per_month }}
                                                </strong>{{ localize('Words') }}</p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_templates') && $package->show_templates != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_words == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_words == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal"><span>
                                                    <span  class="text-decoration-none text-body">
                                                        <strong
                                                            class="fw-normal">{{ $package->subscription_plan_templates->count() }}</strong>
                                                        {{ localize('AI Templates') }}
                                                    </span>
                                                </span></p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_chat') != '0' && $package->show_ai_chat != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->show_ai_chat == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_ai_chat == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal"> {{ localize('AI Chat') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_chat') != '0' && $package->show_real_time_data != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->show_real_time_data == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_real_time_data == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Chat Real Time Data') }}</p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_rewriter') != '0' && $package->show_ai_rewriter != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->show_ai_rewriter == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_ai_rewriter == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('AI Rewriter') }}</p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_vision') != '0' && $package->show_ai_vision != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_vision == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_ai_vision == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal"> {{ localize('AI Vision') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_pdf_chat') != '0' && $package->show_ai_pdf_chat != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_pdf_chat == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_ai_pdf_chat == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('AI PDF Chat') }}</p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_generate_code') != '0' && $package->show_ai_code != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->show_ai_code == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_ai_code == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal"> {{ localize('AI Code') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_blog_wizard') != '0' && $package->show_blog_wizard != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_blog_wizard == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_blog_wizard == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('AI Blog Wizard') }}</p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_plagiarism') != '0' && $package->show_ai_plagiarism)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_plagiarism == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_ai_plagiarism == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('AI Plagiarism') }}</p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_detector') != '0' && $package->show_ai_detector)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_detector == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_ai_detector == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('AI Detector') }}</p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_images') != '0' && $package->show_images != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_images == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_images == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal"><strong class="me-1">
                                                    {{ $package->allow_unlimited_image == 1 ? localize('Unlimited') : $package->total_images_per_month }}</strong>{{ localize('Images') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_images') != '0' && $package->show_dall_e_2_image)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_dall_e_2_image == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_dall_e_2_image == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">{{ localize('Dall E 2') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_images') != '0' && $package->show_dall_e_3_image)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_dall_e_3_image == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_dall_e_3_image == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">{{ localize('Dall E 3') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_images') != '0' && $package->show_sd_images != 0)
                                    <li class="d-flex align-items-center gap-4">
                                        <span
                                            class="w-6 h-6 flex-shrink-0 {{ $package->show_sd_images == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                            <span class="text-body fs-12"><i
                                                    class="{{ $package->allow_sd_images == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                        </span>
                                        <p class="mb-0 text-body fs-14 fw-normal">
                                            {{ localize('Stable Diffusion Images') }}</p>
                                    </li>
                                @endif
                                    @if (getSetting('enable_ai_chat_image') != '0' && $package->show_ai_image_chat)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_image_chat == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_ai_image_chat == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">{{ localize('AI Image Chat') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_speech_to_text') != '0' && $package->show_speech_to_text != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_speech_to_text == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_speech_to_text == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                <strong class="me-1">
                                                    {{ $package->allow_unlimited_speech_to_text == 1 ? localize('Unlimited') : $package->total_speech_to_text_per_month }}</strong>{{ localize('Speech to Text') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_text_to_speech') != '0' && $package->show_text_to_speech != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_show_text_to_speech == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_show_text_to_speech == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                <strong class="me-1">
                                                    {{ $package->allow_unlimited_text_to_speech == 1 ? localize('Unlimited') : $package->total_text_to_speech_per_month }}</strong>{{ localize('Text to Speech') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if ($package->show_text_to_speech_open_ai == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_text_to_speech_open_ai == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_text_to_speech_open_ai == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Open AI') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_eleven_labs') != '0' && $package->show_eleven_labs != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_eleven_labs == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_eleven_labs == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Eleven Labs') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_google_cloud') != '0' && $package->show_google_cloud != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_google_cloud == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_google_cloud == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Google Cloud') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_azure') != '0' && $package->show_azure != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_azure == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_azure == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Azure') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if (getSetting('enable_ai_video') != '0' && $package->show_ai_video != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_video == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_ai_video == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal"> <strong class="me-1">
                                                    {{ $package->allow_unlimited_ai_video == 1 ? localize('Unlimited') : $package->total_ai_video_per_month }}
                                                </strong>{{ localize('Image to Video') }}</p>
                                        </li>
                                    @endif

                                    @if ($package->show_wordpress == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_wordpress == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_wordpress == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Wordpress Posts') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if ($package->show_seo_content_optimization == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_seo_content_optimization == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_seo_content_optimization == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('SEO Content Optimization') }}
                                            </p>
                                        </li>
                                    @endif
                                        
                                    {{-- ======================================== --}}
                                    {{-- todo::shohan - check/times icon based on condition --}}
                                    @if ($package->show_total_social_platform_account == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="las la-check"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{  $package->total_social_platform_account_per_month ?? 0 }} {{ localize('Social Platform Accounts') }}
                                            </p>
                                        </li> 
                                    @endif

                                    @if ($package->show_total_social_platform_post == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="las la-check"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{  $package->total_social_platform_post_per_month ?? 0 }} {{ localize('Social Platform Posts') }}
                                            </p>
                                        </li> 
                                    @endif

                                    @if ($package->show_facebook_platform == 1 && $package->allow_facebook_platform == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="las la-check"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Facebook Platform Access') }}
                                            </p>
                                        </li>
                                    @endif

                                    @if ($package->show_instagram_platform == 1 && $package->allow_instagram_platform == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="las la-check"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Instagram Platform Access') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if ($package->show_twitter_platform == 1 && $package->allow_twitter_platform == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="las la-check"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Twitter Platform Access') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if ($package->show_linkedin_platform == 1 && $package->allow_linkedin_platform == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="las la-check"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('LinkedIn Platform Access') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if ($package->show_schedule_posting == 1 && $package->allow_schedule_posting == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="las la-check"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Schedule Posting') }}
                                            </p>
                                        </li>
                                    @endif
                                    @if ($package->show_ai_assistant == 1 && $package->allow_ai_assistant == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="las la-check"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('AI Assistant') }}
                                            </p>
                                        </li> 
                                    @endif
                                    {{-- ======================================== --}}

                                    @if ($package->show_team == 1)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->allow_team == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->allow_team == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Team') }}
                                            </p>
                                        </li>
                                    @endif

                                    @if ($package->show_free_support != 0)
                                        <li class="d-flex align-items-center gap-4">
                                            <span
                                                class="w-6 h-6 flex-shrink-0 {{ $package->has_free_support == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-body fs-12"><i
                                                        class="{{ $package->has_free_support == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                                            </span>
                                            <p class="mb-0 text-body fs-14 fw-normal">
                                                {{ localize('Free  Support') }}</p>
                                        </li>
                                    @endif
                                    @php
                                        $otherFeatures = explode(',', $package->other_features);
                                    @endphp
                                    @if ($package->other_features)
                                        @foreach ($otherFeatures as $feature)
                                            <li class="d-flex align-items-center gap-4">
                                                <span
                                                    class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                    <span class="text-body fs-12"><i
                                                            class="las la-check"></i></span>
                                                </span>
                                                <p class="mb-0 text-body fs-14 fw-normal"> {{ $feature }}
                                                </p>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>