<form action="{{ route('admin.blogs.store') }}" method="POST" id="addBlogForm">
    <div class="offcanvas offcanvas-end" id="addBlogFormSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">{{ localize('Add New Article') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />

            <div class="mb-3">
                <x-form.label for="title" label="{{ localize('Title') }}" isRequired=true />
                <x-form.input name="title" id="title"
                              type="text"
                              placeholder="{{ localize('Title') }}"
                              value=""
                              showDiv=false
                />
            </div>
            <div class="mb-3">
                <x-form.label for="blog_category_id" label="{{ localize('Category') }}" isRequired=true />
                <x-form.select name="blog_category_id" id="blog_category_id">
                    @foreach ($blog_categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-form.select>
            </div>
            <div class="mb-3">
                <x-form.label for="tag_ids" label="{{ localize('Tags') }}" />
                <x-form.select name="tag_ids[]" id="tag_ids" class="select2" multiple>
                    @foreach ($tags as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-form.select>
            </div>
            <div class="mb-3">
                <x-form.label for="short_description" label="{{ localize('Short Description') }}"  />
                <x-form.textarea name="short_description" id="short_description" 
                              type="text"
                              placeholder="{{ localize('write something here ....') }}"
                              value=""
                              showDiv=false
                />
            </div>
            <div class="mb-3">
                <x-form.label for="description" label="{{ localize('Description') }}" />
                <x-form.textarea name="description" id="editor" class="editor"
                              type="text"
                              placeholder="{{ localize('write something here ....') }}"
                              value=""
                              showDiv=false
                />
            </div>
            <div class="mb-3">
                <div class="mb-4">
                    <x-form.label for="blog_image" label="{{ localize('Blog Image') }}"  />
                    <div class="tt-image-drop rounded">
                        <span class="fw-semibold">{{ localize('Choose Blog Image') }}</span>
                        <!-- choose media -->
                        <div class="tt-product-thumb show-selected-files mt-3">
                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                onclick="showMediaManager(this)" data-selection="single">
                                <input type="hidden" name="blog_image" id="blog_image">
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
                <x-form.label for="meta_title" label="{{ localize('Meta Title') }}" isRequired=true />
                <x-form.input name="meta_title" id="meta_title"
                              type="text"
                              placeholder="{{ localize('Meta Title') }}"
                              value=""
                              showDiv=false
                />
            </div>
            
            <div class="mb-3">
                <x-form.label for="meta_description" label="{{ localize('Meta Description') }}" isRequired=true />
                <x-form.textarea name="meta_description" id="meta_description"
                              type="text"
                              placeholder="{{ localize('Meta Description') }}"
                              value=""
                              showDiv=false
                />
            </div>
            <div class="mb-3">
                <div class="mb-4">
                    <x-form.label for="meta_image" label="{{ localize('Meta Image') }}"  />
                    <div class="tt-image-drop rounded">
                        <span class="fw-semibold">{{ localize('Choose Meta Image') }}</span>
                        <!-- choose media -->
                        <div class="tt-product-thumb show-selected-files mt-3">
                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                onclick="showMediaManager(this)" data-selection="single">
                                <input type="hidden" name="meta_image" id="meta_image">
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
