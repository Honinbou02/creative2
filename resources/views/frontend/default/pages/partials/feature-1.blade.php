<section class="feature-1-area px-10 position-relative z-1">
    <div class="animation-gradient rounded-3 overflow-hidden">
        <div class="feature-1 feature-1-content pt-80 pb-80 rounded-3">

            @include("frontend.default.pages.partials.feature1.feature1")

            <div class="container">
                <div class="row g-3">
                    @include("frontend.default.pages.partials.feature1.item1")

                    @for($i=3; $i<=7; $i++)
                        @include("frontend.default.pages.partials.feature1.common-item",["itemNo" => $i])
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>