<div class="tab-pane fade" id="{{ appStatic()::ENGINE_ELEVEN_LAB }}">
    <form action="{{route('admin.text-to-speeches.store')}}" method="POST" data-engine="{{ appStatic()::ENGINE_ELEVEN_LAB }}"  class="addTextToSpeechForm" id="TextToSpeech{{ appStatic()::ENGINE_ELEVEN_LAB }}Form">
        @csrf
        <x-form.input name="engine" id="engine" type="hidden" value="{{ appStatic()::ENGINE_ELEVEN_LAB }}"
            showDiv=false />
        <div class="row g-3">

            <div class="col-12">
                <div class="form-input">
                    <x-form.label for="title" label="{{ localize('Title') }}" isRequired=true />
                    <x-form.input name="title" id="title" type="text" placeholder="{{ localize('Title') }}"
                        value="" showDiv=false />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-input">
                    <x-form.label for="model" label="{{ localize('Model') }}" isRequired=true />
                    <x-form.select name="model" id="model">
                        @isset($eleven_labs_models)
                            @foreach ($eleven_labs_models as $model)
                                <option value='{{ $model->model_id }}'>{{ $model->name }}</option>
                            @endforeach
                        @endisset
                    </x-form.select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-input">
                    <x-form.label for="voice" label="{{ localize('Voice') }}" isRequired=true />
                    <x-form.select name="voice" id="voice">
                        @isset($eleven_labs_voices)
                            @foreach ($eleven_labs_voices->voices as $voice)
                                <option value='{{ $voice->voice_id }}'>{{ $voice->name }} </option>
                            @endforeach
                        @endisset
                    </x-form.select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-input">
                    <div class="d-flex align-items-center justify-content-between">
                        <x-form.label for="stability" label="{{ localize('Stability') }}" isRequired=true />
                        <span id="stability__value"
                            class="range-slider__value">{{ isset($defaultVoiceSetting) && $defaultVoiceSetting->stability * 100 }}</span>
                    </div>
                    <input class="range-slider__range w-100
                " name="stability" id="stability"
                        type="range"
                        value="{{ isset($defaultVoiceSetting) && $defaultVoiceSetting->stability * 100 }}"
                        min="0" max="100">

                </div>
            </div>

            <div class="col-12">
                <div class="form-input">
                    <div class="d-flex align-items-center justify-content-between">

                        <x-form.label for="similarity_boost" label="{{ localize('Clarity + Similarity Enhancement') }}" isRequired=true />
                        <span id="similarity_boost__value"
                            class="range-slider__value">{{ isset($defaultVoiceSetting) && $defaultVoiceSetting->similarity_boost * 100 }}</span>
                    </div>
                    <input class="range-slider__range w-100
                " id="similarity_boost"
                        name="similarity_boost" type="range"
                        value="{{ isset($defaultVoiceSetting) && $defaultVoiceSetting->similarity_boost * 100 }}"
                        min="0" max="100">
                </div>
            </div>
            <div class="col-12">
                <div class="form-input">
                    <div class="d-flex justify-content-between align-items-center">

                        <x-form.label for="style" label="{{ localize('Style Exaggeration') }}" isRequired=true />
                        <span id="style__value"
                            class="range-slider__value">{{ isset($defaultVoiceSetting) && $defaultVoiceSetting->style * 100 }}</span>
                    </div>
                    <input class="range-slider__range w-100" name="style" id="style" type="range" value="{{ isset($defaultVoiceSetting) && $defaultVoiceSetting->style * 100 }}"
                        min="0" max="100">
                </div>
            </div>
            <div class="col-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="use_speaker_boost" checked="" type="checkbox"
                        id="use_speaker_boost" data-gtm-form-interact-field-id="2"
                        {{ isset($defaultVoiceSetting) && $defaultVoiceSetting->use_speaker_boost == true ? 'checked' : '' }}>
                    <label class="form-check-label" for="use_speaker_boost">{{ localize('Speaker Boost') }} <span
                            class="cursor-pointer me-2" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="{{ localize('Boost the similarity of the synthesized speech and the voice at the cost of some generation speed') }}"><i
                                data-feather="help-circle" class="icon-14"></i></span></label>
                </div>
            </div>

            <div class="col-12">
                <fieldset class="form-group-card bg-secondary bg-opacity-50">
                    <legend class="form-group-card__title">
                        {{ localize('Add Text') }}
                    </legend>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="position-relative z-1">
                                <x-form.textarea name="content" onkeyup="exceedLimitType('{{appStatic()::ENGINE_ELEVEN_LAB}}' , {{appStatic()::elevenLabsTextLength}})" id="input-textarea-{{appStatic()::ENGINE_ELEVEN_LAB}}" row="5" cols="5"
                                    placeholder="" />
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="fs-md mb-0"> <strong id="charac-count-{{appStatic()::ENGINE_ELEVEN_LAB}}">0</strong> / 2500</p>
                                @if (isAdmin())
                                    <p class="fs-md mb-0"> {{ localize('Total quota remaining') }} : <strong>
                                            {{ isset($user_info) && $user_info != null ? $user_info->subscription->character_limit - $user_info->subscription->character_count : '' }}</strong>
                                    </p>
                                @endif

                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="pt-4">
            <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
                <x-form.button id="frmActionBtn{{ appStatic()::ENGINE_ELEVEN_LAB }}"
                    type="submit">{{ localize('Generate Speech') }}</x-form.button>

            </div>
        </div>
    </form>
</div>
