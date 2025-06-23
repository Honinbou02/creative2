<!-- Feedback 1 -->
<section class="pb-60 px-10">
    <div class="animation-gradient rounded-3 overflow-hidden">
        <div class="feature-1-content pt-80 pb-80 rounded-3">
            <div class="container">
                <div class="row align-items-center justify-content-between g-4">
                    <div class="col-lg-6">
                        <div class="d-inline-block text-center px-5 py-1 rounded-pill border border-1 border-primary mb-4">
                            <p class="fs-14 fw-normal mb-0">{{localize('Testimonials')}}</p>
                        </div>
                        <h2 class="fs-48 mb-3">{{localize('Loved From Customers')}}</h2>
                        <p class="max-text-48 mb-5">
                            {{localize('We are loved from thousands customers worldwide and get trusted from big companies.')}}
                        </p>
                        <div class="row g-3">
                            <div class="col-md-5">
                                <h6 class="fs-36 mb-1">{{ localize("350k") }}+</h6>
                                <p class="text-uppercase fs-14 mb-0">{{ localize("Happy Customer") }}</p>
                            </div>
                            <div class="col-md-5">
                                <h6 class="fs-36 mb-1">{{ localize("4.6/5") }}</h6>
                                <p class="text-uppercase fs-14 mb-0">{{ localize("Total Rating") }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                        <div class="feedback-new swiper">
                            <div class="swiper-wrapper">
                                @forelse ($client_feedbacks as $feedback)
                                    <div class="swiper-slide">
                                        <div class="wt_card_style p-7 rounded-3">
                                            <div class="d-flex align-items-center gap-1 mb-2">
                                                {{ renderStarRatingFront($feedback->rating) }}
                                            </div>
                                            <p class="fs-16 mb-0">
                                                {{$feedback->review}}
                                            </p>
                                            <div class="d-flex align-items-center gap-4 mt-5">
                                                <img src="{{ avatarImage($feedback->avatar) }}" alt="Image" width="45" height="45" class="img-fluid">
                                                <div>
                                                    <h6 class="fs-18 mb-2">{{ $feedback->name }}</h6>
                                                    <p class="fs-12 mb-0">{{ $feedback->designation }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty

                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Feedback 1 -->