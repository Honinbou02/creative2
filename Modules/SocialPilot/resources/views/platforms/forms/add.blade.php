
{{-- <x-common.message class="mb-3" /> --}}
<div class="mb-3">
    <input type="hidden" name="id" value="{{ $platform?->id ?? null }}">
    <x-form.label for="icon_media_manager_id" label="{{ localize('Icon') }}"  />
    <div class="tt-image-drop rounded">
        <span class="fw-semibold">{{ localize('Choose Icon') }}</span>
        <!-- choose media -->
        <div class="tt-product-thumb show-selected-files mt-3">
            <div class="avatar avatar-xl cursor-pointer choose-media"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                onclick="showMediaManager(this)" data-selection="single">
                <input type="hidden" name="icon_media_manager_id" id="icon_media_manager_id" value="{{ $platform?->icon_media_manager_id ?? null }}">
                <div class="no-avatar rounded-circle">
                    <span><i data-feather="plus"></i></span>
                </div>
            </div>
        </div>
        <!-- choose media -->
    </div>
</div>