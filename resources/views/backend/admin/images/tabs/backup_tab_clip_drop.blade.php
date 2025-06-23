<div class="tab-pane fade" id="clipDrop">
    <div class="tt-grid mb-4">

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item cdAction active" data-sd="sdTextToImage">
            <img src="{{ asset('assets/img/img-text-image.svg') }}"
                 alt="text to image"
                 loading="lazy"
                 class="d-block me-1"
            />
            <span class="fw-medium">{{ localize("Background Remover") }}</span>
            <span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>
        </button>

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item cdAction active" data-sd="sdTextToImage">
            <img src="{{ asset('assets/img/img-text-image.svg') }}"
                 alt="text to image"
                 loading="lazy"
                 class="d-block me-1"
            />
            <span class="fw-medium">{{ localize("Background Remover") }}</span>
            <span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>
        </button>

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item cdAction active" data-sd="sdTextToImage">
            <img src="{{ asset('assets/img/img-text-image.svg') }}"
                 alt="text to image"
                 loading="lazy"
                 class="d-block me-1"
            />
            <span class="fw-medium">{{ localize("Background Remover") }}</span>
            <span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>
        </button>

        <button href="#" class="d-flex align-items-center border rounded-pill px-3 py-1 tt-grid-item cdAction active" data-sd="sdTextToImage">
            <img src="{{ asset('assets/img/img-text-image.svg') }}"
                 alt="text to image"
                 loading="lazy"
                 class="d-block me-1"
            />
            <span class="fw-medium">{{ localize("Background Remover") }}</span>
            <span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>
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
            <div class="col-12">
                <div class="d-flex align-items-center tt-advance-options cursor-pointer my-3">
                    <label for="tt-advance-options"
                           class="form-label cursor-pointer btn btn-sm btn-secondary rounded-pill fw-medium">
                        Advance Options <i data-feather="plus" class="icon-14 ms-1"></i></label>

                </div>
            </div>
            <div class="col-12" id="tt-advance-options">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="form-input">
                            <label for="select-input" class="form-label">Art Style</label>
                            <select class="form-select form-select-sm" id="select-input">
                                <option selected="">None</option>
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
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-input">
                            <label for="select-input" class="form-label">Quality</label>
                            <select class="form-select form-select-sm" id="select-input">
                                <option>Standard</option>
                                <option>HD</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-input">
                            <label for="select-input" class="form-label">Image resolution</label>
                            <select class="form-select form-select-sm" id="select-input">
                                <option>512x512</option>
                                <option>1024x1024</option>
                                <option>1024x1792</option>
                                <option>1792x1024</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-input">
                            <label for="select-input" class="form-label">Mode</label>
                            <select class="form-select form-select-sm" id="select-input">
                                <option>Friendly</option>
                                <option>Luxury</option>
                                <option>Relaxed</option>
                                <option>Professional</option>
                                <option>Casual</option>
                                <option>Excited</option>
                                <option>Bold</option>
                                <option>Masculine</option>
                                <option>Dramatic</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-input">
                            <label for="select-input" class="form-label">Lightning Style</label>
                            <select class="form-select form-select-sm" id="select-input">
                                <option>Friendly</option>
                                <option>Luxury</option>
                                <option>Relaxed</option>
                                <option>Professional</option>
                                <option>Casual</option>
                                <option>Excited</option>
                                <option>Bold</option>
                                <option>Masculine</option>
                                <option>Dramatic</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-input">
                            <label for="select-input" class="form-label">Number of Result</label>
                            <select class="form-select form-select-sm select2" id="select-input">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tt-image-to-image">
        <div class="row g-2">
            <div class="col-12">
                <div class="form-input">
                    <label for="textarea-input" class="form-label">Type your image prompt<span
                                class="text-danger ms-1">*</span></label>
                    <textarea class="form-control" id="textarea-input" placeholder="Describe your idea to generate image"
                              rows="3"></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="form-input">
                    <label for="upload" class="form-label">Upload Image</label>
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

    <div class="tt-upscaling">
        <div class="row g-2">
            <div class="col-12">
                <div class="form-input">
                    <label for="upload" class="form-label">Upload Image</label>
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

    <div class="tt-multi-prompting">
        <div class="row g-2">
            <div class="col-12">
                <div class="form-input">
                    <label for="textarea-input" class="form-label">Type your image prompt<span
                                class="text-danger ms-1">*</span></label>
                    <textarea class="form-control" id="textarea-input" placeholder="Describe your idea to generate image"
                              rows="3"></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="form-input">
                    <label for="upload" class="form-label">Upload Image</label>
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
