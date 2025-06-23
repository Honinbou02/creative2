@forelse ($articleSocialPosts as $articleSocialPost)
    <li class="list-inline-item tt-active mt-4">
        <input type="radio" name="article_social_post_ids" id="social-post-{{ $articleSocialPost->id }}" value="{{ $articleSocialPost->id }}">
        <label for="social-post-{{ $articleSocialPost->id }}" class="text-body py-3 w-100">
            <div class="tt-post-name fw-bold position-absolute px-3 bg-light">
                <img src="{{ mediaImage($articleSocialPost->platform?->icon_media_manager_id) }}" alt="{{ $articleSocialPost->platform?->name }}" width="30"> {{ $articleSocialPost->platform?->name }}
            </div>
            @php
                echo $articleSocialPost->post_details;
            @endphp
            

            <div class="d-flex justify-content-end">
                <x-form.button type="button" class="px-3 py-1 rounded-pill create-social-post-btn" data-id="{{ $articleSocialPost->id }}" color="outline-primary">
                    <i data-feather="mouse-pointer" class="icon-14"></i>
                    {{ localize('Create Social Post') }}
                </x-form.button>
            </div>
        </label>
    </li>
    @empty
    <span>{{ localize('Your generated posts will appear here..') }}</span>
@endforelse