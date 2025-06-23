<ul class="tt-side-nav">
    <li class="side-nav-item nav-item">
        <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
            <span class="tt-nav-link-icon">
                <span data-feather="home" class="icon-14"></span>
            </span>
            <span class="tt-nav-link-text">{{ localize('Dashboard') }} </span>
        </a>
    </li>
    @php
        $subscriptionRoutes = [
            'admin.plan-histories.index',
            'admin.plan-histories.show',
        ];
    @endphp
    <li class="side-nav-item nav-item {{areActiveRoutes($subscriptionRoutes, 'tt-menu-item-active') }}">
        <a data-bs-toggle="collapse" href="#subscriptions" aria-expanded="{{ areActiveRoutes($subscriptionRoutes, 'true') }}" class="side-nav-link tt-menu-toggle">
            <span class="tt-nav-link-icon">
                <span data-feather="zap" class="icon-14"></span>
            </span>
            <span class="tt-nav-link-text">{{ localize('Subscriptions') }}</span>

        </a>
        <div class="collapse {{ areActiveRoutes($subscriptionRoutes, 'show') }}" id="subscriptions">
            <ul class="side-nav-second-level">
                <li>
                    <a href="{{ route('admin.subscription-plans.index') }}">{{ localize('Subscription Packages') }}</a>
                </li>
                <li class="{{areActiveRoutes($subscriptionRoutes, 'tt-menu-item-active') }}"><a href="{{ route('admin.plan-histories.index') }}">{{ localize('Subscription History') }}</a></li>
            </ul>
        </div>
    </li>

    @if (getSetting('enable_affiliate_system') == 1)
        <li class="side-nav-item nav-item">
            <a data-bs-toggle="collapse" href="#affiliate" aria-expanded="false" class="side-nav-link tt-menu-toggle">
                <span class="tt-nav-link-icon">
                    <span data-feather="percent" class="icon-14"></span>
                </span>
                <span class="tt-nav-link-text">{{ localize('Affiliate System') }}</span>

            </a>
            <div class="collapse" id="affiliate">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('admin.affiliate.overview') }}">{{ localize('Overview') }}</a>
                    </li>
                    <li>
                        <a
                            href="{{ route('admin.affiliate.payout.configure') }}">{{ localize('Payout Configuration') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('admin.affiliate.earnings.index') }}">{{ localize('Earning Histories') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('admin.affiliate.withdraw.index') }}">{{ localize('Withdraw Requests') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('admin.affiliate.payments.index') }}">{{ localize('Payment Histories') }}</a>
                    </li>
                </ul>
            </div>
        </li>
    @endif

    <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
        <span class="tt-nav-title-text">{{ localize('Manage Documents') }}</span>
    </li>

    <li class="side-nav-item nav-item">
        <a href="{{ route('admin.folders.index') }}" class="side-nav-link">
            <span class="tt-nav-link-icon">
                <span data-feather="folder-plus" class="icon-14"></span>
            </span>
            <span class="tt-nav-link-text"> {{ localize('Folders') }} </span>
        </a>
    </li>
    <li class="side-nav-item nav-item">
        <a href="{{ route('admin.documents.index') }}" class="side-nav-link">
            <span class="tt-nav-link-icon">
                <span data-feather="grid" class="icon-14"></span>
            </span>
            <span class="tt-nav-link-text"> {{ localize('Documents') }} </span>
        </a>
    </li>

    
    
    {{-- accounts --}} 
    <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
        <span class="tt-nav-title-text">{{ localize('Manage Accounts') }}</span>
    </li> 
    {{-- Accounts --}} 
    <li class="side-nav-item nav-item {{areActiveRoutes(['admin.accounts.index'], 'tt-menu-item-active')}}">
        <a href="{{ route('admin.accounts.index') }}?type={{ getFirstActivePlatformSlug() }}" class="side-nav-link">
            <span class="tt-nav-link-icon">
                <span data-feather="target" class="icon-14"></span>
            </span>
            <span class="tt-nav-link-text"> {{ localize('Accounts') }} </span>
        </a>
    </li> 

    <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
        <span class="tt-nav-title-text">{{ localize('Social Posts') }}</span>
    </li>
    
    {{-- posts --}}
    <li class="side-nav-item nav-item">
        <a data-bs-toggle="collapse" href="#posts" aria-expanded="false"
            class="side-nav-link tt-menu-toggle">
            <span class="tt-nav-link-icon">
                <span data-feather="send" class="icon-14"></span>
            </span>
            <span class="tt-nav-link-text">{{ localize('Posts') }}</span>
        </a>
        <div class="collapse" id="posts">
            <ul class="side-nav-second-level">
                <li>
                    <a href="{{ route('admin.socials.posts.create') }}">
                        {{ localize('Create Post') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.socials.posts.index') }}">
                        {{ localize('List Posts') }}
                    </a>
                </li>
            </ul>
        </div>
    </li> 

    {{-- quick texts --}} 
    <li class="side-nav-item nav-item {{areActiveRoutes(['admin.quick-texts.index'], 'tt-menu-item-active')}}">
        <a href="{{ route('admin.quick-texts.index') }}" class="side-nav-link">
            <span class="tt-nav-link-icon">
                <span data-feather="file-text" class="icon-14"></span>
            </span>
            <span class="tt-nav-link-text"> {{ localize('Quick Texts') }} </span>
        </a>
    </li> 

    {{-- AI Blog Posts Start --}}
    @if (getSetting('enable_ai_blog_wizard') == 1) 
        <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
            <span class="tt-nav-title-text">{{ localize('AI Blog Posts') }}</span>
        </li>
        @if (allowPlanFeature('allow_blog_wizard'))
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#aiArticle" aria-expanded="false"
                    class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="refresh-ccw" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ localize('AI Articles') }}</span>

                </a>
                <div class="collapse" id="aiArticle">
                    <ul class="side-nav-second-level">

                        <li> <a href="{{ route('admin.articles.create') }}">{{ localize('Generate New AI Article') }}</a>
                        </li>


                        <li> <a href="{{route('admin.articles.index')}}">{{ localize('All AI Articles') }}</a> </li>
                    </ul>
                </div>
            </li>
        @endif
    @endif

    @php
        $wpPostRoutes = [
            'admin.wordpress.list',
            'admin.seo.wpPostSeoChecker',
            'admin.wordpress-credentials.index',
            'admin.tags.index',
            'admin.wordpress.authorLists',
            'admin.blog-categories.index',
            "admin.wordpress.articles.edit"
        ];
    @endphp
    @if (isModuleActive('WordpressBlog') && allowPlanFeature('allow_wordpress'))
        <li class="side-nav-item nav-item {{ areActiveRoutes($wpPostRoutes, 'tt-menu-item-active') }}">
            <a data-bs-toggle="collapse" href="#wpPosts" aria-expanded="{{ areActiveRoutes($wpPostRoutes, 'true') }}"
                class="side-nav-link tt-menu-toggle">
                <span class="tt-nav-link-icon">
                    <span data-feather="list" class="icon-14"></span>
                </span>
                <span class="tt-nav-link-text">{{ localize('WordPress Posts') }}</span>
            </a>
            <div class="collapse {{ areActiveRoutes($wpPostRoutes, 'show') }}" id="wpPosts">
                <ul class="side-nav-second-level">
                    <li class="{{ areActiveRoutes(['admin.wordpress.list',"admin.wordpress.articles.edit", 'admin.seo.wpPostSeoChecker'], 'tt-menu-item-active wordpressImportedPosts') }}">
                        <a href="{{ route('admin.wordpress.list') }}">{{ localize('WordPress Imported Posts') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blog-categories.index') }}">
                            {{ 'Wordpress Category' }}
                        </a>
                    </li> 
                    <li>
                        <a href="{{ route('admin.tags.index') }}">
                            {{ 'Wordpress Tags' }}
                        </a>
                    </li>  
                    <li>
                        <a href="{{ route('admin.wordpress.authorLists') }}">
                            {{ 'Wordpress Author' }}
                        </a>
                    </li>  
                    <li>
                        <a href="{{ route('admin.wordpress-credentials.index') }}">
                            {{ 'Wordpress Setting' }}
                        </a>
                    </li> 
                </ul>
            </div>
        </li>
    @endif

    @if (getSetting('enable_ai_chat') == 1 || getSetting('enable_ai_chat_image') == 1 || getSetting('enable_ai_vision') == 1 || getSetting('enable_ai_pdf_chat') == 1 || getSetting('enable_generate_code') == 1)
        <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
            <span class="tt-nav-title-text">{{ localize('AI Chat') }}</span>
        </li>
        <li class="side-nav-item nav-item">
            <a data-bs-toggle="collapse" href="#aiWords" aria-expanded="false" class="side-nav-link tt-menu-toggle">
                <span class="tt-nav-link-icon">
                    <span data-feather="message-circle" class="icon-14"></span>
                </span>
                <span class="tt-nav-link-text">{{ localize('AI Chat') }}</span>

            </a>
            <div class="collapse" id="aiWords">
                <ul class="side-nav-second-level"> 
                    @if (allowPlanFeature('allow_ai_chat') && getSetting('enable_ai_chat') == 1)
                        <li>
                            <a href="{{ getFirstActiveChatExpertId() != null ? route('admin.chats.index').'?chat_expert_id='.getFirstActiveChatExpertId() : route('admin.chats-expert.index')}}">
                                {{ localize('AI Expert Chat') }}
                            </a>
                        </li>
                    @endif
                    @if (allowPlanFeature('allow_ai_image_chat') && getSetting('enable_ai_chat_image') == 1 )
                        <li> <a href="{{ route('admin.chats.aiImageChat') }}">{{ __('AI Image Chat') }}</a>
                        </li>
                    @endif

                    @if (allowPlanFeature('allow_ai_vision') && getSetting('enable_ai_vision') == 1)
                        <li>
                            <a href="{{ route('admin.chats.aiVisionChat') }}">{{ localize('AI Vision') }}</a>
                        </li>
                    @endif

                    @if (allowPlanFeature('allow_ai_pdf_chat') && getSetting('enable_ai_pdf_chat') == 1)
                        <li>
                            <a href="{{route('admin.chats.aiPDFChat')}}">{{ localize('AI PDF Chat') }}</a>
                        </li>
                    @endif
                    
                    @if (allowPlanFeature('allow_ai_code') && getSetting('enable_generate_code') == 1)
                        <li> <a
                                href="{{ route('admin.openai.chats.code-generator') }}">{{ localize('AI Code Generate') }}</a>
                        </li>
                    @endif

                </ul>
            </div>
        </li>
    @endif
    
    
    @if (getSetting('enable_templates') == 1 || getSetting('enable_ai_writer') == 1 || getSetting('enable_ai_rewriter') == 1) 
        <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
            <span class="tt-nav-title-text">{{ localize('AI Contents') }}</span>
        </li>
        @if (allowPlanFeature('allow_templates') && getSetting('enable_templates') == 1)
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#templates" aria-expanded="false"
                    class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="file-text" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text"> {{ localize('Templates') }}</span>
                </a>
                <div class="collapse" id="templates">
                    <ul class="side-nav-second-level">

                        <li>
                            <a href="{{ route('admin.templates.index') }}">
                                {{ localize('Templates') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.template-categories.index') }}">
                                {{ localize('Template Categories') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if (allowPlanFeature('allow_ai_writer') && getSetting('enable_ai_writer') == 1)
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#aiWriter" aria-expanded="false" class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="pen-tool" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ localize('AI Writer') }}</span>
                </a>
                <div class="collapse" id="aiWriter">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.ai-writer.create') }}">
                                {{ localize('AI Writer') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.ai-writer.index') }}">
                                {{ localize('All AI Writer ') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if (allowPlanFeature('allow_ai_rewriter'))
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#aiReWriter" aria-expanded="false" class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="pen-tool" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ localize('AI ReWriter') }}</span>

                </a>
                <div class="collapse" id="aiReWriter">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.ai-rewriter.create') }}">
                                {{ localize('AI ReWriter') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.ai-rewriter.index') }}">
                                {{ localize('All ReWriter ') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif 
    @endif

    @if (getSetting('enable_ai_images') == 1) 
        <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
            <span class="tt-nav-title-text">{{ localize('AI Images') }}</span>
        </li>
        @if (allowPlanFeature('allow_images'))
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#aiImage" aria-expanded="false" class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="image" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ __('AI Images') }}</span>

                </a>
                <div class="collapse" id="aiImage">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.images.index') }}">{{ localize('All AI Images') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
    @endif

    @if (getSetting('enable_ai_plagiarism') == 1) 
        @if (allowPlanFeature('allow_ai_plagiarism'))
            <li class="side-nav-item nav-item">
                <a href="{{ route('admin.ai-plagiarism.index') }}" class="side-nav-link">
                    <span class="tt-nav-link-icon">
                        <span data-feather="file-minus" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text"> {{ localize('AI Plagiarism') }} </span>
                </a>
            </li>
        @endif
    @endif

    @if (getSetting('enable_ai_detector') == 1) 
        @if (allowPlanFeature('allow_ai_detector'))
            <li class="side-nav-item nav-item">
                <a href="{{ route('admin.ai-detector.index') }}" class="side-nav-link">
                    <span class="tt-nav-link-icon">
                        <span data-feather="type" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text"> {{ localize('AI Detector') }} </span>
                </a>
            </li>
        @endif
    @endif

    @if (getSetting('enable_ai_product_shot') == 1) 
        {{-- AI Product Shoot--}}
        @if (allowPlanFeature('allow_ai_product_shot'))
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#aiProductShot" aria-expanded="false"
                class="side-nav-link tt-menu-toggle">
                            <span class="tt-nav-link-icon">
                                <span data-feather="image" class="icon-14"></span>
                            </span>
                    <span class="tt-nav-link-text">{{ localize('AI Product Shot') }}</span>

                </a>
                <div class="collapse" id="aiProductShot">
                    <ul class="side-nav-second-level">
                        @if (allowPlanFeature('allow_ai_product_shot'))
                            <li> <a href="{{ route('admin.images.productShot.index') }}">{{ localize('AI Product Shot') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif
    @endif

    @if (getSetting('enable_ai_photo_studio') == 1) 
        {{-- AI Photo Studio--}}
        @if (allowPlanFeature('allow_ai_photo_studio'))
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#aiPhotoStudio" aria-expanded="false"
                class="side-nav-link tt-menu-toggle">
                            <span class="tt-nav-link-icon">
                                <span data-feather="image" class="icon-14"></span>
                            </span>
                    <span class="tt-nav-link-text">{{ localize('AI Photo Studio') }}</span>

                </a>
                <div class="collapse" id="aiPhotoStudio">
                    <ul class="side-nav-second-level">
                        @if (allowPlanFeature('allow_ai_photo_studio'))
                            <li> <a href="{{ route('admin.images.photoStudio.index') }}">{{ localize('AI Photo Studio List') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif
    @endif
    @if (getSetting('enable_ai_video') == 1 || getSetting('enable_ai_avatar_pro') == 1) 
      
        <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
            <span class="tt-nav-title-text">{{ localize('AI Videos') }}</span>
        </li>
        @if (allowPlanFeature('allow_ai_video') && getSetting('enable_ai_video') == 1)
            @php
                $videoRoutes = ['admin.videos.index'];
            @endphp

            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#aiVideo" aria-expanded="false" class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="film" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ localize('AI Video') }}</span>

                </a>
                <div class="collapse" id="aiVideo">
                    <ul class="side-nav-second-level">
                        <li> <a href="{{ route('admin.videos.index') }}">{{ localize('All AI Video') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- AI Video End  --}}
        @endif

        {{-- AI Avatar Pro --}}
        @if (allowPlanFeature('allow_ai_avatar_pro') && getSetting('enable_ai_avatar_pro') == 1)
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#aiAvatarPro" aria-expanded="false"
                class="side-nav-link tt-menu-toggle">
                            <span class="tt-nav-link-icon">
                                <span data-feather="film" class="icon-14"></span>
                            </span>
                    <span class="tt-nav-link-text">{{ localize('AI Avatar Pro') }}</span>
                </a>

                <div class="collapse" id="aiAvatarPro">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.avatarPro.index') }}">{{ localize('AI Avatar Pro') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
    @endif

    @if (getSetting('enable_speech_to_text') == 1 || getSetting('enable_text_to_speech') == 1) 
    
        <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
            <span class="tt-nav-title-text">{{ localize('AI Voices') }}</span>
        </li>

        @if (allowPlanFeature('allow_text_to_speech') && getSetting('enable_text_to_speech') == 1)
            <li class="side-nav-item nav-item">
                <a href="{{ route('admin.text-to-speeches.index') }}" class="side-nav-link">
                    <span class="tt-nav-link-icon">
                        <span data-feather="volume-2" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text"> {{ localize('Text To Speech') }} </span>
                </a>
            </li>
        @endif

        @if (allowPlanFeature('allow_speech_to_text') && getSetting('enable_speech_to_text') == 1)
            <li class="side-nav-item nav-item">
                <a href="{{ route('admin.voice-to-text.create') }}" class="side-nav-link">
                    <span class="tt-nav-link-icon">
                        <span data-feather="mic" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text"> {{ localize('Speech to Text') }} </span>
                </a>
            </li>
        @endif
    @endif

    

    @if (allowPlanFeature('has_free_support'))
        <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
            <span class="tt-nav-title-text">{{ localize('Support') }}</span>
        </li>

        <li class="side-nav-item nav-item">
            <a data-bs-toggle="collapse" href="#supportTicketManagement" aria-expanded="false"
                class="side-nav-link tt-menu-toggle">
                <span class="tt-nav-link-icon">
                    <span data-feather="headphones" class="icon-14"></span>
                </span>
                <span class="tt-nav-link-text">{{ localize('Support Ticket') }}</span>
            </a>
            <div class="collapse" id="supportTicketManagement">
                <ul class="side-nav-second-level">
                    <li> <a href="{{ route('admin.support-tickets.index') }}">{{ localize('Tickets') }}</a>
                    </li>

                </ul>
            </div>
        </li>
    @endif

    @php
        $roleManagements = ['admin.users.index', 'admin.roles.index'];
    @endphp

    @if (allowPlanFeature('allow_team'))
        <li class="side-nav-item nav-item">
            <a data-bs-toggle="collapse" href="#userROleManagement" aria-expanded="false"
                class="side-nav-link tt-menu-toggle">
                <span class="tt-nav-link-icon">
                    <span data-feather="user-check" class="icon-14"></span>
                </span>
                <span class="tt-nav-link-text">{{ localize('Team') }}</span>
            </a>
            <div class="collapse" id="userROleManagement">
                <ul class="side-nav-second-level">
                        <li> <a href="{{ route('admin.roles.index') }}">{{ localize('Team Roles') }}</a></li>
                        <li> <a href="{{ route('admin.users.index') }}">{{ localize('Team Members') }}</a> </li>
                </ul>
            </div>
        </li>
    @endif

    <li class="side-nav-title side-nav-item nav-item mt-4">
        <span class="tt-nav-title-text">{{ localize('Reports') }}</span>
    </li>
    <!-- Report -->
    <li class="side-nav-item nav-item ">
        <a data-bs-toggle="collapse" href="#reports" aria-expanded="false" class="side-nav-link tt-menu-toggle">
            <span class="tt-nav-link-icon"><i data-feather="bar-chart" class="icon-14"></i></span>
            <span class="tt-nav-link-text">{{ localize('Reports') }}</span>
        </a>
        <div class="collapse" id="reports">
            <ul class="side-nav-second-level">
                <li>
                    <a href="{{ route('admin.reports.words') }}">{{ localize('Words Report') }}</a>
                </li>

                <li>
                    <a href="{{ route('admin.reports.codes') }}">{{ localize('Codes Report') }}</a>
                </li>

                <li>
                    <a href="{{ route('admin.reports.images') }}">{{ localize('Images Report') }}</a>
                </li>

                <li>
                    <a href="{{ route('admin.reports.s2t') }}">{{ localize('Speech to Texts') }}</a>
                </li>

                <li>
                    <a href="{{ route('admin.reports.mostUsed') }}">{{ localize('Most Used Templates') }}</a>
                </li>

                <li>
                    <a href="{{ route('admin.reports.subscriptions') }}">{{ localize('Subscriptions Reports') }}</a>
                </li>


            </ul>
        </div>
    </li>
</ul>
