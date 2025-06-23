<form action="{{ route('admin.wordpress-settings.store') }}" method="POST" id="addWorpressSettingForm">
    <div class="offcanvas offcanvas-end" id="addWorpressSettingFormSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title">{{ localize('Wordpress Credantails') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />

            <div class="mb-3">
                <x-form.label for="domain" label="{{ localize('URL') }}" isRequired=true />
                <x-form.input name="domain" id="domain"
                              type="text"
                              placeholder="{{ 'www.themetags.com' }}"
                              value=""
                              showDiv=false
                />
            </div>
            <div class="mb-3">
                <x-form.label for="user" label="{{ localize('User') }}" isRequired=true />
                <x-form.input name="user" id="user"
                              type="text"
                              placeholder="{{ localize('User') }}"
                              value=""
                              showDiv=false
                />
            </div>
            <div class="mb-3">
                <x-form.label for="password" label="{{ localize('Password') }}" isRequired=true />
                <x-form.input name="password" id="password"
                              type="text"
                              placeholder="{{ localize('password') }}"
                              value=""
                              showDiv=false
                />
            </div>

            <div class="mb-3">
                <x-form.label for="is_active" label="{{ localize('Status') }}" />
                <x-form.select name="is_active" id="is_active">
                    @foreach (appStatic()::STATUS_ARR as $dataStatusId => $dataStatus)
                        <option value="{{ $dataStatusId }}">{{ $dataStatus }}</option>
                    @endforeach
                </x-form.select>
            </div>
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button id="frmActionBtn">{{ localize('Save') }}</x-form.button>
                <x-form.button color="secondary" type="reset">{{ localize('Reset') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
