<form action="" method="POST" id="addAccountForm">
    <div class="offcanvas offcanvas-end" id="addAccountFromSidebar" tabindex="-1">
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title accountCanvasTitle">{{ localize('Add Account') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />

            <ul class="list-unstyled list-inline tt-package-switch-list mb-0 z-2 position-relative my-3">
                @php
                    $firstPlatform = null;
                @endphp
                @foreach ($platforms as $platform)
                    @if ($loop->first)
                        @php
                            $firstPlatform = $platform;
                        @endphp
                    @endif
                    @if (hasPlatformAccess($platform))
                        <li class="list-inline-item tt-active">
                            <input type="radio" class="newAccountBtn" name="new_account_form" data-type="{{ $platform->slug }}" id="{{ $platform->slug }}" value="{{ $platform->id }}" {{ $loop->first ? 'checked':'' }}>
                            <label for="{{ $platform->slug }}" class="px-3 py-2"><img src="{{ mediaImage($platform->icon_media_manager_id) }}" alt="{{ $platform->name }}" width="30"> {{ $platform->name }}</label>
                        </li>
                    @endif
                @endforeach
            </ul>

            <div class="mt-5" id="addAccountFormContainer">
                @php
                    $viewForm = 'socialpilot::accounts.forms.'.$firstPlatform->slug;
                @endphp
                @include($viewForm, ['platform' => $firstPlatform])
            </div>
        </div>
        <div class="offcanvas-footer border-top footer-form-submit-btn d-none">
            <div class="d-flex gap-3">
                <x-form.button type="submit" class="btn-sm" id="frmActionBtn"> <i data-feather='save'></i>{{ localize('Connect Account') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
