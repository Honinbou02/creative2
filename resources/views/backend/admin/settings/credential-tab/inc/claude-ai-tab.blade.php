    <div class="card-body">
        <div class="tab-content">

            <form action="{{ route('admin.settings.store') }}" class="claude-ai-form settingsForm" enctype="multipart/form-data" id="claude-ai-form">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <x-form.label for="ANTHROPIC_API_KEY"
                            label="{{ localize('CLAUDE AI API Key') }}" isRequired=true />
                        <x-form.input name="env[ANTHROPIC_API_KEY]"
                            id="ANTHROPIC_API_KEY" type="text" required
                            placeholder="************************************"
                            value="{{ strMasking(getSetting('ANTHROPIC_API_KEY'))}}"
                            showDiv=false />
                        <span>{{localize('Uses only :AI Chat, AI code, Template, AI Blog Wizard, AI Writer')}}</span>
                    </div>

                    <div class="col-md-12">
                        <x-form.label for="default_claude_ai_model"
                            label="{{ localize('Default CLAUDE AI Model') }}" />
                        <x-form.select name="settings[default_claude_ai_model]"
                            id="default_claude_ai_model">
                            @foreach (appStatic()::CLAUDE_AI_MODELS as $key => $model)
                                <option value="{{ $key }}"
                                    {{ getSetting('default_claude_ai_model') == $key ? 'selected' : '' }}>
                                    {{ localize($model) }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-primary settingsSubmitButton" id="claudeSubmitButton">
                            {{ localize('Save Configuration') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>