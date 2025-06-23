<div class="row titlesRow rowPadding">
    <div class="col-12">
        <h6>{{ localize('Generated Titles') }}</h6>
        <ul class="keyword-list render-titles">
            @isset($titles)
                @include('backend.admin.articles.render.render-titles', [
                    'titles' => $titles,
                ])
            @endisset
        </ul>
    </div>
</div>