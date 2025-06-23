    @forelse ($packages as $package)
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
            $showInList = true;
            if(isCustomerUserGroup() && $package->package_type == 'starter'){
                $showInList = false;
            }
        @endphp
        @if ($showInList)
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
                                        {{ $price ? formatPrice($price) : localize('Free') }}
                                    </div>
                                    <del class="fs-4 ms-2 text-muted fw-medium">
                                        {{ $package->discount_status && $package->discount_price ? formatPrice($package->price) : '' }}
                                    </del>
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
                                    <li class="pb-1">
                                        <i data-feather="check" class="icon-14 me-2 text-success"></i>
                                        <strong class="me-1">{{ openAiModelName($package->openai_model) }}</strong>
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

                                @if ($package->show_total_social_platform_account)
                                    <li class="pb-1">
                                        <i data-feather="check" class="icon-14 me-2 text-success"></i>
                                        <strong class="me-1">{{  $package->total_social_platform_account_per_month }}</strong>
                                        {{ localize('Social Platform Accounts') }}
                                    </li>
                                @endif
                                @if ($package->show_total_social_platform_post)
                                    <li class="pb-1">
                                        <i data-feather="check" class="icon-14 me-2 text-success"></i>
                                        <strong class="me-1">{{  $package->total_social_platform_post_per_month }}</strong>
                                        {{ localize('Social Platform Posts') }}
                                    </li>
                                @endif

                                @if ($package->show_facebook_platform)
                                    <li class="pb-1">
                                        <i data-feather="{{ $package->allow_facebook_platform == 1 ? 'check' : 'x' }}" class="icon-14 me-2 {{ $package->allow_facebook_platform == 1 ? 'text-success' : 'text-danger' }}"></i>
                                        {{ localize('Facebook Platform') }}
                                    </li>
                                @endif
                                @if ($package->show_instagram_platform)
                                    <li class="pb-1">
                                        <i data-feather="{{ $package->allow_instagram_platform == 1 ? 'check' : 'x' }}" class="icon-14 me-2 {{ $package->allow_instagram_platform == 1 ? 'text-success' : 'text-danger' }}"></i>
                                        {{ localize('Instagram Platform') }}
                                    </li>
                                @endif
                                @if ($package->show_twitter_platform)
                                    <li class="pb-1">
                                        <i data-feather="{{ $package->allow_twitter_platform == 1 ? 'check' : 'x' }}" class="icon-14 me-2 {{ $package->allow_twitter_platform == 1 ? 'text-success' : 'text-danger' }}"></i>
                                        {{ localize('Twitter Platform') }}
                                    </li>
                                @endif
                                @if ($package->show_linkedin_platform)
                                    <li class="pb-1">
                                        <i data-feather="{{ $package->allow_linkedin_platform == 1 ? 'check' : 'x' }}" class="icon-14 me-2 {{ $package->allow_linkedin_platform == 1 ? 'text-success' : 'text-danger' }}"></i>
                                        {{ localize('LinkedIn Platform') }}
                                    </li>
                                @endif

                                @if ($package->show_schedule_posting)
                                    <li class="pb-1">
                                        <i data-feather="{{ $package->allow_schedule_posting == 1 ? 'check' : 'x' }}" class="icon-14 me-2 {{ $package->allow_schedule_posting == 1 ? 'text-success' : 'text-danger' }}"></i>
                                        {{ localize('Schedule Posting') }}
                                    </li>
                                @endif
                                @if ($package->show_ai_assistant)
                                    <li class="pb-1">
                                        <i data-feather="{{ $package->allow_ai_assistant == 1 ? 'check' : 'x' }}" class="icon-14 me-2 {{ $package->allow_ai_assistant == 1 ? 'text-success' : 'text-danger' }}"></i>
                                        {{ localize('AI Assistant') }}
                                    </li>
                                @endif

                                @if ($package->show_seo || $package->allow_seo)
                                    <li class="pb-1">
                                        <i data-feather="{{ $package->allow_seo == 1 ? 'check' : 'x' }}"
                                        class="icon-14 me-2 {{ $package->allow_seo == 1 ? 'text-success' : 'text-danger' }}"></i><strong
                                                class="me-1">
                                            {{  $package->total_seo_balance_per_month }}
                                        </strong>{{ localize('SEO Credit') }}
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

                                @if (getSetting('enable_ai_writer') != '0' && $package->show_ai_writer != 0)
                                    <li class="pb-1">
                                        <i data-feather="{{ $package->allow_ai_writer ? 'check' : 'x' }}"
                                            class="icon-14 me-2 {{ $package->allow_ai_writer ? 'text-success' : 'text-danger' }}"></i>{{ localize('AI Writer') }}
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
                                @endif
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

                                @if (getSetting('enable_ai_video') != '0' && $package->show_ai_video != 0)
                                    <li class="pb-1">
                                        <i data-feather="{{ $package->allow_ai_video ? 'check' : 'x' }}"
                                            class="icon-14 me-2  {{ $package->allow_ai_video == 1 ? 'text-success' : 'text-danger' }}"></i><strong
                                            class="me-1">
                                            {{ $package->allow_unlimited_ai_video == 1 ? localize('Unlimited') : $package->total_ai_video_per_month }}</strong>{{ localize('AI Video') }}
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

                    @if (isCustomerUserGroup())
                        <div class="mt-auto d-flex align-items-center gap-2 px-4">
                            <button class="btn btn-block btn-sm w-100 mb-4 {{ $package->is_featured == 1 ? 'btn-primary' : 'btn-outline-primary' }}"
                                data-package-id="{{ $package->id }}" data-price="{{ $package->price }}"
                                data-package-type="{{ $package->package_type }}"
                                data-previous-package-type="{{ $package->package_type }}"
                                data-user-type="{{ auth()->check() ? appStatic()::USER_TYPES[user()->user_type] : 'unauthorized' }}"
                                onclick="handlePackagePayment(this)">
                                {{ user()->subscription_plan_id == $package->id ? localize('Renew Now') : localize('Subscribe Now') }}
                            </button>
                        </div>
                    @endif


                    @if (isAdmin())
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    @include('common.active-status-button', [
                                        'active' => $package->is_active,
                                        'id'     => encrypt($package->id),
                                        'model'  => 'subscription_plan',
                                        'name'   => 'is_active_'.$package->id,
                                    ])
                                    <span class="ms-1"><label for="is_active_{{$package->id}}"
                                            class="cursor-pointer">{{ localize('Is Active?') }}</label>  @if ($package->package_type == 'starter')<span data-feather="alert-triangle" class="icon-14 text-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ localize('If active, this will be applied to new user\'s registration.') }}"></span>
                                        @endif</span>
                                </div>


                                <div>
                                    @if (isAdmin())
                                        <button class="btn-sm p-1 bg-transparent border-0 edit-package"
                                            data-id="{{ $package->id }}"
                                            id="editPackage_{{ $package->id }}"
                                            data-url="{{ route('admin.subscription-plans.edit', $package->id) }}"
                                            data-update-url="{{ route('admin.subscription-plans.update', $package->id) }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            
                                            >
                                            <span data-feather="edit" class="icon-16" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Edit this plan') }}"></span>
                                        </button>
                                    @endif

                                    @if ($package->package_type != 'starter' && isAdmin())
                                        <a href="#" data-id="{{ $package->id }}"
                                            data-href="{{ route('admin.subscription-plans.destroy', $package->id) }}"
                                            data-method="DELETE" class="erase btn-sm p-1 bg-transparent border-0"
                                            type="button"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            >
                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Delete this plan') }}" class="text-danger ms-1"><i data-feather="trash-2"
                                                    class="icon-16"></i></span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @empty
        <div class="text-center w-100">
            <x-common.empty-div />
        </div>
    @endforelse


@include("common.modal.package-payment-modal")
