@forelse($themes as $key=>$theme)
    <div class="themeDiv tt-item" data-theme_id="{{ $theme["label"] }}">
        <img src="{{ $theme["thumbnail"] }}"
                loading="lazy"
                class="img-fluid rounded-circle"
                alt="{{ $theme["label"] }}"/>
        <span class="fw-medium my-2 d-block">{{ $theme["label"] }}</span>
    </div>
@empty
@endforelse