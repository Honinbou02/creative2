<div class="row g-3">
    <div class="col-auto flex-grow-1 mb-3">
        <x-form.input name="search_keyword" value="{{ old('search_keyword') }}" class="wpSearchKeyword" isRequired="true" placeholder="{{ localize('Searching post title or slug') }}" />
    </div>

    <div class="col-auto">
        <button type="button" class="btn btn-sm btn-primary findWordpressPostBtn"> <i data-feather="search" class="icon-14"></i> {{ localize("Find") }}</button>
    </div>

    <div class="col-lg-12 mt-3">
        <div id="wordpressSearchResult"></div>
    </div>
</div>
