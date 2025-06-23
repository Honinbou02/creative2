<form action="{{ route('admin.wordpress-credentials.store') }}" method="POST" id="addWorpressCredentialForm">
    <div class="offcanvas offcanvas-end" id="addWorpressCredentialFormSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title">{{ localize('WordPress Setting') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />

            <div class="mb-3">
                <x-form.label for="url" label="{{ localize('URL') }}" isRequired=true />
                <x-form.input name="url" id="url"
                              type="text"
                              :placeholder="isset($urlExample)? $urlExample : 'https://themetags.com/wp-json/wp/v2/'"
                              value="{{isset($credential) ? $credential->url : ''}}"
                              showDiv=false
                />
                <small>{{ localize("Example URL : ") }} https://yourDomain.com/wp-json/wp/v2/</small>
            </div>
            <div class="mb-3">
                <x-form.label for="user_name" label="{{ localize('User') }}" isRequired=true />
                <x-form.input name="user_name" id="user_name"
                              type="text"
                              placeholder="{{ localize('User') }}"
                              value="{{isset($credential) ? $credential->user_name : ''}}"
                              showDiv=false
                />
            </div>
            <div class="mb-3">
                <x-form.label for="password" label="{{ localize('Password') }}" isRequired=true />
                <x-form.input name="password" id="password"
                              type="password"
                              placeholder="{{ localize('password') }}"
                              value="{{isset($credential) ? strMasking($credential->password) : ''}}"
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
