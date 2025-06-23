
<div class="offcanvas offcanvas-end"
     id="addFormSidebar"
     tabindex="-1">
    @method('POST')
    @csrf
    <x-form.input
            name="id"
            id="id"
            type="hidden"
            value=""
            showDiv=0
    />
    <div class="offcanvas-header border-bottom py-3">
        <h5 class="offcanvas-title">{{ localize('AI Video Generate') }}</h5>
        <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
    </div>
    <x-common.splitter />
    <div class="offcanvas-body">

        <div class="tab-pane fade show active" id="multiPromptingInput">
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">
                        {{localize('Upload Image')}}
                    </label>
                    <span>{{localize('Supported Dimensions: ')}} <strong> 1024x576,
                        576x1024,
                        768x768</strong></span>
                    <input type="hidden" name="content_purpose" value="{{ appStatic()::SD_IMAGE_2_VIDEO }}">
                    <div class="file-drop-area file-upload text-center rounded-3 py-5">
                        <x-form.input type="file"
                                      id="image"
                                      class="file-drop-input"
                                      accept="image/jpg, image/png, image/jpeg"
                                      name="image"/>
                        <span
                                class="d-grid w-12 h-12 rounded-cricle place-content-center lh-1 bg-admin-light clr-placeholder rounded-circle mx-auto mb-3">
                                <span class="material-symbols-rounded fs-24"> backup </span>
                          </span>
                        <h6> {{localize('Drop your image here or browse')}} </h6>
                        <p class="clr-placeholder mb-0"> ({{localize('Only jpg, png, webp will be accepted')}}) </p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <x-form.label for="seed">{{ localize("Seed") }} </x-form.label>
                    <x-form.input
                            name="seed"
                            id="seed"
                            type="number"
                            value="0"
                            showDiv=0
                    />
                </div>

                <div class="col-lg-4">
                    <x-form.label for="seed"> {{ localize("Fidelity") }} </x-form.label>
                    <x-form.input
                            name="cfg_scale"
                            id="cfg_scale"
                            type="number"
                            value="0"
                            min="1"
                            max="10"
                            showDiv=0
                    />
                </div>

                <div class="col-lg-4">
                    <x-form.label for="motion_bucket_id"> {{ localize("Motion Intensity") }} </x-form.label>
                    <x-form.input
                            name="motion_bucket_id"
                            id="motion_bucket_id"
                            type="number"
                            value="127"
                            showDiv=0
                    />
                </div>

                <div class="col-lg-12">
                    <a
                            target="_blank"
                            class=" p-2 text-warning rounded w-100 d-block"
                            href="https://platform.stability.ai/docs/api-reference#tag/Image-to-Video/paths/~1v2beta~1image-to-video/post">
                        <i data-feather="info"></i> {{ localize("Get knowledge about Seed, Fidelity, Motion Intensity API Ref Here.") }}
                    </a>
                </div>

            </div>
        </div>

        <div class="w-100 d-flex h-100 align-items-center justify-content-center mt-4 contentLoader">
            <!-- add tt-loader tt-loader-sm for small size -->
            <div class="tt-loader">
                <span class="tt-loader-bar-1"></span>
                <span class="tt-loader-bar-2"></span>
                <span class="tt-loader-bar-3"></span>
                <span class="tt-loader-bar-4"></span>
                <span class="tt-loader-bar-5"></span>
            </div>
        </div>
    </div>

    <div class="offcanvas-footer border-top py-3">
        <div class="d-flex gap-3">
            <x-form.button
                    id="generate"
                    color="primary"
                    type="button">
                {{ localize("Generate Video") }}
            </x-form.button>
        </div>
    </div>
</div>
