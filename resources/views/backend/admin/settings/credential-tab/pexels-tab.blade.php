<div class="card">
    <form action="{{ route('admin.settings.store') }}"
          class="serper-form settingsForm"
          enctype="multipart/form-data"
          id="pexels-form">
        <div class="card-header">
            <h5 class="mb-0">{{ localize('Pexels Setup') }}</h5>
        </div>
        <div class="card-body">
            <div class="tab-content">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <x-form.label for="pexels_api_key"
                                      label="{{ localize('Pexels API key for Image') }}"
                                      isRequired=true />
                        
                        <x-form.input name="settings[pexels_api_key]"
                                      id="pexels_api_key"
                                      type="text" 
                                      placeholder="************************************"
                                      value="{{ strMasking(getSetting('pexels_api_key'))}}"
                                      showDiv=false />
                    </div> 
                    
                    <div class="col-md-12 d-none">
                        <x-form.label for="enable_pexels"
                                      label="{{ localize('Enable Pexels ?') }}" />
                        <x-form.select name="settings[enable_pexels]" id="enable_pexels">
                            <option value="0"
                                    {{ getSetting('enable_pexels') == '0' ? 'selected' : '' }}>
                                {{ localize('Disable') }}</option>
                            <option value="1"
                                    {{ getSetting('enable_pexels') == '1' ? 'selected' : '' }}>
                                {{ localize('Enable') }}</option>
                        </x-form.select>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer bg-transparent mt-3">
            <x-form.button type="submit" class="settingsSubmitButton btn-sm">
                <i data-feather="save"></i>{{ localize('Save Configuration') }}
            </x-form.button>
        </div>
    </form>
</div>