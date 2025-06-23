<div class="tab-pane fade" id="stableDiffusion">

    <div class="tt-grid mb-2">
        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item sdAction active" data-sd="sdTextToImage">
            <span class="fw-medium tt-img-model-name">{{ localize("Text to Image") }}</span>
            <span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>
        </button>

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item sdAction" data-sd="sdImageToImage">
            <span class="fw-medium tt-img-model-name">{{ localize("Image to Image") }}</span>
        </button>

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item sdAction" data-sd="sdUpScaling">
            <span class="fw-medium tt-img-model-name">{{ localize("Upscaling") }}</span>
        </button>

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item sdAction" data-sd="sdMultiPrompting">
            <span class="fw-medium tt-img-model-name">{{ localize("Multi Prompting") }}</span>
        </button>
    </div>


    <div class="tt-text-to-image form-group-card">
        <div class="row g-2">
            <div class="col-12 sdImgWrapper">
                <div class="form-input">
                    <x-form.label for="image">{{ localize("Upload Image") }}</x-form.label>

                    <div class="file-drop-area file-upload text-center rounded-3 mb-5">
                        <input type="file"
                               id="image"
                               name="image"
                               class="file-drop-input sdImg"
                        />
                        <div class="file-drop-icon ci-cloud-upload">
                            <i data-feather="image"></i>
                        </div>
                        <p class="mb-0 file-name text-muted">
                            {{ localize("(Only *jpg, png, webp will be accepted)") }}
                        </p>
                    </div>
                </div>
            </div>


            <div class="multiPromptLists">
                <div class="single-prompt d-flex align-items-center mb-2 gap-2">

                    <x-form.input type="text"
                                  placeholder="Describe your idea to generate image"
                                  name="title[]" required></x-form.input>

                    <x-form.button color="secondary"
                                   class="addPrompt btn-icon btn-sm justify-content-center"
                                   type="button">
                        <i data-feather="plus"></i>
                    </x-form.button>

                    <x-form.button color="secondary"
                                   class="delPrompt btn-icon  btn-sm justify-content-center btn-soft-danger"
                                   type="button">
                        <i data-feather="minus"></i>
                    </x-form.button>
                </div>
           </div>

            <div class="col-12 sdTitleDiv">
                <div class="form-input">
                    <x-form.label
                            for="SDTitle"
                            isRequired="true">
                        {{ localize("Type your image prompt") }}
                    </x-form.label>

                    <x-form.input
                            id="SDTitle"
                            placeholder="Describe your idea to generate image"
                            name="title"></x-form.input>
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
                            <x-form.label for="SDArtStyle" class="form-label">
                                {{ localize("Art Style") }}
                            </x-form.label>

                            <x-form.select
                                    name="art_style"
                                    id="SDArtStyle"
                                    class="form-select form-select-sm">
                                @forelse(appStatic()::SD_STYLES as $key => $value)
                                    <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                                @empty
                                @endforelse
                            </x-form.select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-input">
                            <x-form.label for="SDSize" class="form-label">
                                {{ localize("Image resolution") }}
                            </x-form.label>

                            <x-form.select
                                    name="size"
                                    id="SDSize"
                                    class="form-select form-select-sm">
                                @forelse(appStatic()::SD_TEXT_2_IMAGE_RESOULATIONS as $key => $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @empty
                                @endforelse
                            </x-form.select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-input">
                            <x-form.label for="SDMode" class="form-label">
                                {{ localize("Mode") }}
                            </x-form.label>

                            <x-form.select name="mode"
                                           id="SDMode"
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
                            <x-form.label for="SDLightingStyle" class="form-label">
                                {{ localize("Lightning Style") }}
                            </x-form.label>

                            <x-form.select name="lighting_style"
                                           id="SDLightingStyle"
                                           class="form-select form-select-sm">
                                @forelse(appStatic()::LIGHTING_STYLE_TYPES as $key=>$value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @empty
                                @endforelse
                            </x-form.select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-input">
                            <x-form.label for="SDNumberOfResults" class="form-label">
                                {{ localize("Number of Result") }}
                            </x-form.label>

                            <x-form.select
                                    id="SDNumberOfResults"
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

    {{--TODO::Multiple Prompt--}}

</div>
