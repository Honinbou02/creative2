<section class="bg-gray-100 pt-120 pb-120 rounded-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-dark mb-8">{{localize('Beautiful documentation That converts users')}} <span><img src="{{asset('frontend/assets/img/shape/title-shape-1.png')}}" alt="" class=""></span></h2>
                
            </div>
            <div class="col-12">
                <div class="position-relative mt-10">
                    @if(getSetting('feature_document_1_is_active') != 0)
                    <div class="documentation-item bg-white px-12 py-12 rounded-3 position-sticky">
                        <div class="documentation__top">
                            <svg width="100%" height="100%" viewBox="0 0 948 198" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M947.485 0H245.196L-6.55958e-05 198H947.485V0Z" fill="#fff"></path>
                            </svg>
                        </div>
                        <div class="row align-items-center g-4">
                            <div class="col-lg-6">
                                <h3 class="text-dark mb-4">{{systemSettingsLocalization('feature_document_1_title')}}✨</h3>
                                <p class="text-secondary mb-8">{{ systemSettingsLocalization('feature_document_1_short_description') }}</p>
                                <a class="btn btn-outline-secondary fw-semibold px-6 rounded-3 d-inline-flex align-items-center gap-1 border border-dark border-opacity-10" href="#" role="button">Generate Image <i class="las la-angle-right fs-12"></i></a>
                            </div>
                            <div class="col-lg-6">
                                <img src="{{avatarImage(getSetting('feature_document_1_image'))}}" alt="image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(getSetting('feature_document_2_is_active') != 0)
                    <div class="documentation-item bg-white px-12 py-12 rounded-3 position-sticky">
                        <div class="documentation__top">
                            <svg width="100%" height="100%" viewBox="0 0 948 198" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M947.485 0H245.196L-6.55958e-05 198H947.485V0Z" fill="#fff"></path>
                            </svg>
                        </div>
                        <div class="row align-items-center g-4">
                            <div class="col-lg-6">
                                <h3 class="text-dark mb-4">{{systemSettingsLocalization('feature_document_2_title')}}✨</h3>
                                <p class="text-secondary mb-8">{{ systemSettingsLocalization('feature_document_2_short_description') }}</p>
                                <a class="btn btn-outline-secondary fw-semibold px-6 rounded-3 d-inline-flex align-items-center gap-1 border border-dark border-opacity-10" href="#" role="button">Generate Image <i class="las la-angle-right fs-12"></i></a>
                            </div>
                            <div class="col-lg-6">
                                <img src="{{avatarImage(getSetting('feature_document_2_image'))}}" alt="image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(getSetting('feature_document_3_is_active') != 0)
                    <div class="documentation-item bg-white px-12 py-12 rounded-3 position-sticky">
                        <div class="documentation__top">
                            <svg width="100%" height="100%" viewBox="0 0 948 198" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M947.485 0H245.196L-6.55958e-05 198H947.485V0Z" fill="#fff"></path>
                            </svg>
                        </div>
                        <div class="row align-items-center g-4">
                            <div class="col-lg-6">
                                <h3 class="text-dark mb-4">{{systemSettingsLocalization('feature_document_3_title')}}🎙️</h3>
                                <p class="text-secondary mb-8">{{ systemSettingsLocalization('feature_document_3_short_description') }} </p>
                                <a class="btn btn-outline-secondary fw-semibold px-6 rounded-3 d-inline-flex align-items-center gap-1 border border-dark border-opacity-10" href="#" role="button">Generate Image <i class="las la-angle-right fs-12"></i></a>
                            </div>
                            <div class="col-lg-6">
                                <img src="{{avatarImage(getSetting('feature_document_3_image'))}}" alt="image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(getSetting('feature_document_4_is_active') != 0)
                    <div class="documentation-item bg-white px-12 py-12 rounded-3 position-sticky">
                        <div class="documentation__top">
                            <svg width="100%" height="100%" viewBox="0 0 948 198" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M947.485 0H245.196L-6.55958e-05 198H947.485V0Z" fill="#fff"></path>
                            </svg>
                        </div>
                        <div class="row align-items-center g-4">
                            <div class="col-lg-6">
                                <h3 class="text-dark mb-4">{{systemSettingsLocalization('feature_document_4_title')}}</h3>
                                <p class="text-secondary mb-8">{{ systemSettingsLocalization('feature_document_4_short_description') }} </p>
                                <a class="btn btn-outline-secondary fw-semibold px-6 rounded-3 d-inline-flex align-items-center gap-1 border border-dark border-opacity-10" href="#" role="button">Generate Image <i class="las la-angle-right fs-12"></i></a>
                            </div>
                            <div class="col-lg-6">
                                <img src="{{avatarImage(getSetting('feature_document_4_image'))}}" alt="image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>