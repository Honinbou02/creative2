<div class="pt-120  pb-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="text-center mb-40">
                    <img src="{{ avatarImage(getSetting('favicon')) ?? asset('frontend/assets/img/shape/ai-lg-logo.png') }}" alt="image" class="img-fluid mb-3">
                    <h2 class="fs-48 mb-3">{{localize('Multiple AI Tools')}}</h2>
                    <p class="max-text-60 mx-auto mb-0">{{localize('Create unlimited short videos at once. Auto generate captions, effects, background and music for you.')}}</p>
                </div>
            </div>
        </div>
        <div class="row g-3">
            @for($i=1; $i<=3; $i++)
                @include("frontend.default.pages.partials.aiTools.item",["itemNo" => $i])
            @endfor

            @include("frontend.default.pages.partials.aiTools.item4",["itemNo" => 4])
            @include("frontend.default.pages.partials.aiTools.item5",["itemNo" => 5])
        </div>
    </div>
</div>