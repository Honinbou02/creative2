@php
if( $package->discount_status && $package->discount_price) {
    $price = $package->discount_price;
}elseif(($package->discount_status && $package->discount_price == 0) ) {
    $price = null;
}elseif(($package->discount_status && $package->discount_price) && $package->price < $package->discount_price) {
    $price = null;
}else{
    $price = $package->price;
}
@endphp
<div class="col mb-3" id="{{$package->id}}">
    <div class="card h-100 rounded-0 package-card">
        <div class="card-body py-5">
            <div class="tt-pricing-plan text-center">
                <div class="tt-plan-name">
                    <h5 class="mb-3 text-uppercase"> {!! html_entity_decode($package->title) !!}</h5>
                </div>
                <div class="tt-price-wrap d-flex justify-content-center @if ($package->is_featured == 1) text-primary @endif">
                    @if ($package->package_type == 'starter')
                        <div class="fs-1 fw-bold lh-1">
                            {{ localize('Free') }}
                        </div>
                        
                    @else
                        <div class="fs-1 fw-bold lh-1">
                            {{ $price ? '$'. $price : localize('Free') }}
                        </div>
                        <del
                            class="fs-4 ms-2 text-muted fw-medium">{{ $package->discount_status && $package->discount_price ? '$' . $package->price : '' }}</del>
                    @endif
                </div>
                <p class="text-muted fs-sm">{!! html_entity_decode($package->description) !!}</p>

            </div>
            @if ($package->is_featured == 1)
                <div class="tt-featured-badge"></div>
            @endif

            <div class="tt-pricing-feature pt-3">
                <ul class="tt-pricing-feature list-unstyled rounded mb-0">
                    @if($package->show_open_ai_model !=0)
                    <li class="pb-1"><i data-feather="check" class="icon-14 me-2 text-success"></i><strong
                            class="me-1">{{ openAiModelName($package->openai_model) }}</strong>
                    </li>
                    @endif
                    @if (getSetting('enable_templates') && $package->show_templates !=0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_templates == 1 ? 'check' : 'x' }}" class="icon-14 me-2 {{ $package->allow_templates == 1 ? 'text-success' : 'text-danger' }}"></i>
                            <a href="javascript::void(0);" class="text-underline text-dark" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" onclick="getPackageTemplates({{$package->id}}, 'from-list')">
                                <strong class="me-1">{{ $package->subscription_plan_templates->count() }}</strong>
                                {{ localize('AI Templates') }}
                            </a>
                        </li>
                    @endif
                    @if ($package->allow_words != 0 && $package->show_words !=0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_words == 1 ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_words == 1 ? 'text-success' : 'text-danger' }}"></i><strong
                                class="me-1">
                                {{ $package->allow_unlimited_word == 1 ? localize('Unlimited') : $package->total_words_per_month }}
                            </strong>{{ localize('Words') }} 
                        </li>
                    @endif
                    @if (getSetting('enable_ai_images') != '0' && $package->show_images != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_images == 1 || $package->allow_sd_images == 1 ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_images == 1 || $package->allow_sd_images == 1 ? 'text-success' : 'text-danger' }}"></i><strong
                                class="me-1">
                                {{ $package->allow_unlimited_image == 1 ? localize('Unlimited') : $package->total_images_per_month }}</strong>{{ localize('Images') }}
                        </li>
                    @endif
                    @if (getSetting('enable_speech_to_text') != '0' && $package->show_speech_to_text != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_speech_to_text ? 'check' : 'x' }}"
                                class="icon-14 me-2  {{ $package->allow_speech_to_text == 1 ? 'text-success' : 'text-danger' }}"></i><strong
                                class="me-1">
                                {{ $package->allow_unlimited_speech_to_text == 1 ? localize('Unlimited') : $package->total_speech_to_text_per_month }}</strong>{{ localize('Speech to Text') }}
                       
                            </li>
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_speech_to_text ? 'check' : 'x' }}" class="icon-14 me-2 {{ $package->allow_speech_to_text == 1 ? 'text-success' : 'text-danger' }}"></i><strong
                                class="me-1">{{ $package->speech_to_text_filesize_limit }}
                                MB</strong>{{ localize('Audio file size limit') }}
                        </li>
                    @endif
                    @if (getSetting('enable_ai_chat') != '0' && $package->show_ai_chat != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_ai_chat ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_ai_chat ? 'text-success' : 'text-danger' }}"></i>{{ localize('AI Chat') }}
                        </li>
                    @endif
                    @if (getSetting('enable_ai_chat') != '0' && $package->show_real_time_data != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_real_time_data ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_real_time_data ? 'text-success' : 'text-danger' }}"></i>{{ localize('Chat Real Time Data') }}
                        </li>
                    @endif
                    @if (getSetting('enable_ai_rewriter') != '0' && $package->show_ai_rewriter != 0)
                    <li class="pb-1">
                        <i data-feather="{{ $package->allow_ai_rewriter ? 'check' : 'x' }}"
                            class="icon-14 me-2 {{ $package->allow_ai_rewriter ? 'text-success' : 'text-danger' }}"></i>{{ localize('AI Rewriter') }}
                    </li>
                @endif
                    @if (getSetting('enable_ai_vision') != '0' && $package->show_ai_vision != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_ai_vision ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_ai_vision ? 'text-success' : 'text-danger' }}"></i>{{ localize('AI Vision') }}
                        </li>
                    @endif

                    @if (getSetting('enable_ai_pdf_chat') != '0' && $package->show_ai_pdf_chat != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_ai_pdf_chat ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_ai_pdf_chat ? 'text-success' : 'text-danger' }}"></i>{{ localize('AI PDF Chat') }}
                        </li>
                    @endif
                    @if (getSetting('enable_generate_code') != '0' && $package->show_ai_code != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_ai_code ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_ai_code ? 'text-success' : 'text-danger' }}"></i>{{ localize('AI Code') }}
                        </li>
                    @endif
                    @if (getSetting('enable_ai_blog_wizard') != '0' && $package->show_blog_wizard != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_blog_wizard ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_blog_wizard ? 'text-success' : 'text-danger' }}"></i>{{ localize('AI Blog Wizard') }}
                        </li>
                    @endif
                    @if (getSetting('enable_ai_plagiarism') != '0' && $package->show_ai_plagiarism)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_ai_plagiarism ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_ai_plagiarism ? 'text-success' : 'text-danger' }}"></i>
                            {{ localize('AI Plagiarism') }}
                        </li>
                    @endif
                    @if (getSetting('enable_ai_detector') != '0' && $package->show_ai_detector)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_ai_detector ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_ai_detector ? 'text-success' : 'text-danger' }}"></i>
                            {{ localize('AI Detector') }}
                        </li>
                    @endif

                    @if (getSetting('enable_ai_images') != '0' && $package->show_images != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_images ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_images ? 'text-success' : 'text-danger' }}"></i>{{ localize('AI  Images') }}
                        </li>
                    @endif
                    @if (getSetting('enable_ai_images') != '0' && $package->show_sd_images != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_sd_images ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_sd_images ? 'text-success' : 'text-danger' }}"></i>{{ localize('Stable Diffusion Images') }}
                        </li>
                        @endif
                    @if (getSetting('enable_ai_images') != '0' && $package->show_dall_e_2_image != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_dall_e_2_image ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_dall_e_2_image ? 'text-success' : 'text-danger' }}"></i>{{ localize('Dall E 2') }}
                        </li>
                    @endif
                    @if (getSetting('enable_ai_images') != '0' && $package->show_dall_e_3_image != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_dall_e_3_image ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_dall_e_3_image ? 'text-success' : 'text-danger' }}"></i>{{ localize('Dall E 3') }}
                        </li>
                    @endif
                    @if (getSetting('enable_ai_chat_image') != '0' && $package->show_ai_image_chat != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_ai_image_chat ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_ai_image_chat ? 'text-success' : 'text-danger' }}"></i>{{ localize('Chat Image') }}
                        </li>
                    @endif
                   
                   
                    @if (getSetting('enable_text_to_speech') != '0' && $package->show_text_to_speech != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_text_to_speech ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_text_to_speech ? 'text-success' : 'text-danger' }}"></i><strong
                                class="me-1">
                                {{ $package->allow_unlimited_text_to_speech == 1 ? localize('Unlimited') : $package->total_text_to_speech_per_month }}</strong>{{ localize('Text To Speech') }}
                        </li>
                        @if($package->show_text_to_speech_open_ai !=0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_text_to_speech_open_ai ? 'check' : 'x' }}"
                                class="icon-14 me-2 {{ $package->allow_text_to_speech_open_ai ? 'text-success' : 'text-danger' }}"></i>{{ localize('Open AI') }}
                        </li>
                        @endif
                        @if (getSetting('enable_eleven_labs') != '0' && $package->show_eleven_labs !=0)
                            <li class="pb-1">
                                <i data-feather="{{ $package->allow_eleven_labs ? 'check' : 'x' }}"
                                    class="icon-14 me-2 {{ $package->allow_eleven_labs ? 'text-success' : 'text-danger' }}"></i>{{ localize('Eleven Labs') }}
                            </li>
                        @endif
                        @if (getSetting('enable_google_cloud') != '0' && $package->show_google_cloud !=0)
                            <li class="pb-1">
                                <i data-feather="{{ $package->allow_google_cloud ? 'check' : 'x' }}"
                                    class="icon-14 me-2 {{ $package->allow_google_cloud ? 'text-success' : 'text-danger' }}"></i>{{ localize('Google Cloud') }}
                            </li>
                        @endif
                        @if (getSetting('enable_azure') != '0' && $package->show_azure !=0)
                            <li class="pb-1">
                                <i data-feather="{{ $package->allow_azure ? 'check' : 'x' }}"
                                    class="icon-14 me-2 {{ $package->allow_azure ? 'text-success' : 'text-danger' }}"></i>{{ localize('Azure') }}
                            </li>
                        @endif
                    @endif
                   
                    @if (getSetting('enable_ai_video') != '0' && $package->show_ai_video != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_ai_video ? 'check' : 'x' }}"
                                class="icon-14 me-2  {{ $package->allow_ai_video == 1 ? 'text-success' : 'text-danger' }}"></i><strong
                                class="me-1">
                                {{ $package->allow_unlimited_ai_video == 1 ? localize('Unlimited') : $package->total_ai_video_per_month }}</strong>{{ localize('AI Vedio') }}
                       
                          
                            
                        </li>
                    @endif

                    @if ($package->show_wordpress != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_wordpress ? 'check' : 'x' }}"
                                class="icon-14 me-2  {{ $package->allow_wordpress ? 'text-success' : 'text-danger' }}"></i>{{ localize('Wordpress Posts') }}
                        </li>
                    @endif
                    @if ($package->show_seo_content_optimization != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_seo_content_optimization ? 'check' : 'x' }}"
                                class="icon-14 me-2  {{ $package->allow_seo_content_optimization ? 'text-success' : 'text-danger' }}"></i>{{ localize('SEO Contents Optimization') }}
                        </li>
                    @endif
                    @if ($package->show_team != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->allow_team ? 'check' : 'x' }}"
                                class="icon-14 me-2  {{ $package->allow_team ? 'text-success' : 'text-danger' }}"></i>{{ localize('Team') }}
                        </li>
                    @endif
                    @if ($package->show_free_support != 0)
                        <li class="pb-1">
                            <i data-feather="{{ $package->has_free_support ? 'check' : 'x' }}"
                                class="icon-14 me-2  {{ $package->has_free_support ? 'text-success' : 'text-danger' }}"></i>{{ localize('Free  Support') }}
                        </li>
                    @endif
                    @php
                        $otherFeatures = explode(',', $package->other_features);
                    @endphp
                    @if ($package->other_features)
                        @foreach ($otherFeatures as $feature)
                            <li class="pb-1"><i data-feather="check"
                                    class="icon-14 me-2 text-success"></i>{{ $feature }}
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

        </div>       
    </div>
</div>