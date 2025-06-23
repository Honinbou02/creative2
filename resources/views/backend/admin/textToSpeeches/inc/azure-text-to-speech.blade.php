<div class="tab-pane fade" id="{{ appStatic()::ENGINE_AZURE }}">
    <form action="{{ route('admin.text-to-speeches.store') }}" method="POST" data-engine="{{ appStatic()::ENGINE_AZURE }}" class="addTextToSpeechForm" id="TextToSpeech{{ appStatic()::ENGINE_AZURE }}Form">
        @csrf
        <div class="row g-3">
            <input name="engine" id="engine" type="hidden" value="{{ appStatic()::ENGINE_AZURE }}"/>
            <div class="col-lg-6">
                <div class="form-input">
                    <x-form.label for="azureLanguages" label="{{ localize('Language') }}" isRequired=true />
                    <x-form.select name="language" class="select2" id="azureLanguages">
                        @foreach ($azure_languages as $key => $language)
                            <option value="{{ $key }}" {{ $key == 'en-GB' ? 'selected' : '' }}>
                                {{ $language }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-input">
                    <x-form.label for="azureVoice" label="{{ localize('Voice') }}" isRequired=true />
                    <x-form.select name="voice" class="select2" id="azureVoice">

                    </x-form.select>
                </div>
            </div>

            <div class="col-12">
                <x-form.label for="title" label="{{ localize('Title') }}" isRequired=true />
                <x-form.input name="title" id="title" type="text" placeholder="{{ localize('Title') }}"
                    value="" showDiv=false />
            </div>
            <div class="col-12">
                <fieldset class="form-group-card bg-secondary bg-opacity-50 speech">
                    <legend class="form-group-card__title">
                        {{ localize('Add Text') }}
                    </legend>
                    <div class="row g-3 speech">
                        <div class="col-12">
                                <x-form.select class="form-select form-select-sm azure-say-as">
                                    <option value="0" selected>{{ localize('say-as') }}</option>
                                    <option value="currency">{{ localize('currency') }}</option>
                                    <option value="telephone">{{ localize('telephone') }}</option>
                                    <option value="verbatim">{{ localize('verbatim') }}</option>
                                    <option value="date">{{ localize('date') }}</option>
                                    <option value="characters">{{ localize('characters') }}</option>
                                    <option value="cardinal">{{ localize('cardinal') }}</option>
                                    <option value="ordinal">{{ localize('ordinal') }}</option>
                                    <option value="fraction">{{ localize('fraction') }}</option>
                                    <option value="bleep">{{ localize('bleep') }}</option>
                                    <option value="unit">{{ localize('unit') }}</option>
                                    <option value="unit">{{ localize('time') }}</option>
                                </x-form.select>
                        </div>
                        <div class="col-12">
                            <div class="position-relative z-1">
                                <x-form.textarea name="content[]" class="azureContent" row="5" cols="5" placeholder="" />

                                <x-form.button type="button"
                                class="btn bttn--icon btn--increment w-5 h-5 rounded-circle border-primary lh-1 azureAddMoreText"><span
                                    class="material-symbols-rounded text-primary fs-18 lh-1">
                                    add
                                </span></x-form.button>
                            </div>

                        </div>
                    </div>

                    <div class="row azureMultiField" id="azureMultiField">
                    </div>

                </fieldset>

            </div>

        </div>
        <div class="pt-4">
            <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
                <x-form.button id="frmActionBtn{{ appStatic()::ENGINE_AZURE }}"
                    type="submit">{{ localize('Generate Speech') }}</x-form.button>
            </div>
        </div>
    </form>
</div>
