@forelse ($plans as $package)
    @php
        $package_type = $package->package_type == appStatic()::PLAN_TYPE_STARTER ? '' : $package->package_type;
        $price = $package->discount_status && $package->discount_price ? $package->discount_price : $package->price;
    @endphp
    <div class="col-md-6 col-xl-3">
        <div class="price-item bg-white bg-opacity-5 p-8 border border-white border-opacity-5 position-relative h-100">
            <h6 class="text-primary mb-3">
                {!! html_entity_decode($package->title) !!}
            </h6>

            <h3 class="text-white mb-8 d-flex align-items-center gap-2">
                <span class="text-gradient-2 fs-14 -mt-10"></span>
                @if ($package->package_type == 'starter')
                    {{ localize('Free') }}
                @else
                    {{ $price ? formatPrice($price) : localize('Free') }}
                    <del
                        class="">{{ $package->discount_status && $package->discount_price ?  formatPrice($package->price) : '' }}</del>
                @endif
                @if ($price)
                    <span class="text-gradient-2 fs-14 fw-normal">{{ localize('per') }}
                        {{ localize(ucfirst($package_type)) }}</span>
                @endif
            </h3>


            <a class="btn border border-white border-opacity-25 px-6 fw-semibold rounded-pill d-inline-flex align-items-center gap-1 mb-10"
                href="#" role="button">
                @if ($package->package_type == 'starter')
                    {{ localize('Try For Free') }}
                @else
                    {{ localize('Subscribe Now') }}
                @endif
            </a>
            <h6 class="text-white text-opacity-75 fs-16 mb-5">
                {{ localize('Included Featured:') }}</h6>
            <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                @if ($package->show_open_ai_model != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i class="las la-check"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ openAiModelName($package->openai_model) }}</p>
                    </li>
                @endif
                @if ($package->allow_words != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_words == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_words == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium"> <strong class="me-1">
                                {{ $package->allow_unlimited_word == 1 ? localize('Unlimited') : $package->total_words_per_month }}
                            </strong>{{ localize('Words') }}</p>
                    </li>
                @endif
                @if (getSetting('enable_templates') && $package->show_templates != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_words == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_words == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium"><span class="text-black fw-bold">
                                <a href="javascript::void(0);" class="text-underline text-white"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                    onclick="getPackageTemplates($package->id)">
                                    <strong
                                        class="me-1">{{ $package->subscription_plan_templates->count() }}</strong>
                                    {{ localize('AI Templates') }}
                                </a>
                            </span></p>
                    </li>
                @endif
                @if (getSetting('enable_ai_chat') != '0' && $package->show_ai_chat != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->show_ai_chat == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_ai_chat == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium"> {{ localize('AI Chat') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_ai_chat') != '0' && $package->show_real_time_data != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->show_real_time_data == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_real_time_data == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('Chat Real Time Data') }}</p>
                    </li>
                @endif
                @if (getSetting('enable_ai_rewriter') != '0' && $package->show_ai_rewriter != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->show_ai_rewriter == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_ai_rewriter == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('AI Rewriter') }}</p>
                    </li>
                @endif
                @if (getSetting('enable_ai_vision') != '0' && $package->show_ai_vision != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_vision == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_ai_vision == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium"> {{ localize('AI Vision') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_ai_pdf_chat') != '0' && $package->show_ai_pdf_chat != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_pdf_chat == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_ai_pdf_chat == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('AI PDF Chat') }}</p>
                    </li>
                @endif
                @if (getSetting('enable_generate_code') != '0' && $package->show_ai_code != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->show_ai_code == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_ai_code == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium"> {{ localize('AI Code') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_blog_wizard') != '0' && $package->show_blog_wizard != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_blog_wizard == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_blog_wizard == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('AI Blog Wizard') }}</p>
                    </li>
                @endif
                @if (getSetting('enable_ai_plagiarism') != '0' && $package->show_ai_plagiarism)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_plagiarism == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_ai_plagiarism == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('AI Plagiarism') }}</p>
                    </li>
                @endif
                @if (getSetting('enable_ai_detector') != '0' && $package->show_ai_detector)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_detector == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_ai_detector == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('AI Detector') }}</p>
                    </li>
                @endif
                @if (getSetting('enable_ai_images') != '0' && $package->show_images != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_images == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_images == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium"><strong class="me-1">
                                {{ $package->allow_unlimited_image == 1 ? localize('Unlimited') : $package->total_images_per_month }}</strong>{{ localize('Images') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_ai_images') != '0' && $package->show_dall_e_2_image)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_dall_e_2_image == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_dall_e_2_image == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">{{ localize('Dall E 2') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_ai_images') != '0' && $package->show_dall_e_3_image)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_dall_e_3_image == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_dall_e_3_image == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">{{ localize('Dall E 3') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_ai_images') != '0' && $package->show_sd_images != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->show_sd_images == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_sd_images == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('Stable Diffusion Images') }}</p>
                    </li>
                @endif
                @if (getSetting('enable_ai_chat_image') != '0' && $package->show_ai_image_chat)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_image_chat == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_ai_image_chat == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">{{ localize('AI Image Chat') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_speech_to_text') != '0' && $package->show_speech_to_text != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_speech_to_text == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_speech_to_text == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            <strong class="me-1">
                                {{ $package->allow_unlimited_speech_to_text == 1 ? localize('Unlimited') : $package->total_speech_to_text_per_month }}</strong>{{ localize('Speech to Text') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_text_to_speech') != '0' && $package->show_text_to_speech != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_show_text_to_speech == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_show_text_to_speech == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            <strong class="me-1">
                                {{ $package->allow_unlimited_text_to_speech == 1 ? localize('Unlimited') : $package->total_text_to_speech_per_month }}</strong>{{ localize('Text to Speech') }}
                        </p>
                    </li>
                @endif
                @if ($package->show_text_to_speech_open_ai == 1)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_text_to_speech_open_ai == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_text_to_speech_open_ai == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('Open AI') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_eleven_labs') != '0' && $package->show_eleven_labs != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_eleven_labs == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_eleven_labs == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('Eleven Labs') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_google_cloud') != '0' && $package->show_google_cloud != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_google_cloud == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_google_cloud == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('Google Cloud') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_azure') != '0' && $package->show_azure != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_azure == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_azure == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('Azure') }}
                        </p>
                    </li>
                @endif
                @if (getSetting('enable_ai_video') != '0' && $package->show_ai_video != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_ai_video == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_ai_video == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium"> <strong class="me-1">
                                {{ $package->allow_unlimited_ai_video == 1 ? localize('Unlimited') : $package->total_ai_video_per_month }}
                            </strong>{{ localize('Image to Video') }}</p>
                    </li>
                @endif

                @if ($package->show_wordpress == 1)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_wordpress == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_wordpress == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('Wordpress Posts') }}
                        </p>
                    </li>
                @endif

                @if ($package->show_seo_content_optimization == 1)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_seo_content_optimization == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_seo_content_optimization == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('SEO Content Optimization') }}
                        </p>
                    </li>
                @endif
              
                @if ($package->show_team == 1)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->allow_team == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->allow_team == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
                            {{ localize('Team') }}
                        </p>
                    </li>
                @endif

                @if ($package->show_free_support != 0)
                    <li class="d-flex align-items-center gap-4">
                        <span
                            class="w-6 h-6 flex-shrink-0 {{ $package->has_free_support == 1 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <span class="text-white fs-12"><i
                                    class="{{ $package->has_free_support == 1 ? 'las la-check' : 'text-danger las la-times' }}"></i></span>
                        </span>
                        <p class="mb-0 text-body fs-14 fw-medium">
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
                                <span class="text-white fs-12"><i class="las la-check"></i></span>
                            </span>
                            <p class="mb-0 text-body fs-14 fw-medium"> {{ $feature }}
                            </p>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    @empty
        <h5 class="text-white text-center p-2">{{localize('No plans have been made yet.')}}</h5>
    @endforelse
