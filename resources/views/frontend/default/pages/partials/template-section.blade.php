<section class="template-1 pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-inline-block text-center px-5 py-1 rounded-pill border border-1 border-primary mb-4">
                    <p class="fs-14 fw-normal mb-0">{{ localize('Template') }}</p>
                </div>

                <h2 class="fs-48 mb-3">{{localize('Ultimate tool for Social Media growth')}}</h2>
                <p class="max-text-60 mb-5">{{localize('Create unlimited short videos at once. Auto generate captions, effects, background and music for you.')}}</p>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-12">
                <div class="template-tab">
                    <ul class="nav nav-pills gap-3 px-3 py-5 rounded-2" id="myTab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <a href="#"
                               class="nav-link text-body px-5 rounded-pill getTemplates active"
                               data-bs-toggle="pill"
                               data-bs-target="#template-1"
                               type="button"
                               role="tab"
                               aria-selected="true">
                                <span class="d-flex align-items-center gap-2">
                                <img src="{{asset('frontend/assets/img/shape/template-icon-1.png')}}" alt="icon" class="img-fluid">
                                <img src="{{asset('frontend/assets/img/shape/template-icon-1-color.png')}}" alt="icon" class="img-fluid">
                                {{localize('All')}}
                            </span>
                            </a>
                        </li>

                        @foreach ($template_categories as $category)
                            <li class="nav-item" role="presentation">
                                <a href="#"
                                   class="nav-link text-body px-5 rounded-pill getTemplates"
                                   data-id="{{$category->id}}"
                                   data-bs-toggle="pill"
                                   data-bs-target="#{{ $category->slug }}"
                                   type="button"
                                   role="tab"
                                   aria-selected="true">
                                    <span class="d-flex align-items-center gap-2">
                                        @if ($category->icon)
                                            {!! $category->icon !!}
                                        @else
                                            <img src="{{asset('frontend/')}}/assets/img/shape/template-icon-2.png"
                                                 alt="icon"
                                                 class="img-fluid">
                                            <img src="{{asset('frontend/')}}/assets/img/shape/template-icon-2-color.png"
                                                 alt="icon"
                                                 class="img-fluid">
                                        @endif
                                        {{ $category->category_name }}
                                    </span>
                                </a>
                            </li>
                        @endforeach

                    </ul>
                    <div class="tab-content mt-10" id="myTabContent">
                        <div class="tab-pane fade active show" id="template-1" role="tabpanel">
                            <div class="row g-3" id="renderTemplates">
                               
                            </div>

                            <div class="text-center position-relative z-1">
                                <a href="{{route('admin.templates.index')}}"
                                   class="btn btn-outline-light rounded-pill border-light border-opacity-25 fw-semibold d-inline-flex align-items-center gap-2 text-light">
                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.904541" width="24" height="24" rx="12" fill="url(#paint0_linear_1780_21102)"></rect>
                                        <path d="M7.34365 11.6523C7.34365 11.6523 13.3527 11.6523 18.7722 11.6523M18.7722 11.6523C14.8572 11.6523 14.1345 7.65234 14.1345 7.65234M18.7722 11.6523C14.8572 11.6523 14.1345 15.6523 14.1345 15.6523" stroke="white" stroke-width="1.1"></path>
                                        <defs>
                                            <linearGradient id="paint0_linear_1780_21102" x1="0.904541" y1="12" x2="24.9045" y2="12" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#202877"></stop>
                                                <stop offset="0.360189" stop-color="#372E95"></stop>
                                                <stop offset="0.536415" stop-color="#5331B1"></stop>
                                                <stop offset="1" stop-color="#9629E6"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    {{ localize('Try it Now') }}
                                </a>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>