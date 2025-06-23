<div class="tab-pane fade" id="dalle3Image">
    <div class="row g-2">
        <div class="col-12">
            <div class="form-input">
                <x-form.label
                        for="dallE3Title"
                        isRequired="true">
                    {{ localize("Type your image prompt") }}
                </x-form.label>

                <x-form.textarea
                        row="5"
                        cols="5"
                        id="dallE3Title"
                        placeholder="Describe your idea to generate image"
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
                        <x-form.label for="dallE3ArtStyle" class="form-label">
                            {{ localize("Art Style") }}
                        </x-form.label>

                        <x-form.select
                                name="art_style"
                                id="dallE3ArtStyle"
                                class="form-select form-select-sm">
                            @forelse(appStatic()::ART_STYLES as $key => $value)
                                <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                            @empty
                            @endforelse


                            <option value="3d_render">3D Render</option>
                            <option value="anime"> Anime</option>
                            <option value="ballpoint_pen"> Ballpoint Pen Drawing</option>
                            <option value="bauhaus">Bauhaus</option>
                            <option value="cartoon">Cartoon</option>
                            <option value="clay">Clay</option>
                            <option value="contemporary">Contemporary</option>
                            <option value="cubism"> Cubism</option>
                            <option value="cyberpunk">Cyberpunk</option>
                            <option value="glitchcore">Glitchcore</option>
                            <option value="impressionism">Impressionism</option>
                        </x-form.select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-input">
                        <x-form.label for="dallE3quality" class="form-label">
                            {{ localize("Quality") }}
                        </x-form.label>

                        <x-form.select
                                name="quality"
                                id="dallE3quality"
                                class="form-select form-select-sm">
                            <option value="Standard">{{ localize("Standard") }}</option>
                            <option value="HD">{{ localize("HD") }}</option>
                        </x-form.select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-input">
                        <x-form.label for="dallE3Size" class="form-label">
                            {{ localize("Image resolution") }}
                        </x-form.label>

                        <x-form.select
                                name="size"
                                id="dallE3Size"
                                class="form-select form-select-sm">
                            @forelse(appStatic()::DALL_E_3_RESOULATIONS as $key => $value)
                                <option value="{{ $value }}">{{ $value }}</option>
                            @empty
                            @endforelse
                        </x-form.select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-input">
                        <x-form.label for="dallE3Mode" class="form-label">
                            {{ localize("Mode") }}
                        </x-form.label>

                        <x-form.select name="mode"
                                       id="dallE3Mode"
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
                        <x-form.label for="dallE3LightingStyle" class="form-label">
                            {{ localize("Lightning Style") }}
                        </x-form.label>

                        <x-form.select name="lighting_style"
                                       id="dallE3LightingStyle"
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
                        <x-form.label for="dallE3NumberOfResults" class="form-label">
                            {{ localize("Number of Result") }}
                        </x-form.label>

                        <x-form.select
                                id="dallE3NumberOfResults"
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
