<div class="row keywordsRow rowPadding">
    <div class="col-12 mb-3">
        <h6>{{ localize('Main Keywords') }}</h6>
        <ul class="keyword-list render-keywords">
            @isset($keywords)
                @include('backend.admin.articles.render.render-keywords', [
                    'keywords' => $keywords,
                ])
            @endisset
        </ul>
    </div>

    <div class="col-12 mb-3 pt-4">
        <h6>{{ localize('Related Keywords') }}</h6>
        <ul class="keyword-list related-keywords">
            @isset($keywords)
                @include('backend.admin.articles.render.render-keywords', [
                    'keywords' => $keywords,
                ])
            @endisset
        </ul>
    </div>
</div>
