<div class="card">
    <form action="{{ route('admin.settings.store') }}"
          class="serper-form settingsForm"
          enctype="multipart/form-data"
          id="aiProductShot-form">
        <div class="card-header">
            <h5 class="mb-0">{{ localize('AI Product Shot  Setup') }}</h5>
        </div>
        <div class="card-body">
            <div class="tab-content">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <x-form.label for="ai_product_shot_api_key"
                                      label="{{ localize('PEBBLELY API key for the Product Shot') }}"
                                      isRequired=true >
                            <a href="https://pebblely.com/docs/" target="_blank" class="btn btn-sm btn-soft-success">{{ localize("Generate API Key") }}</a>
                        </x-form.label>
                        <x-form.input name="settings[ai_product_shot_api_key]"
                                      id="ai_product_shot_api_key"
                                      type="text"
                                      placeholder="************************************"
                                      value="{{ strMasking(getSetting('ai_product_shot_api_key'))}}"
                                      showDiv=false />
                    </div>
                    <div class="col-md-12">
                        <x-form.label for="enable_ai_product_shot"
                                      label="{{ localize('Enable AI Product Shot ?') }}" />
                        <x-form.select name="settings[enable_ai_product_shot]" id="enable_ai_product_shot">
                            <option value="0"
                                    {{ getSetting('enable_ai_product_shot') == '0' ? 'selected' : '' }}>
                                {{ localize('Disable') }}</option>
                            <option value="1"
                                    {{ getSetting('enable_ai_product_shot') == '1' ? 'selected' : '' }}>
                                {{ localize('Enable') }}</option>
                        </x-form.select>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer bg-transparent mt-3">
            <x-form.button type="submit" class="settingsSubmitButton btn-sm"><i data-feather="save"></i>{{ localize('Save Configuration') }}</x-form.button>
        </div>
    </form>
</div>