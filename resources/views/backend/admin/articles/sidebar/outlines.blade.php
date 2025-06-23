<div class="row outlinesRow rowPadding">
    <div class="col-12">
        <h6>{{ localize('Outlines') }}</h6>
        <ul class="p-0 m-0 list-unstyled render-outlines">
            @isset($outlines)
                @include('backend.admin.articles.render.render-outlines', [
                    'outlines' => $outlines,
                ])
            @endisset
        </ul>
    </div>
</div>