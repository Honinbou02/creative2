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
            @php
                $result = isset($editArticle) ? $editArticle->article : '';
            @endphp
            {!! preg_replace('/\*\*(.*?)\*\*/', '<h3 class="mb-0 mt-4 h5">$1</h3>', $result) !!} 
        </div>
        
    </div>
    <div class="d-flex justify-content-end mb-3 gap-3 px-3">
        <button class="btn btn-primary px-3 py-1 rounded-pill saveChange" {{isset($editArticle) ? '' :'disabled'}} id="saveChangeBtn"> <i data-feather="save" class="icon-14"></i> {{localize('Save Content')}}</button>
        @if(getSetting('enable_auto_blog_post') !=1 && wpCredential())
            @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (!isCustomerUserGroup()))
                <button class="btn btn-success px-3 py-1 rounded-pill publishedToWordpress" disabled><i data-feather="globe" class="icon-14"></i> {{localize('Published to WordPress')}}</button>
            @endif
        @endif

    </div>
</div>
