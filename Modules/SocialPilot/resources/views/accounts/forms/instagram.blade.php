<div class="d-flex justify-content-center flex-column h-100 align-items-center">
    <input type="hidden" name="platform_id" value="{{ $platform?->id }}">
    <input type="hidden" name="type" value="{{ $platform?->slug }}">

    <a href="{{ route('social.accounts.connect', ['platform' => 'instagram']) }}" class="border bg-secondary btn btn-outline px-4 py-2 rounded-pill">
        <div class="d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/instagram-logo.webp') }}" alt="instagram" width="32px" class="img-fluid me-2">
            <span class="h6 mb-0">{{ localize('Business or Creator Profiles') }}</span>
        </div>
    </a>
</div>