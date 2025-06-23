<aside class="tt-sidebar bg-info {{ isSideBarCollapsed() }}" id="sidebar">
    <div class="tt-brand">
        <a href="{{ route('admin.dashboard') }}" class="tt-brand-link">
            <img src="{{ getSetting('collapse_able_icon') ? avatarImage(getSetting('collapse_able_icon')) : asset('assets') }}/img/logo-icon.png" class="tt-brand-favicon d-none" width="44"
                alt="favicon" />
            <img src="{{ getSetting('logo_for_light') ? avatarImage(getSetting('logo_for_light')) : asset('assets') }}/img/logo.png" class="tt-brand-logo ms-2" alt="logo" width="164" />
        </a>
        <a href="javascript:void(0);" class="tt-toggle-sidebar">
            <span><i data-feather="chevron-left"></i></span>
        </a>
    </div>

    <div class="tt-sidebar-nav pb-9 pt-3 d-flex flex-column h-100 justify-content-between tt-custom-scrollbar">
        <nav class="navbar navbar-vertical navbar-expand-lg">
            <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                <div class="w-100" id="leftside-menu-container">
                   @include('common.sidebar-ul')
                </div>
            </div>
        </nav>
        <ul class="tt-side-nav m-3 tt-user-side-nav">


            <!-- customer profile with affiliate link button -->
            @if (isCustomerUserGroup())
          
                <li class="side-nav-item nav-item tt-sidebar-user rounded-3 bg-secondary-subtle">
                    <div class="side-nav-link flex-column justify-content-center py-4">
                        <div class="tt-user-avatar lh-1 mb-2">
                            <div class="avatar avatar-md status-online">
                                <img class="rounded-circle" src="{{ avatarImage(user()->avatar) }}" alt=""
                                    onerror="this.onerror=null;this.src='{{ avatarImage(user()->avatar) }}';">
                            </div>
                        </div>
                        <div class="tt-nav-link-text text-center">
                            <h6 class="mb-0 lh-1 d-block">{{ user()->name }}</h6>
                            <span class="text-muted fs-sm"> {!! html_entity_decode(optional(user()->plan)->title) !!}/{{ ucfirst(optional(user()->plan)->package_type) }}</span>

                            @if (getSetting('enable_affiliate_system') == '1')
                                <div class="mt-3">
                                    <p class="text-muted fs-md">
                                        💰 {{ localize('Invite your friends and earn money from their subscriptions') }}
                                    </p>
                                    <a href="{{ route('admin.affiliate.overview') }}"
                                        class="btn btn-accent btn-sm rounded-pill shadow-sm">{{ localize('Invite Friends') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
            @else
                <!-- logout button for admin -->
                <li class="side-nav-item nav-item">
                    <a href="{{ route('logout') }}"
                        class="side-nav-link justify-content-center btn border border-primary rounded-pill text-center">
                        {{ localize('Logout') }} <i data-feather="log-out" class="icon-14 ms-2"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
