<div class="d-flex justify-content-center flex-column h-100 align-items-center">
    <input type="hidden" name="platform_id" value="{{ $platform?->id }}">
    <input type="hidden" name="type" value="{{ $platform?->slug }}">

    <a href="{{ route('social.accounts.connect', ['platform' => 'linkedin']) }}" class="border bg-secondary btn btn-outline px-4 py-2 rounded-pill">
        <div class="d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/linkedin-logo.webp') }}" alt="twitter" width="32px" class="img-fluid me-2">
            <span class="h6 mb-0">{{ localize('LinkedIn 0auth') }}</span>
        </div>
    </a>
</div>