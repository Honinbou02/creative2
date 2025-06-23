<!-- Offcanvas -->
<form class="offcanvas offcanvas-end subscription-templates-form" data-bs-backdrop="static" id="offcanvasRight"
    tabindex="-1">
   
    <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">{{ localize('All Templates') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
    <x-common.splitter />
    <div class="offcanvas-body" data-simplebar>
        <div class="package-template-contents"></div>
    </div>
    <div class="offcanvas-footer border-top">
        <div class="d-flex gap-3">
            <x-form.button id="frmActionBtn" class="package-template-submit-btn">{{ localize('Save') }}</x-form.button>
        </div>
    </div>
</form> <!-- offcanvas template end-->