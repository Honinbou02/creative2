<h6>{{ localize("Searching Result Found ") }} : {{ $totalPosts ?? 0 }}</h6>
<ul class="list-group mt-2">
    @forelse($posts as $post)
        <li class="list-group-item py-2">
            <label for="postId{{ $post["id"] }}" class="d-flex align-items-center gap-2">
                <input type="radio"
                       name="wp_post_id"
                       id="postId{{ $post["id"] }}"
                       value="{{ $post["id"] }}"
                       @checked($loop->first)
                />
                <span class="fw-normal cursor-pointer">
                    <span class="badge {{ getPostStatusLabelClass($post["status"]) }}">{{ $post["status"] }}</span>
                    [{{ $post["id"] }}]
                    {{ $post["title"] }}
                </span>
                <a href="{{ $post["link"] }}" target="_blank">
                    <i data-feather="external-link" class="icon-14"></i>
                </a>
            </label>
        </li>
    @empty
    @endforelse
</ul>