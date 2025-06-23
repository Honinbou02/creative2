
<div class="content-generator__sidebar content-generator__sidebar--end bg-secondary-subtle">
    <div class="content-generator__sidebar-header p-3 bg-white">
        <h5 class="mb-0">
            {{ localize('Post accounts and Preview')}}
        </h5>
    </div>
    <div class="border-top">
        <div class="p-3">
            <h6>{{ localize('Select Posting Profiles')}}</h6>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="select-all-checker">
                <label class="form-check-label cursor-pointer" for="select-all-checker">{{ localize('Select All') }}</label>
            </div>
            @foreach ($platformAccounts as $platformAccount)
                <div class="form-check d-flex align-items-center mb-2">
                    <input class="form-check-input platform_account_ids" name="platform_account_ids[]" value="{{ $platformAccount->id }}" type="checkbox" id="{{ $platformAccount->id }}"> 
                    <label class="form-check-label cursor-pointer ms-2" for="{{ $platformAccount->id }}">
                        <div class="d-flex align-items-center">
                            <img src="{{ decodedFieldValue($platformAccount->account_details, 'avatar_thumbnail') }}" alt=" " width="25" class="me-2">
                            <span>{{ $platformAccount->account_name }}</span>
                            (<img src="{{ mediaImage($platformAccount->platform?->icon_media_manager_id) }}" alt=" " width="20" height="16">)
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    
    <ul class="nav c_post tt-grid fw-medium sticky-top bg-light-subtle border-bottom p-3">
        @foreach ($platforms as $platform)
            @if (hasPlatformAccess($platform))
                <li class="nav-item">
                    <a href="#{{ $platform->slug }}-preview" class="d-flex align-items-center border rounded-pill px-2 py-1 tt-grid-item">
                        <span>
                            <img src="{{ mediaImage($platform->icon_media_manager_id) }}" alt="{{ $platform->name }}" width="30">
                        </span>
                        <span class="ms-1">{{ $platform->name }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>

    <div class="content-generator__sidebar-body tt-custom-scrollbar overflow-y-auto tt-screen-height pt-0">
        @foreach ($platforms as $platform)
            @if (hasPlatformAccess($platform))
                <div class="mt-4 shadow-sm p-3 rounded bg-light-subtle tt-single-post" id="{{ $platform->slug }}-preview">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-md">
                                <img class="rounded-circle" src="{{ mediaImage($platform->icon_media_manager_id) }}" alt="{{ $platform->name }}" alt="{{ $platform->name }}" />
                            </div>
                            <div>
                                <h6 class="mb-0">John Denver</h6>
                                <small class="text-muted"> {{ \Carbon\Carbon::now()->format('d M, Y') }}</small>
                            </div>
                        </div>
                        <span class="text-muted">
                            <i data-feather="more-horizontal" class="icon-18"></i>
                        </span>
                    </div>

                    <div class="mb-3 tt-line-clamp tt-clamp-3 preview-div" id="{{ $platform->slug }}_preview_text"></div>
    
                    <div class="tt-caption-img-wrap position-relative post-preview-image tt-img-one">
                        <div class="tt-caption-img">
                            <img src="{{ asset('assets/img/preview-img.png') }}" alt="preview" class="img-fluid">
                        </div>
                    </div> 

                    <div class="tt-post-action d-flex justify-content-between mt-3 text-muted">
                        @switch($platform->slug)
                            @case(appStatic()::PLATFORM_FACEBOOK)
                                <span class="fs-sm"><i data-feather="thumbs-up" class="icon-16"></i> {{ localize('Like') }}</span>
                                <span class="fs-sm"><i data-feather="message-circle" class="icon-16"></i> {{ localize('Comment') }}</span>
                                <span class="fs-sm"><i data-feather="share-2" class="icon-16"></i> {{ localize('Share') }}</span>
                                @break
                            @case(appStatic()::PLATFORM_INSTAGRAM)
                                <i data-feather="heart" class="icon-16"></i>
                                <i data-feather="message-circle" class="icon-16"></i>
                                <i data-feather="send" class="icon-16"></i>
                                <i data-feather="bookmark" class="icon-16"></i>
                                @break
                            @case(appStatic()::PLATFORM_TWITTER)
                                <i data-feather="message-circle" class="icon-16"></i>
                                <i data-feather="repeat" class="icon-16"></i>
                                <i data-feather="heart" class="icon-16"></i>
                                <i data-feather="share" class="icon-16"></i>
                                @break
                            @case(appStatic()::PLATFORM_LINKEDIN)
                                <span class="fs-sm"><i data-feather="thumbs-up" class="icon-16"></i> {{ localize('Like') }}</span>
                                <span class="fs-sm"><i data-feather="message-square" class="icon-16"></i> {{ localize('Comment') }}</span>
                                <span class="fs-sm"><i data-feather="share-2" class="icon-16"></i> {{ localize('Share') }}</span>
                                <span class="fs-sm"><i data-feather="send" class="icon-16"></i> {{ localize('Send') }}</span>
                                @break
                            @default
                        @endswitch
                    </div>
                </div> 
            @endif
        @endforeach
    </div>
</div>