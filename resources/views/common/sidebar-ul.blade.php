@if (isCustomerUserGroup())
    @include('common.customer-sidebar')
@else
    <ul class="tt-side-nav">
        <li class="side-nav-item nav-item">
            <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                <span class="tt-nav-link-icon">
                    <span data-feather="home" class="icon-14"></span>
                </span>
                <span class="tt-nav-link-text">{{ localize('Dashboard') }}</span>
            </a>
        </li>
        @php
            $documentsRoutes = ['admin.folders.index', 'admin.documents.index'];
        @endphp
        @if (isMenuGroupShow($documentsRoutes))
            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('Manage Documents') }}</span>
            </li>
            @if (isRouteExists('admin.folders.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.folders.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="folder-plus" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('Folders') }} </span>
                    </a>
                </li>
            @endif
            @if (isRouteExists('admin.documents.index'))
                <li class="side-nav-item nav-item {{areActiveRoutes(['admin.documents.index', 'admin.generated-content.show'], 'tt-menu-item-active')}}">
                    <a href="{{ route('admin.documents.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="file-text" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('Documents') }} </span>
                    </a>
                </li>
            @endif
        @endif
        
        <li class="side-nav-item nav-item">
            <a data-bs-toggle="collapse" href="#chatZone" aria-expanded="false"
                class="side-nav-link tt-menu-toggle">
                <span class="tt-nav-link-icon">
                    <span data-feather="message-square" class="icon-14"></span>
                </span>
                <span class="tt-nav-link-text">{{ localize('Prompts Library') }}</span>
            </a>
            <div class="collapse" id="chatZone">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('admin.prompt-groups.index') }}">
                            {{ localize('Prompt Group') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.prompts.index') }}">
                            {{ localize('Prompts') }}
                        </a>
                    </li>

                </ul>
            </div>
        </li>

        @php
            $aiToolsRoutes = [
                'admin.ai-writer.create',
                'admin.ai-writer.index',
                'admin.images.index',
                'admin.text-to-speeches.index',
                'admin.voice-to-text.create',
                'admin.ai-plagiarism.index',
                'admin.ai-detector.index',
                'admin.videos.index',
                'admin.template-categories.index',
                'admin.templates.index',
                'admin.chat-categories.index',
                "admin.articles.edit"
            ];
        @endphp

        @if (isMenuGroupShow($aiToolsRoutes))

            {{-- AI Tools Start --}}
            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('AI Blog Posts') }}</span>
            </li>
            @php
                $fullBlogRoutes = [
                    'admin.articles.create',
                    'admin.articles.index',
                    'admin.seo.articleSeoChecker',
                    'admin.articles.edit'
                ];
            @endphp

            @if (isRouteExists('admin.articles.create'))
                <li class="side-nav-item nav-item {{ areActiveRoutes($fullBlogRoutes, 'tt-menu-item-active') }}">
                    <a data-bs-toggle="collapse" href="#aiArticle" aria-expanded="{{ areActiveRoutes($fullBlogRoutes, 'true') }}"
                        class="side-nav-link tt-menu-toggle">
                        <span class="tt-nav-link-icon">
                            <span data-feather="refresh-ccw" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('AI Blog Wizard') }}</span>
                    </a>
                    <div class="collapse {{ areActiveRoutes($fullBlogRoutes, 'show') }}" id="aiArticle">
                        <ul class="side-nav-second-level">
                            @if (isRouteExists('admin.articles.create'))
                                <li> <a href="{{ route('admin.articles.create') }}">{{ localize('Generate Blog Article') }}</a></li>
                            @endif

                            @if (isRouteExists('admin.articles.index'))
                                <li class="{{ areActiveRoutes(['admin.articles.edit', 'admin.articles.index', 'admin.seo.articleSeoChecker'], 'tt-menu-item-active blogWizard') }}">
                                    <a href="{{ route('admin.articles.index') }}" >{{ localize('Blog Article List') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
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
            @if (isRouteExists('admin.articles.create'))
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
                            @if (isRouteExists('admin.wordpress.list'))
                                <li class="{{ areActiveRoutes(['admin.wordpress.list',"admin.wordpress.articles.edit", 'admin.seo.wpPostSeoChecker'], 'tt-menu-item-active wordpressImportedPosts') }}">
                                    <a href="{{ route('admin.wordpress.list') }}">{{ localize('WordPress Imported Posts') }}</a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.blog-categories.index'))
                                <li>
                                    <a href="{{ route('admin.blog-categories.index') }}">
                                        {{ 'Wordpress Category' }}
                                    </a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.tags.index'))
                                <li>
                                    <a href="{{ route('admin.tags.index') }}">
                                        {{ 'Wordpress Tags' }}
                                    </a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.wordpress.authorLists'))
                                <li>
                                    <a href="{{ route('admin.wordpress.authorLists') }}">
                                        {{ 'Wordpress Author' }}
                                    </a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.wordpress-credentials.index'))
                                <li>
                                    <a href="{{ route('admin.wordpress-credentials.index') }}">
                                        {{ 'Wordpress Setting' }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('AI Chat') }}</span>
            </li>
            @php
                $aiRoutes = [
                    'admin.openai.chats.code-generator',
                    'admin.chats.aiImageChat',
                    'admin.chats.aiVisionChat',
                    'admin.chats.aiPDFChat',
                    'admin.chat-experts.index',
                    'admin.chats.index',
                ];
            @endphp
            @if (isMenuGroupShow($aiRoutes))
                <li class="side-nav-item nav-item {{ areActiveRoutes($aiRoutes, 'tt-menu-item-active') }}">
                    <a data-bs-toggle="collapse" href="#sidebarAI" aria-expanded="{{ areActiveRoutes($aiRoutes, 'true') }}"
                        class="side-nav-link tt-menu-toggle">
                        <span class="tt-nav-link-icon">
                            <span data-feather="message-circle" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('AI Chats') }}</span>
                    </a>
                    <div class="collapse {{ areActiveRoutes($aiRoutes, 'show') }}" id="sidebarAI">
                        <ul class="side-nav-second-level">
                            @if (isRouteExists('admin.chat-experts.index'))
                                <li class="{{ areActiveRoutes(['admin.chats.index'], 'tt-menu-item-active') }}">
                                    <a href="{{ getFirstActiveChatExpertId() != null ? route('admin.chats.index').'?chat_expert_id='.getFirstActiveChatExpertId() : route('admin.chats-expert.index')}}">
                                        {{ localize('AI Experts Chat') }}
                                    </a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.chats.aiImageChat'))
                                <li> <a href="{{ route('admin.chats.aiImageChat') }}">{{ __('AI Image Chat') }}</a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.chats.aiVisionChat'))
                                <li>
                                    <a href="{{ route('admin.chats.aiVisionChat') }}">{{ localize('AI Vision') }}</a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.chats.aiPDFChat'))
                                <li>
                                    <a href="{{ route('admin.chats.aiPDFChat') }}">{{ localize('AI PDF Chat') }}</a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.openai.chats.code-generator'))
                                <li> <a href="{{ route('admin.openai.chats.code-generator') }}">{{ localize('AI Code Generate') }}</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            
            
        {{-- platforms & accounts --}}
            @php
                $platformRoutes = ['admin.platforms.index','admin.accounts.index'];
            @endphp
            @if (isMenuGroupShow($platformRoutes))
                <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                    <span class="tt-nav-title-text">{{ localize('Manage Accounts') }}</span>
                </li>
                {{-- Platforms --}}
                @if (isRouteExists('admin.platforms.index'))
                    <li class="side-nav-item nav-item {{areActiveRoutes(['admin.platforms.index'], 'tt-menu-item-active')}}">
                        <a href="{{ route('admin.platforms.index') }}" class="side-nav-link">
                            <span class="tt-nav-link-icon">
                                <span data-feather="command" class="icon-14"></span>
                            </span>
                            <span class="tt-nav-link-text"> {{ localize('Platforms') }} </span>
                        </a>
                    </li>
                @endif
                {{-- Accounts --}}
                @if (isRouteExists('admin.accounts.index'))
                    <li class="side-nav-item nav-item {{areActiveRoutes(['admin.accounts.index'], 'tt-menu-item-active')}}">
                        <a href="{{ route('admin.accounts.index') }}?type={{ getFirstActivePlatformSlug() }}" class="side-nav-link">
                            <span class="tt-nav-link-icon">
                                <span data-feather="target" class="icon-14"></span>
                            </span>
                            <span class="tt-nav-link-text"> {{ localize('Accounts') }} </span>
                        </a>
                    </li>
                @endif
            @endif

            {{-- Social Posts --}}
            @php
                $postRoutes = ['admin.quick-texts.index','admin.prompt-groups.index', 'admin.prompts.index', 'admin.socials.posts.create', 'admin.socials.posts.index'];
            @endphp
            @if (isMenuGroupShow($postRoutes))
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
                @if (isRouteExists('admin.quick-texts.index'))
                    <li class="side-nav-item nav-item {{areActiveRoutes(['admin.quick-texts.index'], 'tt-menu-item-active')}}">
                        <a href="{{ route('admin.quick-texts.index') }}" class="side-nav-link">
                            <span class="tt-nav-link-icon">
                                <span data-feather="file-text" class="icon-14"></span>
                            </span>
                            <span class="tt-nav-link-text"> {{ localize('Quick Texts') }} </span>
                        </a>
                    </li>
                @endif
            @endif
        
            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('AI Contents') }}</span>
            </li>
            @php
                $templateRoutes = ['admin.template-categories.index', 'admin.templates.index', 'admin.templates.show'];
            @endphp

            @if (isMenuGroupShow($templateRoutes))
                <li class="side-nav-item nav-item {{ areActiveRoutes($templateRoutes, 'tt-menu-item-active') }}">
                    <a data-bs-toggle="collapse" href="#templates" aria-expanded="{{ areActiveRoutes($templateRoutes, 'true') }}"
                        class="side-nav-link tt-menu-toggle">
                        <span class="tt-nav-link-icon">
                            <span data-feather="file" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('Templates') }}</span>
                    </a>
                    <div class="collapse {{ areActiveRoutes($templateRoutes, 'show') }}" id="templates">
                        <ul class="side-nav-second-level">
                            @if (isRouteExists('admin.template-categories.index'))
                                <li>
                                    <a href="{{ route('admin.template-categories.index') }}">
                                        {{ localize('Template Categories') }}
                                    </a>
                                </li>
                            @endif

                            @if (isRouteExists('admin.templates.index'))
                                <li class="{{ areActiveRoutes(['admin.templates.show'], 'tt-menu-item-active') }}">
                                    <a href="{{ route('admin.templates.index') }}">
                                        {{ localize('Templates') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            @if (isRouteExists('admin.ai-writer.create') || isRouteExists('admin.ai-writer.index'))
                <li class="side-nav-item nav-item">
                    <a data-bs-toggle="collapse" href="#aiWriter" aria-expanded="false"
                        class="side-nav-link tt-menu-toggle">
                        <span class="tt-nav-link-icon">
                            <span data-feather="pen-tool" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('AI Writer') }}</span>

                    </a>
                    <div class="collapse" id="aiWriter">
                        <ul class="side-nav-second-level">
                            @if (isRouteExists('admin.ai-writer.create'))
                                <li> <a href="{{ route('admin.ai-writer.create') }}">
                                        {{ localize('AI Writer') }}
                                    </a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.ai-writer.index'))
                                <li> <a href="{{ route('admin.ai-writer.index') }}">
                                        {{ localize('AI Writer List') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            @if (isRouteExists('admin.ai-rewriter.create') || isRouteExists('admin.ai-rewriter.index'))
                <li class="side-nav-item nav-item">
                    <a data-bs-toggle="collapse" href="#aiReWriter" aria-expanded="false"
                        class="side-nav-link tt-menu-toggle">
                        <span class="tt-nav-link-icon">
                            <span data-feather="repeat" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('AI Re-Writer') }}</span>
                    </a>

                    <div class="collapse" id="aiReWriter">
                        <ul class="side-nav-second-level">
                            @if (isRouteExists('admin.ai-rewriter.index'))
                                <li> <a href="{{ route('admin.ai-rewriter.index') }}">
                                        {{ localize('Re-Writer Content List') }}
                                    </a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.ai-rewriter.create'))
                                <li> <a href="{{ route('admin.ai-rewriter.create') }}">
                                        {{ localize('Re-Writer Content') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            
            @if (isRouteExists('admin.ai-plagiarism.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.ai-plagiarism.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="file-minus" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('AI Plagiarism') }} </span>
                    </a>
                </li>
            @endif
            @if (isRouteExists('admin.ai-detector.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.ai-detector.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="type" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('AI Detector') }} </span>
                    </a>
                </li>
            @endif

            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('AI Images') }}</span>
            </li>
            @if (isRouteExists('admin.images.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.images.index') }}"
                        class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="image" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('AI Images') }}</span>
                    </a>
                </li>
            @endif
            {{-- AI Image End --}}

            @if (isRouteExists('admin.images.photoStudio.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.images.photoStudio.index') }}"
                        class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="feather" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('AI Photo Studio') }}</span>
                    </a>
                </li>
            @endif

            {{-- AI Product Shoot--}}
            @if (isRouteExists('admin.images.productShot.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.images.productShot.index') }}"
                        class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="camera" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('AI Product Shot') }}</span>
                    </a>
                </li>
            @endif

            
            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('AI Videos') }}</span>
            </li>

            @php
                $videoRoutes = ['admin.videos.index'];
            @endphp

            @if (isMenuGroupShow($videoRoutes))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.videos.index') }}"
                        class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="play" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('AI Videos') }}</span>
                    </a>
                </li>
                {{-- AI Video End  --}}
            @endif

            @php
                $aiAvatarRoutes = [
                  "admin.avatarPro.index"
                ];
            @endphp
            @if (isMenuGroupShow($aiAvatarRoutes))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.avatarPro.index') }}"
                        class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="film" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('AI Avatar Pro') }}</span>
                    </a>
                </li>
                {{-- AI Avatar Pro End  --}}
            @endif

            @php
                $aiAvatarRoutes = [
                  "admin.brand-voices.create",
                  "admin.brand-voices.index",
                  "admin.brand-voices.edit",
                ];
            @endphp
            @if (isMenuGroupShow($aiAvatarRoutes))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.brand-voices.index') }}"
                        class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="rss" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('Brand Voice') }}</span>
                    </a>


                </li>
                {{-- Brand Voice End  --}}
            @endif

            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('AI Voices') }}</span>
            </li>
            @if (isRouteExists('admin.voice-to-text.create'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.voice-to-text.create') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="mic" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('Audio To Text') }} </span>
                    </a>
                </li>
            @endif

            @if (isRouteExists('admin.text-to-speeches.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.text-to-speeches.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="volume-2" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">
                            {{ localize('Text To Speech') }}
                        </span>
                    </a>
                </li>
            @endif

            @if (isRouteExists('admin.voice.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.voice.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="copy" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('AI Voice Clone') }} </span>
                    </a>
                </li>
            @endif
            
        @endif

        @php
            $articleEditRoutes = currentRoute() == 'admin.articles.edit' ? 'admin.articles.edit?blogWizard' : "admin.articles.edit";

            $subscriptionRoutes = [
                'admin.subscription-plans.index',
                'admin.plan-histories.index',
                'admin.subscription-settings.index',
                'admin.plan-histories.show'
            ];

            $subscriptionHistoryRoutes = [
            'admin.plan-histories.index',
            'admin.plan-histories.show',
        ];
        @endphp
        @if (isMenuGroupShow($subscriptionRoutes))
            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10 {{areActiveRoutes($subscriptionRoutes, 'tt-menu-item-active') }}">
                <span class="tt-nav-title-text">{{ localize('Manage Subscriptions') }}</span>
            </li>
            <li class="side-nav-item nav-item {{areActiveRoutes($subscriptionRoutes, 'tt-menu-item-active') }}">
                <a data-bs-toggle="collapse" href="#subscriptions" aria-expanded="false"
                    class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="zap" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ localize('Subscriptions') }}</span>

                </a>
                <div class="collapse {{ areActiveRoutes($subscriptionRoutes, 'show') }}" id="subscriptions">
                    <ul class="side-nav-second-level">
                        @if (isRouteExists('admin.subscription-plans.index'))
                            <li> <a
                                    href="{{ route('admin.subscription-plans.index') }}">{{ localize('Subscription Plan') }}</a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.plan-histories.index'))
                            <li  class="{{areActiveRoutes($subscriptionHistoryRoutes, 'tt-menu-item-active') }}"> <a
                                    href="{{ route('admin.plan-histories.index') }}">{{ localize('Subscription History') }}</a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.subscription-settings.index'))
                            <li> <a
                                    href="{{ route('admin.subscription-settings.index') }}">{{ localize('Recurring Product Plan') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif

        @if (getSetting('enable_affiliate_system') == '1')
            @php
                $affiliateRoutes = [
                    'admin.affiliate.withdraw.index',
                    'admin.affiliate.earnings.index',
                    'admin.affiliate.payments.index',
                ];
            @endphp
            @if (isMenuGroupShow($subscriptionRoutes))
                <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                    <span class="tt-nav-title-text">{{ localize('Manage Affiliate') }}</span>
                </li>
                <li class="side-nav-item nav-item">
                    <a data-bs-toggle="collapse" href="#affiliate" aria-expanded="false"
                        class="side-nav-link tt-menu-toggle">
                        <span class="tt-nav-link-icon">
                            <span data-feather="percent" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('Affiliate System') }}</span>

                    </a>
                    <div class="collapse" id="affiliate">
                        <ul class="side-nav-second-level">
                            @if (isRouteExists('admin.affiliate.withdraw.index'))
                                <li>
                                    <a href="{{ route('admin.affiliate.withdraw.index') }}">{{ localize('Withdraw Requests') }}</a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.affiliate.earnings.index'))
                                <li>
                                    <a href="{{ route('admin.affiliate.earnings.index') }}">{{ localize('Earning Histories') }}</a>
                                </li>
                            @endif
                            @if (isRouteExists('admin.affiliate.payments.index'))
                                <li>
                                    <a href="{{ route('admin.affiliate.payments.index') }}">{{ localize('Payment Histories') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
        @endif

        <!-- Report -->
        @php
            $reportRoutes = [
                'admin.reports.words',
                'admin.reports.codes',
                'admin.reports.images',
                'admin.reports.s2t',
                'admin.reports.mostUsed',
                'admin.reports.subscriptions',
            ];
        @endphp
        @if (isMenuGroupShow($reportRoutes))
            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('Reports') }}</span>
            </li>
            <!-- Report -->
            <li class="side-nav-item nav-item ">
                <a data-bs-toggle="collapse" href="#reports" aria-expanded="false"
                    class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon"><i data-feather="bar-chart" class="icon-14"></i></span>
                    <span class="tt-nav-link-text">{{ localize('Reports') }}</span>
                </a>
                <div class="collapse" id="reports">
                    <ul class="side-nav-second-level">
                        @if (isRouteExists('admin.reports.words'))
                            <li>
                                <a href="{{ route('admin.reports.words') }}">{{ localize('Words Report') }}</a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.reports.codes'))
                            <li>
                                <a href="{{ route('admin.reports.codes') }}">{{ localize('Codes Report') }}</a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.reports.images'))
                            <li>
                                <a href="{{ route('admin.reports.images') }}">{{ localize('Images Report') }}</a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.reports.s2t'))
                            <li>
                                <a href="{{ route('admin.reports.s2t') }}">{{ localize('Speech to Texts') }}</a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.reports.mostUsed'))
                            <li>
                                <a href="{{ route('admin.reports.mostUsed') }}">{{ localize('Most Used Templates') }}</a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.reports.subscriptions'))
                            <li>
                                <a href="{{ route('admin.reports.subscriptions') }}">{{ localize('Subscriptions Reports') }}</a>
                            </li>
                        @endif

                    </ul>
                </div>
            </li>
        @endif

        @php
            $supportoutes = [
                'admin.support-categories.index',
                'admin.support-priorities.index',
                'admin.support-tickets.index',
                'admin.support-tickets.reply'
            ];
        @endphp

        @if (isMenuGroupShow($supportoutes))
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
                        @if (isRouteExists('admin.support-categories.index'))
                            <li> <a href="{{ route('admin.support-categories.index') }}">{{ localize('Category') }}</a> </li>
                        @endif

                        @if (isRouteExists('admin.support-priorities.index'))
                            <li> <a href="{{ route('admin.support-priorities.index') }}">{{ localize('priority') }}</a></li>
                        @endif

                        @if (isRouteExists('admin.support-tickets.index'))
                            <li> <a href="{{ route('admin.support-tickets.index') }}">{{ localize('Tickets') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            <li class="side-nav-item nav-item">
                <a href="{{ route('admin.queries.index') }}" class="side-nav-link">
                    <span class="tt-nav-link-icon">
                        <span data-feather="help-circle" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text"> {{ localize('Queries') }} </span>
                </a>
            </li>
        @endif

        @php
            $contentRoutes = [
                'admin.tags.index',
                'admin.blogs.index',
                'admin.blog-categories.index',
                'admin.faqs.index',
                'admin.media-managers.index',
                'admin.support-categories.index',
                'admin.support-priorities.index',
                'admin.support-tickets.index',
               
            ];
        @endphp
        @if (isMenuGroupShow($contentRoutes))

            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('Manage Contents') }}</span>
            </li>
            @php
                $userBlogManagementRoutes = ['admin.blogs.index', 'admin.blog-categories.index'];
            @endphp
            @if (isMenuGroupShow($userBlogManagementRoutes))

                <li class="side-nav-item nav-item">
                    <a data-bs-toggle="collapse" href="#userBlogManagement" aria-expanded="false"
                        class="side-nav-link tt-menu-toggle">
                        <span class="tt-nav-link-icon">
                            <span data-feather="file-text" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('Website Blogs') }}</span>
                    </a>
                    <div class="collapse" id="userBlogManagement">
                        <ul class="side-nav-second-level">
                            @if (isRouteExists('admin.blogs.index'))
                                <li> <a href="{{ route('admin.blogs.index') }}">{{ localize('Blog List') }}</a>
                                </li>
                            @endif

                            @if (isRouteExists('admin.blog-categories.index'))
                                <li> <a href="{{ route('admin.blog-categories.index') }}">{{ localize('Blog Categories') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            @if (isRouteExists('admin.tags.index'))
            <li class="side-nav-item nav-item">
                <a href="{{ route('admin.tags.index') }}" class="side-nav-link">
                    <span class="tt-nav-link-icon">
                        <span data-feather="tag" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text"> {{ localize('Tags') }} </span>
                </a>
            </li>
        @endif

            @if (isRouteExists('admin.pages.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.pages.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="file-plus" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('Pages') }} </span>
                    </a>
                </li>
            @endif
            @if (isRouteExists('admin.faqs.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.faqs.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="info" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('All FAQs') }} </span>
                    </a>
                </li>
            @endif
            @if (isRouteExists('admin.media-managers.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.media-managers.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="folder" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text"> {{ localize('Media Manager') }} </span>
                    </a>
                </li>
            @endif
            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('Manage Promotions') }}</span>
            </li>
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#newsLetterManagement" aria-expanded="false"
                    class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="book-open" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ localize('Newsletters') }}</span>
                </a>
                <div class="collapse" id="newsLetterManagement">
                    <ul class="side-nav-second-level">
                        @if (isRouteExists('admin.newsletters.index'))
                            <li> <a href="{{ route('admin.newsletters.index') }}">{{ localize('Bulk Emails') }}</a> </li>
                        @endif
                        @if (isRouteExists('admin.subscribers.index'))
                            <li> <a href="{{ route('admin.subscribers.index') }}">{{ localize('Subscribers') }}</a> </li>
                        @endif
                    </ul>
                </div>
            </li>
            
        @endif
        @php
            $userManagementRoutes = ['admin.customers.index', 'admin.users.index'];
        @endphp
        @if (isMenuGroupShow($userManagementRoutes))
            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('User Management') }}</span>
            </li>
            @if (isRouteExists('admin.customers.index'))
                <li class="side-nav-item nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="side-nav-link">
                        <span class="tt-nav-link-icon">
                            <span data-feather="users" class="icon-14"></span>
                        </span>
                        <span class="tt-nav-link-text">{{ localize('Customers') }}</span>
                    </a>
                </li>
            @endif
        @endif
        @php
            $roleManagements = ['admin.users.index', 'admin.roles.index'];
        @endphp
        @if (isMenuGroupShow($roleManagements))

            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#userROleManagement" aria-expanded="false"
                    class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="user-check" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ localize('Admins & Teams') }}</span>
                </a>
                <div class="collapse" id="userROleManagement">
                    <ul class="side-nav-second-level">
                        @if (isRouteExists('admin.users.index'))
                            <li> <a href="{{ route('admin.users.index') }}">{{ localize('Admins & Team') }}</a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.roles.index'))
                            <li> <a href="{{ route('admin.roles.index') }}">{{ localize('Manage Roles') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif
        @php
            $settingsRoutes = [
                'admin.settings.index',
                'admin.settings.credentials',
                'admin.email-templates.index',
                'admin.settings.adSense.index',
                'admin.languages.index',
                'admin.currencies.index',
                'admin.payment-gateways.index',
                'admin.offline-payment-methods.index',
                'admin.cron-list',
                'admin.pwa-settings.index',
                'admin.systemUpdate.health-check',
                'admin.systemUpdate.update',
            ];
        @endphp
        @if (isMenuGroupShow($settingsRoutes))
            <li class="side-nav-title side-nav-item nav-item mt-4 fs-10">
                <span class="tt-nav-title-text">{{ localize('MANAGE SETTINGS') }}</span>
            </li>
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSettingsMenu" aria-expanded="false"
                    class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="settings" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ localize('Settings') }}</span>
                </a>
                <div class="collapse" id="sidebarSettingsMenu">
                    <ul class="side-nav-second-level">
                        @if (isRouteExists('admin.settings.index'))
                            <li>
                                <a href="{{ route('admin.settings.index') }}">
                                    {{ 'Features Settings' }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.settings.credentials'))
                            <li>
                                <a href="{{ route('admin.settings.credentials') }}">
                                    {{ localize('All Credentials Setup') }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.wordpress-settings.index'))
                            <li>
                                <a href="{{ route('admin.wordpress-settings.index') }}">
                                    {{ 'Wordpress Settings' }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.pwa-settings.index'))
                            <li>
                                <a href="{{ route('admin.pwa-settings.index') }}">
                                    {{ 'PWA Setting' }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.email-templates.index'))
                            <li>
                                <a href="{{ route('admin.email-templates.index') }}">
                                    {{ localize('Email Template') }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.settings.adSense.index'))
                            <li>
                                <a href="{{ route('admin.settings.adSense.index') }}">
                                    {{ localize('Google Ads') }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.languages.index'))
                            <li>
                                <a href="{{ route('admin.languages.index') }}">
                                    {{ localize('Multi Language') }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.currencies.index'))
                            <li>
                                <a href="{{ route('admin.currencies.index') }}">
                                    {{ localize('Multi Currency') }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.payment-gateways.index'))
                            <li>
                                <a href="{{ route('admin.payment-gateways.index') }}">
                                    {{ localize('Payment Gateway') }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.offline-payment-methods.index'))
                            <li>
                                <a href="{{ route('admin.offline-payment-methods.index') }}">
                                    {{ localize('Offline Payment') }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.cron-list'))
                            <li>
                                <a href="{{ route('admin.cron-list') }}">
                                    {{ localize('Cron List') }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.utilities'))
                            <li>
                                <a href="{{ route('admin.utilities') }}">
                                    {{ localize('Utilities') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif
        @php
            $appearanceRoutes = ['admin.appearance.index', 'admin.client-feedbacks.index'];
        @endphp
        @if (isMenuGroupShow($appearanceRoutes))
            <li class="side-nav-item nav-item">
                <a data-bs-toggle="collapse" href="#sidebarAppearance" aria-expanded="false"
                    class="side-nav-link tt-menu-toggle">
                    <span class="tt-nav-link-icon">
                        <span data-feather="eye" class="icon-14"></span>
                    </span>
                    <span class="tt-nav-link-text">{{ localize('Appearance') }}</span>
                </a>
                <div class="collapse" id="sidebarAppearance">
                    <ul class="side-nav-second-level">
                        @if (isRouteExists('admin.appearance.index'))
                            <li>
                                <a href="{{ route('admin.appearance.index') }}">
                                    {{ 'Appearance' }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.client-feedbacks.index'))
                            <li>
                                <a href="{{ route('admin.client-feedbacks.index') }}">
                                    {{ 'Client Feedback' }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.about-us.index'))
                            <li>
                                <a href="{{ route('admin.about-us.index') }}">
                                    {{ 'About Us' }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.privacy-policy.index'))
                            <li>
                                <a href="{{ route('admin.privacy-policy.index') }}">
                                    {{ 'Privacy Policy' }}
                                </a>
                            </li>
                        @endif
                        @if (isRouteExists('admin.terms-conditions.index'))
                            <li>
                                <a href="{{ route('admin.terms-conditions.index') }}">
                                    {{ 'Terms Conditions' }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif
    </ul>
@endif

