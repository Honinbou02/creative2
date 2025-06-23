<form action="{{ route('admin.folders.store') }}" method="POST" id="addFolderForm">
    <div class="offcanvas offcanvas-end" id="addFolderFormSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title">{{ localize('Add New Folder') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />
          
            <div class="mb-3">
                <x-form.label for="folder_name" label="{{ localize('Name') }}" isRequired=true />
                <x-form.input name="folder_name" id="folder_name"
                              type="text"
                              placeholder="{{ localize('Name') }}"
                              value=""
                              showDiv=false
                />
            </div>
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button id="frmActionBtn">{{ localize('Save') }}</x-form.button>
                <x-form.button color="secondary" type="reset">{{ localize('Reset') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
