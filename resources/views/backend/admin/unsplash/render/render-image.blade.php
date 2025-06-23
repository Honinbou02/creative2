<div class="unsplashImageMainDiv row  g-2">
    @forelse($unsplashImages ?? [] as $key => $unsplashImage)
        <div class="col-4 col-md-4">
            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden"
                 data-src="{{ $unsplashImage["raw"] }}"
                 data-alt="{{ $unsplashImage["alt_description"] }}">
                <img src="{{ $unsplashImage['raw'] }}"
                     class="img-fluid"
                     title="{{ $unsplashImage["alt_description"] }}"
                     alt="{{ $unsplashImage["alt_description"] }}" />
            </div>
        </div>
    @empty
    @endforelse
</div>
