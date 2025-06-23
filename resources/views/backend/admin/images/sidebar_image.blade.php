<div class="offcanvas offcanvas-end" id="addFormSidebar" tabindex="-1">
    @method('POST')
    @csrf
    <x-form.input
        name="id"
        id="id"
        type="hidden"
        value=""
        showDiv=0
    />
    <div class="offcanvas-header border-bottom py-3 py-3">
        <h5 class="offcanvas-title">{{ localize('Generate Images') }}</h5>
        <span class="tt-close-btn" data-bs-dismiss="offcanvas">
            <i data-feather="x"></i>
        </span>
    </div>
    <x-common.splitter />
    <div class="border-bottom">
        <ul class="nav nav-line-tab px-4 fw-medium" role="tablist">
            
            @if (allowPlanFeature('allow_dall_e_2_image'))
                <li class="nav-item" role="presentation">
                    <a href="#dalle2Image"
                        class="nav-link actionImageGenerate active"
                        data-action="dallE2"
                        data-bs-toggle="tab"
                        aria-selected="true"
                        role="tab">
                        {{ localize("DALL-E-2") }}
                    </a>
                </li>
            @endif
            @if (allowPlanFeature('allow_dall_e_3_image'))
                <li class="nav-item" role="presentation">
                    <a href="#dalle3Image"
                        class="nav-link actionImageGenerate"
                        data-action="dallE3"
                        data-bs-toggle="tab"
                        aria-selected="true"
                        role="tab">
                        {{ localize("DALL-E-3") }}
                    </a>
                </li>
            @endif
            @if (allowPlanFeature('allow_sd_images'))
                <li class="nav-item" role="presentation">
                    <a href="#stableDiffusion"
                        class="nav-link actionImageGenerate"
                        data-action="sdTextToImage"
                        data-bs-toggle="tab"
                        aria-selected="false"
                        role="tab" tabindex="-1">
                        {{ localize("Stable Diffusion") }}
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <div class="offcanvas-body">
        <div class="tab-content">

            <?php
                $imageStyles = [
                    "" => 'None',
                    1  => 'One',
                    2  => 'Two',
                    3  => 'Three',
                ];
            ?>

            @if (allowPlanFeature('allow_dall_e_2_image'))
                @include("backend.admin.images.tabs.tab_dall_e_2")
            @endif

            @if (allowPlanFeature('allow_dall_e_3_image'))
                @include("backend.admin.images.tabs.tab_dall_e_3")
            @endif

            @if (allowPlanFeature('allow_sd_images')) 
                @include("backend.admin.images.tabs.tab_stable_diffusion")
            

                <div class="tab-pane fade" id="multiPromptingInput">
                    <div class="row g-3">
                        <div class="col-12">
                            <x-form.label for="titleOrDescription" isRequired="true" class="form-label">
                                {{ localize("Title or Description") }}
                            </x-form.label>

                            <x-form.input
                                type="text"
                                class="form-control form-control--sm form-control-transparent"
                                id="titleOrDescription"
                                name="prompt"
                                placeholder="What you want to with Phrases"
                            />
                        </div>

                        <div class="col-12">
                            <a href="#"
                                class="link d-inline-flex align-items-center gap-1 rounded border :border-primary-clr lh-1 padding-y-1 padding-x-2 clr-text :clr-primary">
                                <span class="d-inline-block">
                                    {{ localize("Add More") }}
                                </span>
                                <span class="material-symbols-rounded">
                                    {{ localize("add") }}
                                </span>
                            </a>
                        </div>
                        <div class="col-12">
                            <div class="text-center">
                                <button type="button" class="btn btn-advance toggle-next-element">
                                    <span class="d-block">
                                        {{ localize("Advanced Options") }}
                                    </span>

                                    <span class="d-grid place-content-center w-6 h-6 rounded-circle shadow-sm lh-1 flex-shrink-0 bg-white clr-primary">
                                        <span class="material-symbols-rounded fs-20">
                                        {{ localize("add") }}
                                        </span>
                                    </span>
                                </button>
                                <div class="toggle-next-element__is">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label d-block text-start">
                                                {{ localize("Image Style") }}
                                                <span class="text-primary">*</span>
                                            </label>
                                            <select class="form-select form-select-transparent form-select--sm">

                                                @foreach ($imageStyles as $key=>$style)
                                                    <option value="{{ $key }}" {{ $style == 'None' ? 'selected' : '' }}>{{ $style }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label d-block text-start">
                                                {{ localize("Mood") }}
                                                <span class="text-primary">*</span>
                                            </label>
                                            <select class="form-select form-select-transparent form-select--sm">
                                                @foreach ($imageStyles as $key=>$style)
                                                    <option value="{{ $key }}" {{ $style == 'None' ? 'selected' : '' }}>{{ $style }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label d-block text-start">
                                                Image Diffusion Sample
                                                <span class="text-primary">*</span>
                                            </label>
                                            <select class="form-select form-select-transparent form-select--sm">
                                                @foreach ($imageStyles as $key=>$style)
                                                    <option value="{{ $key }}" {{ $style == 'None' ? 'selected' : '' }}>{{ $style }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label d-block text-start">
                                                {{ localize("Clip Guidance Preset") }}
                                                <span class="text-primary">*</span>
                                            </label>
                                            <select class="form-select form-select-transparent form-select--sm">
                                                @foreach ($imageStyles as $key=>$style)
                                                    <option value="{{ $key }}" {{ $style == 'None' ? 'selected' : '' }}>{{ $style }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="maxArticleLength" class="form-label d-block text-start">
                                                {{ localize("Negative Prompts") }}
                                            </label>
                                            <input type="text" class="form-control form-control--sm form-control-transparent"
                                                    id="maxArticleLength" placeholder="None">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">
                                Upload Image
                            </label>
                            <div class="file-drop-area file-upload text-center rounded-3 py-5">
                                <input type="file" class="file-drop-input" name="dp" />
                                <span
                                        class="d-grid w-12 h-12 rounded-cricle place-content-center lh-1 bg-admin-light clr-placeholder rounded-circle mx-auto mb-3">
                        <span class="material-symbols-rounded fs-24">
                            backup
                        </span>
                        </span>
                                <h6>
                                    Drop your image here or browse
                                </h6>
                                <p class="clr-placeholder mb-0">
                                    (Only jpg, png, webp will be accepted)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="offcanvas-footer border-top py-3">
        <div class="d-flex gap-3">
            <x-form.button
                    id="generateImage"
                    color="primary"
                    type="button">
                {{ localize("Generate Image") }}
            </x-form.button>
        </div>
    </div>
</div>

