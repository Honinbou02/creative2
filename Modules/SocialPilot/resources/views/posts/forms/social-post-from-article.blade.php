<div class="row">
    <div class="col-12">
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <!-- social media -->
        <a href="javascript:void(0);" class="text-dark fw-medium">
            <span><i data-feather="share-2" class="icon-14"></i></span>
            {{ localize('Select Social Platforms') }}
        </a>

        <ul class="list-unstyled list-inline tt-package-switch-list mb-0 z-2 position-relative my-3">
            @foreach ($platforms as $platform)
                @if (hasPlatformAccess($platform))
                    <li class="list-inline-item tt-active">
                        <input type="checkbox" name="platform_ids[]" id="{{ $platform->slug }}" value="{{ $platform->id }}">
                        <label for="{{ $platform->slug }}" class="px-3 py-2"><img src="{{ mediaImage($platform->icon_media_manager_id) }}" alt="{{ $platform->name }}" width="30"> {{ $platform->name }}</label>
                    </li>
                @endif
            @endforeach
        </ul>

        <div class="mb-4"></div>
        <ul class="list-unstyled d-flex flex-column tt-package-switch-list tt-blog-post-wrap mb-0 position-relative mt-1 article-social-post-container">
            @include('socialpilot::posts._article_social_posts', ['articleSocialPosts' => $articleSocialPosts])
        </ul>
    </div>
</div>