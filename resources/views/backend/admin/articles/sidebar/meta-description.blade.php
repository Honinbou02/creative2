<div class="row metaDescriptionsRow rowPadding">
    <div class="col-12">
        <h6>{{ localize('Meta Descriptions') }}</h6>
        <ul class="keyword-list render-meta_descriptions">
            @isset($metaDescriptions)
                @include('backend.admin.articles.render.render-meta-description', [
                    'metaDescriptions' => $metaDescriptions,
                ])
            @endisset
        </ul>
    </div>
</div>