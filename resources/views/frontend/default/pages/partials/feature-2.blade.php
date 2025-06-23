<section class="pt-60 pb-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="feature-2 position-relative">
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
                    <div class="text-center mb-40">
                        <img src="{{ avatarImage(getSetting('favicon')) ?? asset('assets/img/favicon.png') }}" alt="image" class="img-fluid mb-3">
                        <h2 class="fs-48 mb-3">{{localize('WritRap Feature of AI.')}}</h2>
                        <p class="max-text-60 mx-auto mb-0">{{localize('Create unlimited short videos at once. Auto generate captions,
                            effects, background and music for you.')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            @for($i=1; $i<=6;$i++)
                @include("frontend.default.pages.partials.feature2.item", ["itemNo" => $i])
            @endfor
        </div>
    </div>
</section>