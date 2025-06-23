<!-- Offcanvas -->
<div class="offcanvas offcanvas-end published-to-wordpress-form"
     data-bs-backdrop="static"
     id="offcanvasSelectedImage"
     tabindex="-1">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ localize('Image Details') }}</h5>
        <span class="tt-close-btn" data-bs-dismiss="offcanvas">
            <i data-feather="x"></i>
        </span>
    </div>
    <x-common.splitter />
    <div class="offcanvas-body" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="contentImg">
                    <img src="{{ defaultImage() }}" class="img-fluid" alt="Default Image" />
                </div>
                <div class="contentText">

                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group mb-3">
                    <x-form.label for="image" class="form-label" label="Image URL"  ></x-form.label>
                    <x-form.input type="text"
                                  class="form-control form-control-sm"
                                  id="imageURL"
                                  name="imageURL"
                                  value=""
                                  placeholder="Image URL"
                    />
                </div>

                <div class="form-group mb-3">
                    <x-form.label for="image" class="form-label" label="Alt text(Optional)"  ></x-form.label>
                    <x-form.input type="text"
                                  class="form-control form-control-sm"
                                  id="imageALT"
                                  name="imageALT"
                                  value=""
                                  placeholder="SEO Optimized Image"
                    />
                </div>

                <div class="form-group mb-3">
                    <x-form.label for="image" class="form-label" label="Title Attribute (Optional)"  ></x-form.label>
                    <x-form.input type="text"
                                  class="form-control form-control-sm"
                                  id="imageTitle"
                                  name="imageTitle"
                                  value=""
                                  placeholder="{{ localize('What type of article do you want to generate?') }}"
                    />
                </div>
            </div>

        </div>
    </div>
    <div class="offcanvas-footer border-top">
        <div class="d-flex gap-3 align-items-center">
            <x-form.button
                    data-bs-dismiss="offcanvas"
                    type="button"
                    class="add-to-article-content-btn">
                <i data-feather="save" class="icon-14"></i> {{ localize('Add to Article') }}
            </x-form.button>
        </div>
    </div>
</div> <!-- offcanvas template end-->

