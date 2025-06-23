<div class="position-relative mt-2">

    <div class="swiper custom-swiper left-right-arrow"
        data-swiper='{
        "slidesPerView": 4,
        "centeredSlides": false,
        "spaceBetween": 1,
        "breakpoints":{"320":{"slidesPerView":2},  "540":{"slidesPerView":4}, "768":{"slidesPerView":5}, "991":{"slidesPerView":6}, "1200":{"slidesPerView":7}, "1440":{"slidesPerView":9}},
        "navigation": {"nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev"}
        }'>

        <div class="swiper-wrapper tt-template-category-slider">
            <div class="swiper-slide bg-secondary py-2 mb-1">
                <div class="tt-single-slider-item w-100 d-grid text-center">
                    <label class="tt-slider-label cursor-pointer getTemplates" for="category-all"
                        data-id="all">
                        <p class="mb-0 fw-medium tt-line-clamp tt-clamp-1 fs-md">{{ localize('All Template') }}</p>
                    </label>
                </div>
            </div>
            @foreach ($template_categories as $item)
                <div class="swiper-slide bg-secondary py-2 mb-1">
                    <div class="tt-single-slider-item w-100 d-grid text-center">
                        <label class="tt-slider-label cursor-pointer getTemplates"
                            for="category-{{ $item->id }}" data-id="{{ $item->id }}">
                            <p class="mb-0 fw-medium tt-line-clamp tt-clamp-1 fs-md">{{ $item->category_name }}</p>
                        </label>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <!--navigation buttons-->
    <div class="tt-slider-indicator">
        <div class="swiper-button-next custom-shadow"></div>
        <div class="swiper-button-prev custom-shadow"></div>
    </div>
</div>
