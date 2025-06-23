<div class="card">
    <div class="card-body">
        <div class="tab-content">
            <form action="{{ route('admin.settings.store') }}" method="POST" class="settings-info-form settingsForm" enctype="multipart/form-data" id="settings-info-form">
                @csrf
                
                <div class="row g-3">
                    <div class="col-12">
                        <h6 class="mb-0 py-2">{{localize('Settings')}}</h6>
                    </div>
                    <div class="col-md-6">
                        <x-form.label for="enable_auto_blog_post" label="{{ localize('Enable Auto Blog Post') }}" />
                        <x-form.select name="settings[enable_auto_blog_post]" id="enable_auto_blog_post">
                            <option value="1" {{ getSetting('enable_auto_blog_post') == 1 ? 'selected' : '' }}>
                                {{ localize('Enable') }}</option>
                            <option value="0" {{ getSetting('enable_auto_blog_post') == 0 ? 'selected' : '' }}>
                                {{ localize('Disable') }}</option>
                        </x-form.select>
                    </div>

                   
                   
                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-dark settingsSubmitButton">
                            {{ localize('Save Configuration') }}
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>