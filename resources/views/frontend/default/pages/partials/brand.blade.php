@isset($brands)
    <section class="pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="text-center">
                        <h6 class="fs-16 fw-500 mb-10">{{ systemSettingsLocalization('brand_text_without_color') }}
                            <span class="text-primary">
                                {{ systemSettingsLocalization('brand_text_with_color') }}
                            </span>
                        </h6>
                    </div>

                    <div class="d-flex align-items-center justify-content-center gap-6 gap-xl-10 flex-wrap">
                        @foreach ($brands as $item)
                            <div class="brand-logo">
                                <img src="{{avatarImage($item)}}" alt="logo" class="img-fluid">
                                <img src="{{avatarImage($item)}}" alt="logo" class="img-fluid">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endisset