<div class="content-generator__body order-2 order-md-1">
    <div class="content-generator__body-header">
        @include("backend.admin.seo.article.left-editor-option")
    </div>

    <div class="content-generator__body-content">
        <div id="contentGenerator">
            <?= $article->article ?>
        </div>
    </div>
    <x-form.input
            type="hidden"
            name="article_id"
            id="article_id"
            class="articleId"
            value="{{ $article->id }}"
    />
    @include("backend.admin.seo.article.left-button")
</div>