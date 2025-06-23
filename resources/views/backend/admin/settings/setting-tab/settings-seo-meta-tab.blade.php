<div class="card">
    <form action="{{ route('admin.settings.store') }}" class="settings-seo-meta-form settingsForm" enctype="multipart/form-data" id="settings-seo-meta-form">
        <div class="card-header">
            <h5 class="mb-0">{{ localize('SEO Meta Configuration') }}</h5>
        </div>
    <div class="card-body">
        <div class="tab-content">
           
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <x-form.label for="global_meta_title" label="{{ localize('Meta Title') }}"
                            isRequired=true />
                        <x-form.input name="settings[global_meta_title]" id="global_meta_title"
                            type="text" placeholder="{{ localize('Type meta title') }}"
                            value="{{ getSetting('global_meta_title') }}" showDiv=false />
                            {{ localize('Set a meta tag title. Recommended to be simple and unique.') }}
                    </div>

                    <div class="col-md-12">
                        <x-form.label for="global_meta_description"
                            label="{{ localize('Meta Description') }}"
                            isRequired=true />
                          
                        <x-form.textarea name="settings[global_meta_description]" id="global_meta_description"
                            type="text" placeholder="{{ localize('Type your meta description') }}" value="{{ getSetting('global_meta_description') }}" showDiv=false />
                    </div>
                    <div class="col-md-12">
                        <x-form.label for="global_meta_keywords"
                            label="{{ localize('Meta Keywords') }}" isRequired=true />
                        <x-form.textarea name="settings[global_meta_keywords]" id="global_meta_keywords"
                            type="text" placeholder="Keyword, Keyword"
                            value="{{ getSetting('global_meta_keywords') }}" showDiv=false />
                    </div>
                    
                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="mb-4">
                                <x-form.label for="global_meta_image" label="{{localize('Meta Image')}}"  />
                                <div class="tt-image-drop rounded bg-secondary-subtle">
                                    <span class="fw-semibold">{{ localize('Choose Meta Image') }}</span>
                                    <!-- choose media -->
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media "
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                            onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden" name="settings[global_meta_image]" value="{{getSetting('global_meta_image')}}" id="global_meta_image">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- choose media -->
                                </div>
            
                            </div>
                        </div> 
                    </div>
                </div>
           

        </div>
    </div>
    <div class="card-footer bg-transparent mt-3">
        <x-form.button type="submit" class="settingsSubmitButton btn-sm"><i data-feather="save"></i>{{ localize('Save Configuration') }}</x-form.button>
    </div>
</form>
</div>