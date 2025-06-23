<!-- Offcanvas -->
<form class="offcanvas offcanvas-end published-to-wordpress-form"
      action="{{ route('admin.wordpress.importArticle') }}"
      method="post"
      data-bs-backdrop="static"
      id="offcanvasImportWordpressContent" tabindex="-1">
        @csrf
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">{{ localize('Published to Wordpress') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body" data-simplebar>
            <div class="text-center published-to-wordpress-wait mt-5">{{ localize('Please wait') }}...</div>
            <div class="published-to-wordpress-contents" id="wordpress-contents"></div>
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button id="frmActionImportBtn"
                    class="published-to-wordpress-submit-btn" type="submit">{{ localize('Import Post') }}</x-form.button>
            </div>
        </div>
    </div>
</form> <!-- offcanvas template end-->

