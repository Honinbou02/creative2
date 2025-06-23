<form action="{{ route('admin.voice.cloneVoice') }}" enctype="multipart/form-data" id="voiceCloneFrmID" method="POST">
    <div class="offcanvas offcanvas-end" id="addVoiceCloneSidebar" tabindex="-1">
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title">{{ localize('Voice Clone') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />

            <div class="row g-2">
                <x-form.input type="hidden"
                                name="content_purpose"
                                id="content_purpose"
                                value="{{ appStatic()::PURPOSE_VOICE_CLONE }}"
                />

                <div class="col-lg-6 mb-3">
                    <x-form.label for="audio_file" class="form-label">
                        {{ localize("Name") }}
                    </x-form.label>
                    <x-form.input
                        type="text"
                        name="name"
                        id="name"
                    />
                    <span>
                        <small>{{ localize("Please enter the name of the audio") }}</small>
                    </span>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <x-form.label for="audio" class="form-label" label="Description">
                        </x-form.label>
                        <x-form.input
                                type="text"
                                name="description"
                                id="description"
                        />
                        <span>
                            <small>{{ localize("Please enter description of the audio") }}</small>
                        </span>
                    </div>
                </div>

                <div class="col-12">
                    <label for="audio_file" class="w-100 file-drop-area file-upload text-center rounded-3"> 
                        <x-form.input
                                type="file"
                                class="file-drop-input"
                                name="audio_file"
                                id="audio_file"
                        />
                        <div class="file-drop-icon ci-cloud-upload">
                            <i data-feather="image"></i>
                        </div>
                        <p class="text-dark fw-bold mb-2 mt-3">
                            {{ localize('Drop your files here or') }}
                            <span class="text-primary cursor-pointer">{{ localize('Browse') }}</span>
                        </p>
                        <p class="mb-0 file-name text-muted">
                            <small>* {{ localize('Allowed file types: ') }} .mp3, .mp4, .mpeg,
                                .mpga, .m4a,
                                .wav, .webm @if (isCustomerUserGroup())
                                    | {{ localize('Max Size: ') }} MB
                                @endif </small>
                        </p> 
                    </label>
                </div>

                <div class="form-group">
                    <x-form.label for="audio" class="form-label col-12" label="Status">
                        <x-form.select>
                            <option value="1">{{ localize("Active") }}</option>
                            <option value="2">{{ localize("Inactive") }}</option>
                        </x-form.select>
                    </x-form.label>
                </div>

            </div>
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button class="btn btn-primary" id="frmActionBtn" type="submit">
                    {{ localize('Clone Voice') }}
                </x-form.button>
                <x-form.button color="secondary" type="reset">{{ localize('Reset') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
