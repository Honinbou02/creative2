
<section class="pt-60 pb-120 position-relative z-2">
    <img src="{{ asset('frontend/assets/img/shape/faq_shape.png') }}" alt="Image" class="img-fluid faq_shape d-none d-md-block">
    <div class="container">
        <div class="position-relative">
            <div class="animation_box d-none d-xl-block">
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
                <div class="col-xl-6">
                    <div class="text-center mb-40">
                        <div class="d-inline-block text-center px-5 py-1 rounded-pill border border-1 border-primary mb-4">
                            <p class="fs-14 fw-normal mb-0">{{localize('FAQ')}}</p>
                        </div>

                        <h2 class="fs-48 mb-0">
                            {{localize('We’ve got you Covered,')}}
                            {{localize('24/7 Support')}}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="accordionExample">
                    @foreach ($faqs as $faq)
                        <div class="accordion-item wt_style rounded-3 overflow-hidden {{ !$loop->first ? 'mt-5':''}}">
                            <h2 class="accordion-header" id="headingOne{{$faq->id}}">
                                <button class="accordion-button bg-transparent {{$loop->first ? 'shadow-none' : 'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$faq->id}}" aria-expanded="{{$loop->first ? 'true' : 'false'}}" aria-controls="collapseOne{{$faq->id}}">
                                    <span class="text-white text-opacity-75 fw-semibold">{{$faq->question}}</span>
                                    <span class="plus ms-auto"><i class="las la-plus"></i></span>
                                    <span class="minus ms-auto"><i class="las la-minus"></i></span>
                                </button>
                            </h2>
                            <div id="collapseOne{{$faq->id}}" class="accordion-collapse collapse {{$loop->first ? 'collapse show' : 'collapse'}}" aria-labelledby="headingOne{{$faq->id}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body text-white text-opacity-75 pt-0">
                                    {{$faq->answer}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                   
                </div>
            </div>
        </div>
    </div>
</section>