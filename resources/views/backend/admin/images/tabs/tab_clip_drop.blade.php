<div class="tab-pane fade" id="clipDrop">
    <div class="tt-grid mb-4">

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item cdAction active"
                data-sd="sdTextToImage">
            <img src="{{ asset('assets/img/img-text-image.svg') }}"
                 alt="text to image"
                 loading="lazy"
                 class="d-block me-1"
            />
            <span class="fw-medium">{{ localize("Background Remover") }}</span>
            <span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>
        </button>

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item cdAction " data-sd="sdTextToImage">
            <img src="{{ asset('assets/img/img-text-image.svg') }}"
                 alt="text to image"
                 loading="lazy"
                 class="d-block me-1"
            />
            <span class="fw-medium">{{ localize("Background Remover") }}</span>
{{--            <span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>--}}
        </button>

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item cdAction " data-sd="sdTextToImage">
            <img src="{{ asset('assets/img/img-text-image.svg') }}"
                 alt="text to image"
                 loading="lazy"
                 class="d-block me-1"
            />
            <span class="fw-medium">{{ localize("Background Remover") }}</span>
{{--            <span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>--}}
        </button>

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item cdAction " data-sd="sdTextToImage">
            <img src="{{ asset('assets/img/img-text-image.svg') }}"
                 alt="text to image"
                 loading="lazy"
                 class="d-block me-1"
            />
            <span class="fw-medium">{{ localize("Background Remover") }}</span>
{{--            <span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>--}}
        </button>

    </div>


    <div class="tt-text-to-image">
        <div class="row g-2">
            <div class="col-12">
                <div class="form-input">
                    <label for="textarea-input" class="form-label">Type your image prompt<span
                                class="text-danger ms-1">*</span></label>
                    <textarea class="form-control" id="textarea-input" placeholder="Describe your idea to generate image"
                              rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>


    <div class="tt-upscaling">
        <div class="row g-2">
            <div class="col-12">
                <div class="form-input">
                    <label for="upload" class="form-label">{{ localize("Upload Image") }} <small>{{ localize("Support: jpg, png, webp") }}</small></label>
                    <div class="file-drop-area file-upload text-center rounded-3 mb-5">
                        <input type="file" class="file-drop-input" name="upload" />
                        <div class="file-drop-icon ci-cloud-upload">
                            <i data-feather="image"></i>
                        </div>
                        <p class="mb-0 file-name text-muted">
                            (Only *jpg, png, webp will be accepted)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
