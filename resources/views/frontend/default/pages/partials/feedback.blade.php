@isset($client_feedbacks)
<section class="pt-60">
    <div class="container">
        @if(count($client_feedbacks) > 0)
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center mb-10">
                    <h2 class="text-white mb-0">{{localize('Writerap AI Loved by Thinkers')}}</h2>
                </div>
            </div>
        </div>
        @endif
        <div class="feedback-overlay position-relative">
            <div class="row">
                <div class="col-lg-12">
                    <div class="feedback-scroll scrollbar-hide">
                        <div class="feedback-wrapper">
                            @foreach ($client_feedbacks as $feedback)
                            <div class="d-inline-block px-8 py-10 border border-white border-opacity-25 rounded-3 mt-6">
                            
                                <div class="d-flex align-items-center justify-content-between gap-4 mb-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ avatarImage($feedback->avatar) }}" width="35" height="35" alt="image"
                                            class="img-fluid">
                                        <div>
                                            <h6 class="text-white mb-0">{{ $feedback->name }}</h6>
                                            <p class="mb-0"><ul class="list-unstyled d-flex">{{ renderStarRatingFront($feedback->rating) }}</ul></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-4">{{ $feedback->review }}</p>
                                <div class="d-flex align-items-center gap-3">
                                    <p class="mb-0">{{ dateFormat($feedback->created_at) }}</p>
                                </div>
                            </div>
                            @endforeach
                           
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endisset
