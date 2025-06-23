<div class="content-generator__sidebar-footer">
    <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
        <button class="btn btn-sm rounded-pill btn-primary saveChange" id="saveChangeBtn"> <i data-feather='save' class='icon-14'></i> {{localize('Save Changes')}}</button>
        @if (isModuleActive('WordpressBlog') &&  wpCredential())
            @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (!isCustomerUserGroup()))
                <button type="button"
                    class="btn btn-sm rounded-pill btn-secondary"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasPublishedToWordpress"
                    onclick="publishedBlogPost({{$article->id}}, {{ $article->wp_post_id ?? 0 }})">
                    <span title="{{localize('Upload to wordpress')}}"><i data-feather="trending-up" class="icon-14 me-1"></i>
                        {{ localize("Push to WordPress") }}</span>
                </button>
                <x-info-message labelTitle="{{ localize('Last Synced with WordPress') }}" labelText="{{ $article->wp_synced_at ? manageDateTime($article->wp_synced_at, 7) : localize('Not Synced Yet') }}" />
             @endif       
        @endif
    </div>
</div>