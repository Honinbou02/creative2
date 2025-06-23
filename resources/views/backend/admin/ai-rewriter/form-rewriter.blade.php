<x-form.input type="hidden" name="content_purpose" value="{{appStatic()::PURPOSE_GENERATE_TEXT}}"/>
<div class="content-generator__sidebar-body overflow-y-auto tt-screen-height">
    <div class="row g-3">
        <div class="col-12">

            <x-form.label for="language"
                          label="{{ localize('Select input and output language') }}"
                          isRequired=true />
            <x-form.select name="language" id="language">
                @foreach (languages() as $language)
                    <option value="{{$language->name}}">{{$language->name}}</option>
                @endforeach
            </x-form.select>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <x-form.label
                        for="prompt"
                        label="{{ localize('Input your content') }}"
                        isRequired=true
                />
                <x-form.textarea
                        name="prompt"
                        class="form-control"
                        id="textarea"
                        rows="10"
                />
            </div>

        </div>
        @if(isUseOpenAiEngine())
            <div class="col-12">
                <div class="text-left">
                    <div class="d-flex align-items-center tt-advance-options cursor-pointer">
                        <x-form.label
                                class="form-label cursor-pointer btn btn-sm btn-secondary rounded-pill fw-medium"
                                for="tt-advance-options">
                            <i class="las la-plus"></i>
                            {{ localize("Advance Options") }}
                        </x-form.label>
                    </div>

                    <div class="toggle-next-element__is bg-secondary bg-opacity-50 p-lg-4 p-2 rounded-3 tt-advance-options-content">
                        <div class="row g-3">
                            <div class="col-12">

                                <x-form.label for="max_tokens"
                                              label="{{ localize('Max Results Length') }}" />
                                <x-form.input type="text" name="max_tokens"
                                              class="form-control form-control-sm"
                                              id="maxArticleLength" placeholder="10" />
                            </div>
                            <div class="col-md-6">
                                <x-form.label for="tone"
                                              label="{{ localize('Choose a Tone') }}" />
                                <x-form.select name="tone"
                                               class="form-select form-select-transparent form-select--sm"
                                               id="tone">
                                    @foreach (appStatic()::OPEN_AI_TONE as $key => $item)
                                        <option value="{{ $key }}">
                                            {{ localize($item) }}</option>
                                    @endforeach

                                </x-form.select>
                            </div>
                            <div class="col-md-6">
                                <x-form.label for="creativity"
                                              label="{{ localize('Creativity') }}" isRequired=true />
                                <x-form.select name="creativity"
                                               class="form-select form-select-transparent form-select--sm"
                                               id="creativity">

                                    @foreach (appStatic()::OPEN_AI_CREATIVITY as $key => $name)
                                        <option value="{{ (int) $key }}">
                                            {{ localize($name) }}</option>
                                    @endforeach

                                </x-form.select>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="content-generator__sidebar-footer py-3">
    <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
        <x-form.button
                class="btn btn-sm btn-primary rounded-pill"
                type="submit"
                id="generateContent">
            {{ localize('Generate Content') }}
            <i data-feather="rotate-cw" class="icon-14"></i>
        </x-form.button>

        <x-form.button
                class="btn btn-sm btn-secondary rounded-pill"
                id="stopGenerateContent"
                disabled>
            {{ localize('Stop Generation') }}
            <i data-feather="stop-circle" class="icon-14"></i>
        </x-form.button>
    </div>
</div>