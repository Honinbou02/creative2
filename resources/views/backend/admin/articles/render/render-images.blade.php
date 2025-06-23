<div class="col-12">
    <div class="row g-2">
        @foreach ($images as $key => $item)
            @php
                $imgSrc = asset($item->file_path);
            @endphp
            <div class="col-4">

                <div data-bs-target="#offcanvasSelectedImage"
                     data-bs-toggle="offcanvas"
                     class="unsplashImageDiv rounded overflow-hidden"
                     data-src="{{ $imgSrc }}"
                     data-alt="Generated Image">
                    <img src="{{ $imgSrc }}"
                         class="img-fluid"
                         title="Generated Image"
                         alt="Generated Image"
                    />
                </div>
            </div>
        @endforeach
    </div>
</div>
