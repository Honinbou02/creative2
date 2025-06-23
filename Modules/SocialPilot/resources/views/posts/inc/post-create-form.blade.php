
<div class="content-generator__body">
    <div class="content-generator__body-header p-3 border-bottom">
        <h5 class="mb-0">
            {{ localize('Post Details') }}
        </h5>
    </div>
    <div class="content-generator__body-content d-flex flex-column h-100">
        <div class="tt-custom-scrollbar overflow-y-auto tt-screen-height">
            <div class="border-bottom position-relative">
                <span class="nav-line-tab-left-arrow text-center cursor-pointer ms-2">
                    <i data-feather="chevron-left" class="icon-16"></i>
                </span>
                <ul class="nav nav-line-tab c_post fw-medium px-3">
                    @foreach ($platforms as $platform)
                        @if (hasPlatformAccess($platform))
                            <li class="nav-item">
                                <a href="#{{ $platform->slug }}" class="d-flex align-items-center nav-link {{ $activeBy == "platform" ? ($platform->id == $articleSocialPost?->platform_id ? 'active': '') : ($loop->first ? 'active' : '') }}" data-bs-toggle="tab" aria-selected="true">
                                    <span>
                                        <img src="{{ mediaImage($platform->icon_media_manager_id) }}" alt="{{ $platform->name }}" class="rounded rounded-circle" width="30" >
                                    </span>
                                    <span class="ms-0">{{ $platform->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach 
                </ul>
                <span class="nav-line-tab-right-arrow text-center cursor-pointer me-2">
                    <i data-feather="chevron-right" class="icon-16"></i>
                </span>
            </div>

            <!-- Tab Content -->
            <div class="card-body">
                <div class="tab-content">
                    <!-- platform Tab -->
                    @foreach ($platforms as $platform)
                        @if (hasPlatformAccess($platform))
                            <div class="tab-pane fade {{ $activeBy == "platform" ? ($platform->id == $articleSocialPost?->platform_id ? 'show active': '') : ($loop->first ? 'show active' : '') }}" id="{{ $platform->slug }}">
                                <div class="form-input mb-3">
                                    <ul class="list-unstyled d-flex flex-wrap gap-2 mb-1 tt-radio-check">
                                        <li class="form-check">
                                            <input class="form-check-input" type="radio" value="{{ appStatic()::POST_TYPES['FEED'] }}" name="{{ $platform->slug }}_post_type" id="{{ $platform->slug }}_feed" checked>
                                            <label class="form-check-label cursor-pointer" for="{{ $platform->slug }}_feed">
                                                {{ localize('Feed') }}
                                            </label>
                                        </li> 
                                        
                                        @if ($platform->slug == appStatic()::PLATFORM_FACEBOOK || $platform->slug == appStatic()::PLATFORM_INSTAGRAM)
                                            <li class="form-check">
                                                <input class="form-check-input" type="radio"  value="{{ appStatic()::POST_TYPES['REEL'] }}" name="{{ $platform->slug }}_post_type" id="{{ $platform->slug }}_reel">
                                                <label class="form-check-label cursor-pointer" for="{{ $platform->slug }}_reel">
                                                    {{ localize('Reel') }}
                                                </label>
                                            </li>
                                        @endif

                                        @if ($platform->slug == appStatic()::PLATFORM_INSTAGRAM)
                                            <li class="form-check">
                                                <input class="form-check-input" type="radio" value="{{ appStatic()::POST_TYPES['STORY'] }}" name="{{ $platform->slug }}_post_type" id="{{ $platform->slug }}_story">
                                                <label class="form-check-label cursor-pointer" for="{{ $platform->slug }}_story">
                                                    {{ localize('Story') }}
                                                </label>
                                            </li>
                                        @endif
                                    </ul>
                                    {{-- compose --}}
                                    <div class="mt-3">
                                        <label class="text-primary fw-medium form-check-label cursor-pointer" for="{{ $platform->slug }}_post_details">
                                            <span><i data-feather="edit" class="icon-14"></i></span><span class="ms-1">
                                                @if ($platform->slug == appStatic()::PLATFORM_FACEBOOK || $platform->slug == appStatic()::PLATFORM_INSTAGRAM)
                                                    {{ localize("What's on your mind?") }}
                                                @elseif ($platform->slug == appStatic()::PLATFORM_TWITTER)
                                                    {{ localize("What is happening?!") }} 
                                                @elseif($platform->slug == appStatic()::PLATFORM_LINKEDIN)
                                                    {{ localize("What do you want to talk about?") }}
                                                @endif
                                            </span>
                                        </label>
                                        <textarea name="{{ $platform->slug }}_post_details" class="compose-input form-control bg-secondary-subtle create-post-input mt-3" id="{{ $platform->slug }}_post_details" rows="10" placeholder="Start writing post caption" required>{{ $articleSocialPost?->post_details }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div class="form_bottom d-flex align-items-center gap-1 mb-3"> 
                        <!-- Quick Text Dropdown -->
                        <div class="dropdown tt-tb-dropdown dropup me-2">
                            <button type="button" class="btn btn-secondary btn-sm rounded-pill flex-shrink-0 me-2" data-bs-toggle="dropdown" aria-expanded="true">
                                <i data-feather="file-text" class="icon-14"></i> {{ localize('Quick Text') }}
                            </button>
                            <div class="dropdown-menu shadow-lg">
                                {{-- todo:: max height and scroll --}}
                                @foreach ($quickTexts as $quickText)
                                    <a class="dropdown-item quickTextClickBtn" href="javascript:void(0);" data-text="{{$quickText->description}}">
                                        {{ $quickText->title}}
                                    </a>
                                @endforeach
                            </div>
                        </div> 
                        @if ((isCustomerUserGroup() && allowPlanFeature('allow_ai_assistant')) || isAdminUserGroup()) 
                            <button type="button" class="btn btn-secondary btn-sm rounded-pill flex-shrink-0 ai-assistant-btn" data-bs-toggle="offcanvas" data-bs-target="#generateContentFromSidebar">
                                <i data-feather="aperture" class="icon-14"></i> {{ localize('AI Assistant') }}
                            </button>
                        @endif 
                    </div>

                    
                    <!-- Add Media -->
                    <a href="javascript:void(0);" class="text-primary fw-medium">
                        <span><i data-feather="image" class="icon-14"></i></span>
                        {{ localize('Add Media') }}
                    </a>
                    
                    <!-- choose media -->
                    <div class="tt-image-drop rounded mt-2">
                        <span class="fw-semibold">{{ localize('Choose Media Files') }}</span>
                        <div class="tt-product-thumb show-selected-files mt-3 d-flex align-items-center justify-content-center gap-2">
                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                onclick="showMediaManager(this)" data-selection="multiple">
                                <input type="hidden" name="media_manager_ids" id="social-post-media" value="">
                                <div class="no-avatar rounded-circle">
                                    <span><i data-feather="plus"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- choose media --> 

                    <!-- External Link -->
                    <div class="mt-4">
                        <a href="javascript:void(0);" class="text-primary fw-medium">
                            <span><i data-feather="link" class="icon-14"></i></span>
                            {{ localize('External Link (Optional)') }}
                        </a>

                        <x-form.input class="mt-3" id="external_link" name="external_link" type="url" placeholder="{{ localize('Type the url you want to include in the post') }}" showDiv=false />
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Sidebar Footer -->
        <div class="content-generator__sidebar-footer mt-auto">
            <div class="d-flex align-items-center gap-3 justify-content-end flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    {{-- schedule btn --}}
                    @if (isAdminUserGroup() || allowPlanFeature('allow_ai_assistant'))
                        <div class="schedule-picker d-flex align-items-center">
                            <a class="btn btn-sm w-100 px-3 btn-outline-primary d-flex align-items-center justify-content-center me-2" data-toggle>
                                <i data-feather="clock" class="icon-12 me-1"></i> {{ localize('Schedule Post') }}
                            </a>
                            <input class="form-control form-control-sm rounded py-2 me-2 schedule-picker-input visually-hidden" name="schedule_time" type="text" placeholder="Schedule Post" data-input>

                            <a class="btn btn-sm btn-icon btn-danger d-flex align-items-center justify-content-center date-picker-clear-btn d-none" title="clear" data-clear>
                                <i data-feather="x" class="icon-14"></i>
                            </a>
                        </div>
                    @endif
                    {{-- schedule btn end --}}
                    
                    <button type="submit" class="btn btn-primary btn-sm" id="publishNowBtn"><i data-feather="send" class="icon-14 me-1"></i> {{ localize('Post') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>