<form action="{{ route('admin.avatarPro.createVideo') }}" method="POST" id="addAvatarProForm">
    <div class="offcanvas offcanvas-end" id="addAvatarProFormSidebar" tabindex="-1">
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">{{ localize('Add New Video') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />

            <div class="row g-3">
                <div class="col-12">
                    <label for="avatar_id" class="form-label">{{ localize("Select Video Avatar Style") }}</label>
                    <x-form.input
                        type="hidden"
                        name="avatar_id"
                        id="avatar_id"
                    />
                    <select id="avatar_id_select2" name="avatar_id" class="form-control form-select-sm select2" required>
                        <option value="">Loading...</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <x-form.label for="avatarStyle" label="Avatar Style" class="form-label"></x-form.label>
                    <select id="avatarStyle" name="avatar_style" class="form-control form-control-sm" required>
                        <option value="circle">{{ localize("Circle") }}</option>
                        <option value="normal">{{ localize("Normal") }}</option>
                        <option value="closeup">{{ localize("Close-up") }}</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <x-form.label for="matting" label="Matting" class="form-label"></x-form.label>
                    <select id="matting" name="matting" class="form-control form-control-sm">
                        <option value="1">{{ localize("True") }}</option>
                        <option value="0">{{ localize("False") }}</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <x-form.label for="caption" label="Caption" class="form-label"></x-form.label>
                    <select id="caption" name="caption" class="form-control form-control-sm" required>
                        <option value="Yes">{{ localize("Yes") }}</option>
                        <option value="No">{{ localize("No") }}</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="voice_id" class="form-label">{{ localize("Select Voice") }}
                        <button type="button" class="ms-1 py-0 px-2 btn btn-secondary playAudio">
                            {{ localize("Play Audio") }}
                        </button>
                    </label>
                    <select id="voice_id" name="voice_id" class="form-control form-select-sm voiceHtml select2" required>
                        <option value="">{{ localize("Loading") }}...</option>
                    </select>
                </div>

                

                <div class="mb-3">
                    <label for="script" class="form-label">{{ localize("Video Script Text") }}</label>
                    <x-form.textarea id="script" name="script" class="form-control" required></x-form.textarea>
                    <span>
                        <small>{{ localize("Please enter your video script text.") }}</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button id="addAvatarProBtn" type="submit">{{ localize('Create Video') }}</x-form.button>
                <x-form.button color="secondary" type="reset">{{ localize('Reset') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
