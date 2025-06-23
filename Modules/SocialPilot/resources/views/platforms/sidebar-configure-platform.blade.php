<form action="" method="POST" id="configurePlatformForm">
    <div class="offcanvas offcanvas-end" id="configurePlatformFormSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title" id="generated-title">{{ localize('Configure Platform') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>

        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />
            <div class="" id="configurePlatformFormContainer">
                
            </div>
        </div>

        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button id="frmActionBtn">{{ localize('Save Changes') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
