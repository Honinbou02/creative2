<div class="col-12">
    <div class="text-center">
        <div class="d-flex align-items-center tt-advance-options cursor-pointer mt-3 mb-2">
            <x-form.label
                    class="form-label cursor-pointer btn btn-sm btn-secondary rounded-pill fw-medium me-2"
                    for="tt-advance-options">
                <i class="las la-plus"></i>
                {{ localize("Advance Options") }}
            </x-form.label>
        </div>



        <div class="toggle-next-element__is tt-advance-options-content">
            <div class="row g-3" id="advanced_option">
                <div class="col-md-6">
                    <x-form.label for="language" class="form-label d-block text-start"
                                  isRequired="true">
                        {{ localize('Language') }}
                    </x-form.label>

                    <x-form.select name="language"
                                   class="form-select form-select-transparent form-select--sm" id="language">
                        @foreach (languages() as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach

                    </x-form.select>
                </div>

                <div class="col-md-6">
                    <label class="form-label d-block text-start">
                        {{ localize('Tone') }}
                        <span class="text-primary">*</span>
                    </label>
                    <select class="form-select form-select-transparent form-select--sm">
                        <option selected>{{ localize('Select') }}</option>
                        @foreach (appStatic()::OPEN_AI_TONES as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-12">
                    <label for="maxArticleLength" class="form-label d-block text-start">
                        {{ localize('Max Article Length (Words)') }}
                    </label>
                    <input type="text" class="form-control form-control-sm" id="maxArticleLength"
                           placeholder="10">
                </div>
            </div>

            <div class="row g-3" id="advanced_option_image">
                @if (getSetting('generate_image_option') == 'dall_e_2')
                    @include('common.dall-e-2')
                @elseif(getSetting('generate_image_option') == 'dall_e_3')
                    @include('common.dall-e-3')
                @elseif(getSetting('generate_image_option') == 'stable_diffusion')
                    @include('common.stability-ai')
                @else
                    @include('common.dall-e-2')
                @endif
            </div>
        </div>

    </div>
</div>