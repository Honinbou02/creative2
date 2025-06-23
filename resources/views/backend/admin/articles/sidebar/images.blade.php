<div class="row imagesRow rowPadding">
    <div class="render-images">
        @isset($images)
            @include('backend.admin.articles.render.render-images', [
                'images' => $images,
            ])
        @endisset
    </div>
</div>