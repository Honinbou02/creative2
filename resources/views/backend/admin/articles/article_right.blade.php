<div class="content-generator__body">   
    <div class="content-generator__body-header">
        <div
            class="px-3 py-2 border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between bg-light-subtle tt-chat-header">


            <div class="col-auto flex-grow-1">
                <input class="form-control border-0 px-2 form-control-sm" type="text"
                    id="text-input" value="{{isset($editArticle) ? $editArticle->title : ''}}" placeholder="{{localize('Name of the document...')}}">
            </div>
            <div class="tt-chat-action d-flex align-items-center">
                <div class="dropdown tt-tb-dropdown me-2">
                    <button type="button" class="btn p-0 fullscreen-toggler">
                        <span class="fullscreen-icon">
                            <i data-feather="maximize"></i>
                        </span>
                        <span class="exit-fullscreen-icon">
                            <i data-feather="minimize"></i>
                        </span>
                    </button>
                </div>
                <div class="dropdown tt-tb-dropdown me-2">
                    <button type="button" class="btn p-0" id="addFrmOffCanvas" data-bs-toggle="offcanvas"
                    data-bs-target="#addSendMailSidebar" title="Send in Email"><i
                            data-feather="send" class="icon-16"></i></button>
                </div>
                <div class="dropdown tt-tb-dropdown me-2">
                    <button type="button" class="btn p-0 copyChat"><i data-feather="copy"
                            class="icon-16"></i></button>
                </div>
                @isset($editArticle)
                    <div class="dropdown tt-tb-dropdown me-2">
                        <button class="btn p-0" id="navbarDropdownUser" role="button"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-haspopup="true" aria-expanded="true">
                            <i data-feather="download" class="icon-16"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow">
                            <a class="dropdown-item downloadChatBtn" data-download_type="pdf" href="javascript:void(0);">
                                <i data-feather="file" class="me-2"></i> {{localize('PDF')}}
                            </a>
                            <a class="dropdown-item downloadChatBtn" data-download_type="html" href="javascript:void(0);">
                                <i data-feather="code" class="me-2"></i> {{localize('HTML')}}
                            </a>
                            <a class="dropdown-item downloadChatBtn" data-download_type="word" href="javascript:void(0);">
                                <i data-feather="file-text" class="me-2"></i>{{localize('MS Word')}}
                            </a>
                        </div>
                    </div>
                @endisset

            </div>
        </div>
    </div>
    <div class="content-generator__body-content">
        <div id="contentGenerator">
            @if(isset($editArticle))
                @if(!$editArticle->is_article_saved_by_save_changes_at)
                    @if(!empty($editArticle->selected_image))
                        <img src="{{ urlVersion($editArticle->selected_image) }}"
                             alt="{{ $editArticle->topic }}" title="{{ $editArticle->topic }}"
                             caption="{{ $editArticle->topic }}"
                        />
                    @endif
                @endif
            @endif

            {!! preg_replace('/\*\*(.*?)\*\*/', '<h3 class="mb-0 mt-4 h5">$1</h3>', isset($editArticle) ? $editArticle->article : '') !!}
        </div>
        
    </div>
    <div class="d-flex justify-content-between mb-3 gap-3 px-3 align-items-center">
        <div>
            <button class="btn btn-primary px-3 py-1 rounded-pill saveChange" {{isset($editArticle) ? '' :'disabled'}} id="saveChangeBtn"> <i data-feather="save" class="icon-14"></i> {{localize('Save Content')}}</button>
            
            @if (isModuleActive('SocialPilot'))
                <a href="javascript::void(0);"
                    class="btn btn-sm rounded-pill btn-secondary px-1 py-1 generateSocialPostButton"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasSocialPosts"
                    onclick="showGenerateSocialPostForm({{ $editArticle->id ?? null }})"
                    {{ isset($editArticle) ? '' :'disabled' }} 
                >
                    <i data-feather='share-2' class='icon-14 me-1'></i> {{ localize('Generate Social Posts') }}
                </a>
            @endif
            @if (isModuleActive('WordpressBlog') &&  wpCredential() && isset($editArticle) && $editArticle->id)
                @if((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (isAdmin() || isAdminTeam()))
                    <button type="button"
                        class="btn btn-sm rounded-pill btn-secondary px-3 py-1"
                        data-bs-toggle="offcanvas"
                        id="#publishedToWordpressBtn"
                        data-bs-target="#offcanvasPublishedToWordpress"
                        onclick="publishedBlogPost({{$editArticle->id}}, {{ $editArticle->wp_post_id ?? 0 }})">
                        <i data-feather='trending-up' class='icon-14 me-1 cursor-pointer'></i> {{ localize('Push to WordPress') }}
                    </button>
                    
                    <i data-feather='info' class='icon-14 me-1' data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Last Synced with WordPress: ') }} : {{ $editArticle->wp_synced_at ? manageDateTime($editArticle->wp_synced_at, 7) : localize('Not Synced Yet') }}"></i>
                    {{-- <x-info-message labelTitle="{{ localize('Last Synced with WordPress') }}" labelText="{{ $editArticle->wp_synced_at ? manageDateTime($editArticle->wp_synced_at, 7) : localize('Not Synced Yet') }}" /> --}}
                @endif
            @endif
        </div>
        @if (isset($editArticle))
            @if ($isWordpressArticle)
                @if((isCustomerUserGroup() && (allowPlanFeature("allow_seo_helpful_content") || allowPlanFeature("allow_seo_content_optimization"))) || (isAdmin() || isAdminTeam()))
                    <a href="{{ route('admin.seo.storeWpPostSeoChecker', $editArticle->id) }}" class="editIcon me-1 wpPostSeoCheckerBtn" data-bs-toggle="offcanvas" data-bs-target="#offCanvasArticleSeoChecker">
                        <x-form.button type="button" class="px-3 py-1 rounded-pill" data-bs-toggle="tooltip" data-bs-placement="top" title="Per SEO Check cost will be {{getSetting('helpful_content_optimization_per_request_credit_cost', 6)}} credits"><i data-feather="activity"></i>{{ localize('Check SEO') }}</x-form.button>
                    </a>                
                @endif
            @else
                @if((isCustomerUserGroup() && (allowPlanFeature("allow_seo_helpful_content") || allowPlanFeature("allow_seo_content_optimization"))) || (isAdmin() || isAdminTeam()))
                    <a href="{{ route('admin.seo.storeArticleSeoChecker', $editArticle->id) }}" class="editIcon me-1 articleSeoCheckerBtn" data-bs-toggle="offcanvas" data-bs-target="#offCanvasArticleSeoChecker">
                        <x-form.button type='button' class='px-3 py-1 rounded-pill' data-bs-toggle="tooltip" data-bs-placement="top" title="Per SEO Check cost will be {{getSetting('content_optimization_per_request_credit_cost', 1)}} credit(s)"><i data-feather='activity'></i>{{ localize('Check SEO') }}</x-form.button>
                    </a>
                @endif
            @endif
        @endif 
    </div>
</div>
