<div class="modal fade" id="imageView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 tt-modal-header">
                <h2 class="modal-title h4" id="modalTitle">{{localize('Generated Image Details')}}</h2>
                <span class="tt-close-btn rounded-circle shadow-sm"
                      data-bs-dismiss="modal"
                      aria-label="Close">
                    <i data-feather="x" class="icon-16"></i>
                </span>
            </div>
            <div class="modal-body bg-secondary-subtle tt-custom-scrollbar">
                <div class="row g-3">
                    <div class="col-lg-5">
                        <div class="rounded overflow-hidden">
                            <img
                                    id="modalImg"
                                loading="lazy"
                                alt="image"
                                class="img-fluid w-100 h-100 object-fit-cover"
                            />
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="tt-generate-image-details d-flex flex-column h-100">
                            <strong class="text-uppercase mb-2" >{{localize('Image Prompt')}}</strong>
                            <div
                                    class="p-3 rounded mb-3 bg-soft-primary position-relative text-body tt-prompt-text tt-chat-history-list">
                                <p class="mb-0" id="modalPrompt"> </p>
                                <div class="tt-copy-text shadow-lg">
                                    <i data-feather="copy" class="icon-16"></i>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="shadow-sm p-2 rounded bg-light">
                                            <p class="mb-0 fw-medium">{{ localize("Created") }}</p>
                                            <span class="text-muted" id="modalCreatedAt">12 Mar 2023</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="shadow-sm py-2 px-3 rounded bg-light">
                                            <p class="mb-0 fw-medium">{{ localize("AI Vendor") }}</p>
                                            <span class="text-muted" id="modalPlatForm"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="shadow-sm py-2 px-3 rounded bg-light">
                                            <p class="mb-0 fw-medium">{{ localize("AI Model") }}</p>
                                            <span class="text-muted" id="modalModel">SDXL V1.0</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="shadow-sm py-2 px-3 rounded bg-light">
                                            <p class="mb-0 fw-medium">{{ localize("Resolution") }}</p>
                                            <span class="text-muted" id="modalSize"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="shadow-sm py-2 px-3 rounded bg-light">
                                            <p class="mb-0 fw-medium">Tone</p>
                                            <span class="text-muted">Natural</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="shadow-sm py-2 px-3 rounded bg-light">
                                            <p class="mb-0 fw-medium">Style</p>
                                            <span class="text-muted">Art</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- /Modal -->
