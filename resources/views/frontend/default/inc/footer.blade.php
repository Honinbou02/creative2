<footer class="py-5 pt-4">
    <div class="container">
        <div class="wt_card_style_nhover px-4 py-2 rounded-2">
            <div class="d-flex align-items-center justify-content-lg-between gap-4 flex-wrap flex-column flex-lg-row">

                <img src="{{ getSetting('logo_for_light') ? avatarImage(getSetting('logo_for_light')) : asset('frontend/assets/img/logo-light.png') }}"
                     alt="image"
                     class="logo__img"
                />

                <ul class="list-unstyled d-flex align-items-center justify-content-center flex-wrap gap-5 mb-0">
                    <li><a class="text-heading fw-normal text-decoration-none fs-14" href="{{ url("/") }}">{{ localize("Home") }}</a></li>
                    <li><a class="text-body fw-normal text-decoration-none fs-14" href="{{ route("about-us") }}">{{ localize('About Us') }}</a></li>
                    <li><a class="text-body fw-normal text-decoration-none fs-14" href="{{ route("pricing") }}">{{ localize('Pricing') }}</a></li>
                    <li><a class="text-body fw-normal text-decoration-none fs-14" href="{{ route("contact-us") }}">{{ localize('Contact Us') }}</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <p class="mb-0">{{ localize("Social Media") }} </p>
                    <div class="d-flex align-items-center gap-2">

                        @php
                            $fbLink = getSetting("facebook_link",null);
                            $twLink = getSetting("twitter_link",null);
                            $igLink = getSetting("instagram_link",null);
                            $liLink = getSetting("linkedin_link",null);
                        @endphp

                        @if($fbLink)
                            <a href="{{ $fbLink }}" class="social-item text-decoration-none text-white"><i class="lab la-facebook-f"></i></a>
                        @endif

                        @if($twLink)
                            <a href="{{ $twLink }}" class="social-item text-decoration-none text-white"><i class="lab la-twitter"></i></a>
                        @endif

                        @if($igLink)
                            <a href="{{ $igLink }}" class="social-item text-decoration-none text-white"><i class="lab la-instagram"></i></a>
                        @endif

                        @if($liLink)
                            <a href="{{ $liLink }}" class="social-item text-decoration-none text-white"><i class="lab la-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>