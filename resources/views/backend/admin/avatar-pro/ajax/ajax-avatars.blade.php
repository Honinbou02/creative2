@forelse($avatars as $key=>$avatar)
    <div class="avatarDiv tt-avatar-item" data-avatar_id="{{ $avatar["avatar_id"] }}">
        <div class="avatarImg mb-1">
            <img src="{{ $avatar["preview_image_url"] }}" alt="{{ $avatar['avatar_id'] }}">
        </div>
        <p class="m-0 fs-sm">{{ $avatar["avatar_name"] }} ({{ $avatar["gender"] }})</p>
    </div>
@empty
    <p class="m-0">{{ localize("No avatars found") }}</p>
@endforelse