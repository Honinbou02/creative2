<!-- Offcanvas -->
<form class="offcanvas offcanvas-end move-to-folder-form" action="{{ route('admin.folders.move-folder') }}"
    data-bs-backdrop="static" id="offcanvasMoveToFolder" tabindex="-1"> 
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">{{ localize('Move to Folder') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body" data-simplebar>
            <div class="text-center move-to-folder-wait mt-5">{{ localize('Please wait') }}...</div>
            <div class="move-to-folder-contents" id="move-to-folder-contents"></div>
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button id="frmActionBtn"
                    class="move-to-folder-submit-btn">{{ localize('Save') }}</x-form.button>
            </div>
        </div>
    </div>
</form> <!-- offcanvas template end-->

