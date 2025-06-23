<ul class="nav nav-line-tab fw-medium border-bottom" id="myTab" role="tablist">
    <li class="nav-item">
        <a href="#stock-image" class="nav-link active image-platform" data-bs-toggle="tab" aria-selected="true" data-platform="unsplash">
            {{ localize("Unsplash Image") }}
        </a>
    </li>

    <li class="nav-item">
        <a href="#stock-image" class="nav-link image-platform" data-bs-toggle="tab" aria-selected="true" data-platform="pexels">
            {{ localize("Pexels Image") }}
        </a>
    </li>

    <li class="nav-item">
        <a href="#ai-image" class="nav-link" data-bs-toggle="tab" aria-selected="false">
            {{ localize("AI Image") }}
        </a>
    </li>
</ul>

<div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade show active" id="stock-image" role="tabpanel" aria-labelledby="stock-image-tab">
        <div class="row g-2">
            <div class="col-auto flex-grow-1">
                <x-form.input type="text"
                              class="form-control form-control-sm"
                              id="stockImage"
                              name="stock_image"
                              value="{{ isset($editArticle) ? $editArticle->stock_image : '' }}"
                              placeholder="{{ localize('Search Stock Images') }}" />
            </div>

            <div class="col-auto">
                <x-form.button class="btn btn-primary" id="searchStockImage" type="button">
                    {{ localize('Search') }}
                </x-form.button>
            </div>

            <div class="col-lg-12 mb-3">
                {{-- Static Data --}}
                <div class="aiImageSearchResult">
{{--                    <div class="unsplashImageMainDiv row  g-2">--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1562577309-2592ab84b1bc?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHwxfHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" data-alt="SEO text wallpaper">--}}
{{--                                <img src="https://images.unsplash.com/photo-1562577309-2592ab84b1bc?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHwxfHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" class="img-fluid" alt="SEO text wallpaper">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1686061594183-8c864f508b00?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHwyfHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" data-alt="a close up of a computer screen with a blurry background">--}}
{{--                                <img src="https://images.unsplash.com/photo-1686061594183-8c864f508b00?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHwyfHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" class="img-fluid" alt="a close up of a computer screen with a blurry background">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1557838923-2985c318be48?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHwzfHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" data-alt="digital marketing artwork on brown wooden surface">--}}
{{--                                <img src="https://images.unsplash.com/photo-1557838923-2985c318be48?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHwzfHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" class="img-fluid" alt="digital marketing artwork on brown wooden surface">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1624555130581-1d9cca783bc0?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw0fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" data-alt="people sitting at the table">--}}
{{--                                <img src="https://images.unsplash.com/photo-1624555130581-1d9cca783bc0?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw0fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" class="img-fluid" alt="people sitting at the table">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1506645292803-579c17d4ba6a?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw1fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" data-alt="MacBook Pro">--}}
{{--                                <img src="https://images.unsplash.com/photo-1506645292803-579c17d4ba6a?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw1fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" class="img-fluid" alt="MacBook Pro">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1666153658042-88ac77d56b92?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw2fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" data-alt="a man standing in front of a wall of fish">--}}
{{--                                <img src="https://images.unsplash.com/photo-1666153658042-88ac77d56b92?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw2fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" class="img-fluid" alt="a man standing in front of a wall of fish">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1712571664162-602064e30014?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw3fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" data-alt="a close up of a sign with grass on it">--}}
{{--                                <img src="https://images.unsplash.com/photo-1712571664162-602064e30014?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw3fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" class="img-fluid" alt="a close up of a sign with grass on it">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1686061593213-98dad7c599b9?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw4fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" data-alt="a computer screen with a bunch of data on it">--}}
{{--                                <img src="https://images.unsplash.com/photo-1686061593213-98dad7c599b9?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw4fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" class="img-fluid" alt="a computer screen with a bunch of data on it">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1666153658121-26d5583848ae?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw5fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" data-alt="a group of people outside a building">--}}
{{--                                <img src="https://images.unsplash.com/photo-1666153658121-26d5583848ae?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHw5fHxTRU98ZW58MHx8fHwxNzM3MjA3MDE2fDA&amp;ixlib=rb-4.0.3" class="img-fluid" alt="a group of people outside a building">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-md-4">--}}
{{--                            <div data-bs-target="#offcanvasSelectedImage" data-bs-toggle="offcanvas" class="unsplashImageDiv  rounded overflow-hidden" data-src="https://images.unsplash.com/photo-1495435093359-6d56a94830c2?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHwxMHx8U0VPfGVufDB8fHx8MTczNzIwNzAxNnww&amp;ixlib=rb-4.0.3" data-alt="a couple of tall buildings sitting next to each other">--}}
{{--                                <img src="https://images.unsplash.com/photo-1495435093359-6d56a94830c2?ixid=M3w2OTYzNjR8MHwxfHNlYXJjaHwxMHx8U0VPfGVufDB8fHx8MTczNzIwNzAxNnww&amp;ixlib=rb-4.0.3" class="img-fluid" alt="a couple of tall buildings sitting next to each other">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="ai-image" role="tabpanel" aria-labelledby="ai-image-tab">

        <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">
            <x-form.label for="image" class="form-label flex-shrink-0 mb-0">
                {{ localize('Image') }} </x-form.label>

            <x-common.small-btn id="addFrmOffCanvas" data-content-purpose="image" id="image" data-bs-target="#addFormSidebar"></x-common.small-btn>
        </div>
        <div class="input-group input--group input--group-sm flex-shrink-0">
                        <span class="input-group-text lh-1">
                            <span class="material-symbols-rounded">
                                info
                            </span>
                        </span>
            <input type="text" class="form-control form-control-sm" name="image_prompt" id = "image_prompt"
                   placeholder="{{ localize('Ex: writerap Image') }}">
        </div>
    </div>
</div>