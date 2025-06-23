<div class="tab-pane fade active show" id="{{ appStatic()::ENGINE_OPEN_AI }}">
    <form action="{{route('admin.text-to-speeches.store')}}" method="POST" class="addTextToSpeechForm"  data-engine="{{ appStatic()::ENGINE_OPEN_AI }}" id="TextToSpeech{{ appStatic()::ENGINE_OPEN_AI }}Form">
        @csrf
        <div class="row g-3">
            <input name="engine" id="engine" type="hidden" value="{{ appStatic()::ENGINE_OPEN_AI }}"/>
            <div class="col-lg-6">
                <div class="form-input">
                    <x-form.label for="model" label="{{ localize('Model') }}" isRequired=true />
                    <x-form.select name="model" id="model">
                        @foreach ($models as $model)
                            <option value="{{ $model }}"> {{ strtoupper(str_replace('-', ' ', $model)) }}
                            </option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-input">
                    <x-form.label for="voice" label="{{ localize('Voice') }}" isRequired=true />
                    <x-form.select name="voice"  id="voice">
                        @foreach ($languages_voices as $key => $voice)
                            <option value="{{ $voice }}">
                                {{ ucfirst($voice) }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-input">
                    <x-form.label for="speed" label="{{ localize('Speed') }}" isRequired=true />
                    <x-form.select name="speed" id="speed">
                        @foreach ($speeds as $speed)
                            <option value="{{ $speed }}" {{ $speed == 1 ? 'selected' : '' }}>
                                {{ $speed }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-input">
                    <x-form.label for="response_format" label="{{ localize('Response Format') }}" isRequired=true />
                    <x-form.select name="response_format" id="response_format">
                        @foreach ($response_formats as $format)
                            <option value="{{ $format }}" {{ $format == 'mp3' ? 'selected' : '' }}>
                                {{ strtoupper($format) }} </option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="col-12">
                <x-form.label for="title" label="{{ localize('Title') }}" isRequired=true />
                <x-form.input name="title" id="title" type="text" placeholder="{{ localize('Title') }}"
                    value="" showDiv=false />
            </div>
            <div class="col-12">
                <fieldset class="form-group-card bg-secondary bg-opacity-50">
                    <legend class="form-group-card__title">
                        {{ localize('Add Text') }}
                    </legend>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="position-relative z-1">
                                <x-form.textarea name="content" onkeyup="exceedLimitType('{{appStatic()::ENGINE_OPEN_AI}}', {{ appStatic()::openAiTextLength}})" id="input-textarea-{{appStatic()::ENGINE_OPEN_AI}}" row="5" cols="5"
                                    placeholder="" />
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="fs-md mb-0"> <strong id="charac-count-{{appStatic()::ENGINE_OPEN_AI}}">0</strong> /
                                    {{ appStatic()::openAiTextLength }}</p>

                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

        </div>
        <div class="pt-4">
            <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
                <x-form.button id="frmActionBtn{{ appStatic()::ENGINE_OPEN_AI }}" type="submit">{{ localize('Generate Speech') }}</x-form.button>

            </div>
        </div>
    </form>
</div>
