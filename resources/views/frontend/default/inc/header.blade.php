    <!-- Header -->
    <div class="navbar-overlay">
        <nav class="navbar navbar-1 navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand logo" href="{{ route('layouts') }}">
                    <img src="{{ getSetting('logo_for_light') ? avatarImage(getSetting('logo_for_light')) : asset('frontend/assets/img/logo-light.png') }}"
                        alt="image" class="logo__img">
                    <img src="{{ getSetting('logo_for_dark') ? avatarImage(getSetting('logo_for_dark')) : asset('frontend/assets/img/logo-dark.png') }}"
                        alt="image" class="logo__img logo__sticky">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryMenu"
                    aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="primaryMenu">
                  
                    <ul class="navbar-nav align-items-lg-center gap-lg-3 mx-auto text-body">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('layouts') }}">{{ localize('Home') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about-us') }}">{{ localize('About Us') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route("pricing") }}">{{ localize('Pricing') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact-us') }}">{{ localize('Contact Us') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blogs') }}">{{ localize('Blogs') }}</a>
                        </li>                     
                       
                        <x-header-page/>
                    </ul>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center gap-1">
                                <img src="{{ asset('assets/img/flags/'.currentLanguage()->code.'.png') }}" alt="flag" class="img-fluid">
                                <select name="language" id="language" class="bg-dark text-body fs-14 border-0 changeLocaleLanguage">
                                    @foreach (languages() as $language)
                                        <option value="{{ $language->code }}" {{currentLanguage()->code == $language->code ? 'selected':''}}>{{ $language->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <select name="country" id="country" class="bg-dark text-body fs-14 border-0 changeLocaleCurrency">
                                @foreach (currencies() as $currency)
                                    <option value="{{ $currency->code }}" {{ $currency->code == currentCurrency()->code ?'selected':'' }}> {{ $currency->symbol }}
                                        {{ strtoupper($currency->code) }}</option>
                                @endforeach

                            </select>
                        </div>
                        @if (!auth()->check())
                            <a href="{{ route('register') }}" 
                                class="nav-link fs-14 rounded-1">
                                {{ localize('Sign up') }}
                            </a>
                        @endif
                        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                            class="btn btn-lg btn-outline-light px-4 py-2 fs-14 rounded-pill border-primary btn-svg-hover d-flex align-items-center gap-2 fs-14 text-heading">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="-0.00732422" width="24" height="24" rx="12" fill="url(#paint0_linear_1780_21102)"/>
                                <path d="M6.43178 11.6523C6.43178 11.6523 12.4408 11.6523 17.8604 11.6523M17.8604 11.6523C13.9453 11.6523 13.2227 7.65234 13.2227 7.65234M17.8604 11.6523C13.9453 11.6523 13.2227 15.6523 13.2227 15.6523" stroke="white" stroke-width="1.1"/>
                                <defs>
                                <linearGradient id="paint0_linear_1780_21102" x1="-0.00732422" y1="12" x2="23.9927" y2="12" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#805AF9"/>
                                <stop offset="1" stop-color="#6632F8"/>
                                </linearGradient>
                                </defs>
                            </svg>
                            {{ auth()->check() ? localize('Dashboard') : localize('Start for free') }}
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div><!-- /Header -->
