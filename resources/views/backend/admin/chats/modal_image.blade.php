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
            <div class="modal-body bg-secondary-subtle" data-simplebar>
                <div class="row g-3">
                    <div class="col-lg-12">
                        <div class="rounded overflow-hidden">
                            <img
                                    id="modalImg"
                                loading="lazy"
                                alt="image"
                                class="img-fluid w-100 h-100 object-fit-cover"
                            />
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>    <!-- /Modal -->
