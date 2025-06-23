    <div class="card-body">
        <div class="tab-content">

            <form action="{{ route('admin.settings.store') }}" class="deepseek-ai-form settingsForm" enctype="multipart/form-data" id="deepseek-ai-form">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <x-form.label for="DEEPSEEK_API_KEY"
                            label="{{ localize('DeepSeek AI API Key') }}" isRequired=true />
                        <x-form.input name="env[DEEPSEEK_API_KEY]"
                            id="DEEPSEEK_API_KEY" type="text" required
                            placeholder="************************************"
                            value="{{ strMasking(getSetting('DEEPSEEK_API_KEY'))}}"
                            showDiv=false />
                        <span>{{localize('Uses only :AI Chat, AI code, Template, AI Blog Wizard, AI Writer')}}</span>
                    </div>

                    <div class="col-md-12">
                        <x-form.label for="default_deepseek_ai_model"
                            label="{{ localize('Default DeepSeek AI Model') }}" />
                        <x-form.select name="settings[default_deepseek_ai_model]"
                            id="default_deepseek_ai_model">
                            @foreach (appStatic()::DEEPSEEK_AI_MODELS as $key => $model)
                                <option value="{{ $key }}"
                                    {{ getSetting('default_deepseek_ai_model') == $key ? 'selected' : '' }}>
                                    {{ localize($model) }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-primary settingsSubmitButton" id="deepseekSubmitButton">
                            {{ localize('Save Configuration') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>