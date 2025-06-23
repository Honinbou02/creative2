<div class="tab-pane fade active show" id="dalle2Image">
    <div class="row g-2">
        <div class="col-12">
            <div class="form-input">
                <x-form.label
                        for="dallE2Title"
                        label="{{ localize('Type your image prompt') }}"
                        isRequired="true" />
                <x-form.textarea
                        row="5"
                        cols="5"
                        id="dallE2Title"
                        placeholder="{{ localize('Describe your idea to generate image') }}"
                        name="title"></x-form.textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex align-items-center tt-advance-options cursor-pointer mt-3">
                <x-form.label
                        class="form-label cursor-pointer btn btn-sm btn-secondary rounded-pill fw-medium"
                        for="tt-advance-options">
                        <i class="las la-plus"></i>
                        {{ localize("Advance Options") }}
                </x-form.label>
            </div>
        </div>
        <div class="col-12 bg-secondary bg-opacity-50 p-lg-4 p-2 rounded-3 tt-advance-options-content">
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="form-input">
                        <x-form.label for="dallE2ArtStyle" class="form-label">
                            {{ localize("Art Style") }}
                        </x-form.label>

                        <x-form.select
                                name="art_style"
                                id="dallE2ArtStyle"
                                class="form-select form-select-sm">
                            @foreach(appStatic()::ART_STYLES as $key=>$value)
                                <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-input">
                        <x-form.label for="dallE2Size" class="form-label">
                            {{ localize("Image resolution") }}
                        </x-form.label>

                        <x-form.select
                                name="size"
                                id="dallE2Size"
                                class="form-select form-select-sm">
                            @forelse(appStatic()::DALL_E_2_RESOULATIONS as $key => $value)
                                <option value="{{ $value }}">{{ $value }}</option>
                            @empty
                            @endforelse
                        </x-form.select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-input">
                        <x-form.label for="dallE2Mode" class="form-label">
                            {{ localize("Mode") }}
                        </x-form.label>

                        <x-form.select name="mode"
                                       id="dallE2Mode"
                                       class="form-select form-select-sm"
                                       id="select-input">
                          @forelse(appStatic()::MODE_TYPES as $key=>$value)
                                <option value="{{ $value }}">{{ $value }}</option>
                            @empty
                          @endforelse
                        </x-form.select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-input">
                        <x-form.label for="dallE2NumberOfResults" class="form-label">
                            {{ localize("Number of Result") }}
                        </x-form.label>

                        <x-form.select
                                id="dallE2NumberOfResults"
                                class="form-select form-select-sm"
                                name="number_of_results"
                        >
                            @for($start=1;$start<=10; $start++)
                                <option value="{{ $start }}">{{ $start }}</option>
                            @endfor
                        </x-form.select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
