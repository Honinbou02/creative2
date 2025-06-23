<!-- Hero 1 -->
<section class="hero-1 position-relative z-1 pb-0">
    <div class="container">
        <div class="position-relative">
            <div class="animation_box d-none d-lg-block">
                <span class="animation_box-item bg-style"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item bg-style"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item bg-style"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item bg-style"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item bg-style"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item bg-style"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item bg-style"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item bg-style"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
                <span class="animation_box-item"></span>
            </div>
            <div class="row justify-content-center">
                <div class="col-xxl-8">
                    <div class="text-center">
                        <h1 class="mb-4"><?= systemSettingsLocalization('hero_title') ?></h1>
                        <p class="mb-0 fs-18 text-primary-300 max-text-60 mx-auto">
                            <?=systemSettingsLocalization('hero_sub_title')?>
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-center gap-6 flex-wrap mt-10">
                        <a class="btn btn-lg bg-gradient-1 border-0 rounded-pill d-flex align-items-center gap-2 text-white text-opacity-75 fs-14 fw-normal"
                           href="{{ getSetting("hero_sub_title_btn_link") }}" role="button">
                            {{ getSetting("hero_sub_title_btn_text") }}
                            <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.357144 7C0.357144 7 9.37073 7 17.5 7M17.5 7C11.6275 7 10.5435 1 10.5435 1M17.5 7C11.6275 7 10.5435 13 10.5435 13" stroke="#cfcfcf" stroke-width="1.6" />
                            </svg>
                        </a>
                        <a href="{{ getSetting("hero_build_ai_btn_link") }}" class="btn btn-lg btn-outline-light rounded-pill px-8 border-primary btn-svg-hover d-flex align-items-center gap-2 fw-normal text-heading fs-14">
                            {{ getSetting("hero_build_ai_btn_text") }}
                            <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.357144 7C0.357144 7 9.37073 7 17.5 7M17.5 7C11.6275 7 10.5435 1 10.5435 1M17.5 7C11.6275 7 10.5435 13 10.5435 13" stroke="#cfcfcf" stroke-width="1.6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="pt-15">
                <div class="d-flex justify-content-center">
                    <div class="d-inline-block animation-gradient rounded-3 overflow-hidden">
                        <div class="bg-secondary p-2 position-relative rounded-3 z-2">
                            <img src="{{avatarImage(getSetting('hero_background_image')) ?? asset('frontend/assets/img/bg-dark.png')}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /Hero 1 -->
