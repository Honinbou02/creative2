<form action="{{ route('admin.templates.store') }}" method="POST" id="addTemplateFrm">
    <div class="offcanvas offcanvas-end" id="addTemplateFormSidebar" tabindex="-1">
        @csrf
        @method('POST')
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title">{{ localize('Add New Template') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />

            <div class="mb-3">
                <x-form.label for="template_name" label="{{ localize('Template Name') }}" isRequired=true />
                <x-form.input name="template_name" id="template_name" type="text"
                    placeholder="{{ localize('Template Name') }}" value="" showDiv=false />
            </div>
            <div class="mb-3">
                <x-form.label for="icon" label="{{ localize('Icon') }}"  />
                <span><a href="https://icons8.com/line-awesome" target="_blank" rel="noopener noreferrer">{{localize('Get Icons')}}</a></span>

                <x-form.input name="icon" id="icon"
                            type="text"
                            placeholder='<i class="las la-info-circle"></i>'
                            value=""
                            showDiv=false
                />
            </div>
            <div class="mb-3">
                <x-form.label for="template_category_id" label="{{ localize('Category') }}" />
                <x-form.select name="template_category_id" id="template_category_id">
                    @foreach ($template_categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </x-form.select>
            </div>
            <div class="mb-3">
                <x-form.label for="description" label="{{ localize('Description') }}" />
                <x-form.textarea name="description" id="description" row="5" cols="5"
                    placeholder=""></x-form.textarea>
            </div>
            <input type="hidden" id="div_count" value="1">
            <div class="row g-2" id="defaultField">
                <div class="col-md-4">
                    <div class="mb-3">
                        <x-form.label for="input_types" label="{{ localize('Input Type') }}" />
                        <x-form.select name="input_types[]" id="input_types">
                            @foreach (appStatic()::INPUT_TYPES as $value => $intputType)
                                <option value="{{ $value }}">{{ $intputType }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <x-form.label for="input_names[]" label="{{ localize('Input Name') }}" isRequired=true />
                        <x-form.input name="input_names[]" id="input_names[]" onchange="generateInputNames(true)" type="text"
                            placeholder="{{ localize('Input Name') }}" value="" showDiv=false />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <x-form.label for="input_labels[]" label="{{ localize('Input Label') }}" isRequired=true />
                        <x-form.input name="input_labels[]" id="input_labels[]" type="text"
                            placeholder="{{ localize('Input Label') }}" value="" showDiv=false />
                    </div>
                </div>


            </div>
            {{-- append extra fields --}}
            <div class="input-type" id="input-type-append">

            </div>
            {{-- end --}}

           
             <div class="d-flex align-items-center tt-advance-options cursor-pointer my-3 addMoreButton" >
                    <label for="tt-advance-options" id="addMoreButton"
                           class="form-label cursor-pointer btn btn-sm btn-secondary rounded-pill fw-medium">
                           {{ localize('Add More') }} <i data-feather="plus" class="icon-14 ms-1"></i></label>

                </div>
            <div class="mb-3">
                <h5 class="mb-4">{{ localize('Prompt Information') }}</h5>

                <div class="mb-4 hint d-none">
                    <label class="form-label">{{ localize('Input Variables') }}</label>
                    <div class="mb-1 input_names_prompts">
                    </div>
                    <small>*
                        {{ localize('Click on variable to set the user input of it in your prompts') }}</small>
                </div>
                
                <x-form.label for="prompt" label="{{ localize('Prompt') }}" isRequired=true />
                <x-form.textarea name="prompt" id="prompt" row="5" cols="5"
                    placeholder="I will assist you to generate better the seo contents"></x-form.textarea>
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
                <x-form.button id="addTemplateBtn">{{ localize('Save') }}</x-form.button>
                <x-form.button color="secondary" type="reset">{{ localize('Reset') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
