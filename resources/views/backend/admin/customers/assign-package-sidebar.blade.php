<form action="{{ route('admin.customers.assign-package.update') }}" method="POST" id="assignPackageFrm">
    <div class="offcanvas offcanvas-end" id="assignPackageSideBar" tabindex="-1">
        @method('POST')
        @csrf
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title" id="generated-title">{{ localize('Assign Package') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>

        <x-common.splitter />
        <div class="offcanvas-body">
            <div class="" id="assignPackageContainer">
                
            </div>
        </div>

        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button type="submit" id="assignPackageBtn">{{ localize('Assign Package') }}</x-form.button>
            </div>
        </div>
    </div>
</form>