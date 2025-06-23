<form action="{{ route('admin.info-update') }}" method="POST" id="updateUserInfo">
    @csrf
    <x-common.message class="mb-3" />

    <div class="mb-3">
        <x-form.label for="name" label="{{ localize('Name') }}" isRequired=true />
        <x-form.input name="name" id="name" type="text" placeholder="{{ localize('Name') }}"
            value="{{ $user->name }}" showDiv=false />
    </div>
    <div class="mb-3">
        <x-form.label for="email" label="{{ localize('Email') }}" isRequired=true />
        <x-form.input name="email" type="email" id="email" placeholder="{{ localize('Email') }}"
            value="{{ $user->email }}" showDiv=false />
    </div>

    <div class="mb-3">
        <x-form.label for="mobile_no" label="{{ localize('Mobile Number') }}" />
        <x-form.input name="mobile_no" id="mobile_no" type="text" placeholder="{{ localize('Mobile Number') }}"
            value="{{ $user->mobile_no }}" showDiv=false />
    </div>
    <div class="mb-3">
        <div class="mb-4">
            <x-form.label for="avatar" label="{{ localize('Avatar') }}" />
            <div class="tt-image-drop rounded">
                <span class="fw-semibold">{{ localize('Choose Avatar') }}</span>
                <!-- choose media -->
                <div class="tt-product-thumb show-selected-files mt-3">
                    <div class="avatar avatar-xl cursor-pointer choose-media" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasBottom" onclick="showMediaManager(this)" data-selection="single">
                        <input type="hidden" name="avatar" id="avatar" value="{{ $user->avatar }}">
                        <div class="no-avatar rounded-circle">
                            <span><i data-feather="plus"></i></span>
                        </div>
                    </div>
                </div>
                <!-- choose media -->
            </div>

        </div>
    </div>
    <div class="d-flex gap-3">
        <x-form.button id="addUserBtn">{{ localize('Update') }}</x-form.button>
    </div>
</form>
