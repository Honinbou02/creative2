<form action="{{ route('admin.chat-categories.store') }}" method="POST" id="addFrm">
    <div class="offcanvas offcanvas-end" id="addFormSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title">{{ localize('Add New Chat Category') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />

            <div class="mb-3">
                <x-form.label for="name" label="{{ localize('Title') }}" isRequired=true />
                <x-form.input id="name" name="name"
                              type="text"
                              placeholder="{{ localize('Title') }}"
                              value=""
                              showDiv=false
                />
            </div>
          

            <div class="mb-3">
                <x-form.label for="prompt_group_id" label="{{ localize('Group') }}" />
                <x-form.select name="prompt_group_id" id="prompt_group_id">
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                    @endforeach
                </x-form.select>
            </div>
            <div class="mb-3">
                <x-form.label for="prompt"
                label="{{ localize('Prompt') }}" isRequired=true />
                <x-form.textarea name="description" class="form-control" id="prompt" value="" placeholder="Write a blog about [blog title]"
                rows="10" />
                <span>{{localize('*Put your variables inside third bracket: Write a blog about [blog title]')}}</span>
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
