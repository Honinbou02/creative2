<form action="{{ route('admin.brand-voices.store') }}" method="POST" id="addBrandVoiceForm">
    <div class="offcanvas offcanvas-end" id="addBrandVoiceFromSidebar" tabindex="-1">
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title brandVoiceCanvasTitle">{{ localize('Add Brand Voice') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body brandVoiceCanvasBody">
            <x-common.message class="mb-3" />

            @include("backend.admin.brand-voice.form-brand-voice")
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button type="submit" class="saveBrandVoiceBtn btn-sm"> <i data-feather='save'></i>{{ localize('Save Brand Voice') }}
                </x-form.button>
                <x-form.button color="secondary" type="reset">{{ localize('Reset') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
