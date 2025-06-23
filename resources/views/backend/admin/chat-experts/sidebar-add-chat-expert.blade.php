<form action="{{ route('admin.chat-experts.store') }}" method="POST" id="addExpertFrm">
    <div class="offcanvas offcanvas-end" id="addExpertFormSidebar" tabindex="-1">
            @csrf
            @method("POST")
            <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
            <div class="offcanvas-header border-bottom py-3">
                <h5 class="offcanvas-title">{{ localize('Add New Chat Expert') }}</h5>
                <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                    <i data-feather="x"></i>
                </span>
            </div>
            <x-common.splitter />
            <div class="offcanvas-body">
                <x-common.message class="mb-3" />

                <div class="mb-3">
                    <x-form.label for="expert_name" label="{{ localize('Expert Name') }}" isRequired=true />
                    <x-form.input name="expert_name" id="expert_name" type="text" placeholder="{{ localize('Expert Name') }}" value="" showDiv=false />
                </div>
                <div class="mb-3">
                    <x-form.label for="short_name" label="{{ localize('Expert Short Name') }}" isRequired=true />
                    <x-form.input name="short_name" id="short_name" type="text" placeholder="{{ localize('Expert Short Name') }}" value="" showDiv=false placeholder="EN" />
                </div>
                <div class="mb-3">
                    <x-form.label for="role" label="{{ localize('Expert Type') }}" isRequired=true />
                    <x-form.input name="role" id="role" type="text" placeholder="{{ localize('Expert Type') }}" value="" showDiv=false placeholder="SEO Expert" />
                </div>
                <div class="mb-3">
                    <div class="mb-4">
                        <x-form.label for="avatar" label="{{ localize('Avatar') }}"  />
                        <div class="tt-image-drop rounded">
                            <span class="fw-semibold">{{ localize('Choose Avatar') }}</span>
                            <!-- choose media -->
                            <div class="tt-product-thumb show-selected-files mt-3">
                                <div class="avatar avatar-xl cursor-pointer choose-media"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                    onclick="showMediaManager(this)" data-selection="single">
                                    <input type="hidden" name="avatar" id="avatar">
                                    <div class="no-avatar rounded-circle">
                                        <span><i data-feather="plus"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!-- choose media -->
                        </div>
    
                    </div>
                </div>
                <div class="mb-3">
                    <x-form.label for="description" label="{{ localize('Short Description') }}" />
                    <x-form.textarea name="description" id="description" row="5" cols="5" placeholder=""></x-form.textarea>
                </div>
                <div class="mb-3">
                    <x-form.label for="assists_with" label="{{ localize('Assist With Prompt') }}" isRequired=true />
                    <x-form.textarea name="assists_with" id="assists_with" row="5" cols="5" placeholder="I will assist you to generate better the seo contents"></x-form.textarea>
                </div>
                <div class="mb-3">
                    <x-form.label for="is_active" label="{{ localize('Status') }}" />
                    <x-form.select name="is_active" id="is_active">
                        @foreach (appStatic()::STATUS_ARR as $userStatusId => $userStatus)
                            <option value="{{ $userStatusId }}">{{ $userStatus }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="offcanvas-footer border-top">
                <div class="d-flex gap-3">
                    <x-form.button id="addExpertBtn">{{ localize('Save') }}</x-form.button>
                    <x-form.button color="secondary" type="reset">{{ localize('Reset') }}</x-form.button>
                </div>
            </div>
        </div>
</form>
