<form action="" method="POST" id="addMoveToFolderForm">
    <div class="offcanvas offcanvas-end" id="addMoveToFolderFormSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title" id="generated-title">{{ localize('Move to Folder') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>

        <x-common.splitter />
        <div class="offcanvas-body">
            <div class="" id="moveToFolderContainer">
                
            </div>
        </div>

    </div>
</form>
