@php
$wordpressRoutes = ['admin.wordpress-credentials.index', 'admin.wordpress-settings.index'];
@endphp
@if (isMenuGroupShow($wordpressRoutes))
<li class="side-nav-item nav-item">
    <a data-bs-toggle="collapse" href="#sidebarWordpress" aria-expanded="false"
        class="side-nav-link tt-menu-toggle">
        <span class="tt-nav-link-icon">
            <span data-feather="link" class="icon-14"></span>
        </span>
        <span class="tt-nav-link-text">{{ localize('WordPress') }}</span>
    </a>
    <div class="collapse" id="sidebarWordpress">
        <ul class="side-nav-second-level">
            @if (isRouteExists('admin.wordpress-credentials.index'))
                <li>
                    <a href="{{ route('admin.wordpress-credentials.index') }}">
                        {{ 'Wordpress Credentials' }}
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
        </ul>
    </div>
</li>
@endif