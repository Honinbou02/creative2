<form action="" method="POST" id="addQuickTextForm">
    <div class="offcanvas offcanvas-end" id="addQuickTextFromSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title" id="offcanvas-title">{{ localize('Add Quick Text') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>

        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />
            <div class="" id="addQuickTextFormContainer">
                
            </div>
        </div>

        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button id="addFormActionBtn">{{ localize('Save Changes') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
