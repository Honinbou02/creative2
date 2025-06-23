<div class="row mb-4 g-4">
    <!--left sidebar-->
    <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
        <form action="{{ route('admin.appearance.update') }}"  id="contactUsTab" method="POST"  class="appearanceForm">
            @csrf
            <input type="hidden" name="language_key" id="language_id" value="{{ $lang_key }}">
            <!--Navbar-->
            <div class="card mb-4" id="section-1">
                <div class="card-header">
                    <h5 class="mb-0">{{ localize('Contact US') }}</h5>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label for="contact_us_phone_svg"
                               class="form-label">{{ localize('Contact Phone SVG ') }}</label>
                        <input type="text"
                               id="contact_us_phone_svg"
                               name="types[contact_us_phone_svg]"
                               class="form-control"
                               value="{{ systemSettingsLocalization('contact_us_phone_svg', $lang_key) }}">
                    </div>

                    <div class="mb-3">
                        <label for="contact_us_phone_number"
                               class="form-label">{{ localize('Contact Phone Number ') }}</label>
                        <input type="text"
                               id="contact_us_phone_number"
                               name="types[contact_us_phone_number]"
                               class="form-control"
                               value="{{ systemSettingsLocalization('contact_us_phone_number', $lang_key) }}">
                    </div>

                    <div class="mb-3">
                        <label for="contact_us_email_svg"
                               class="form-label">{{ localize('Contact Email SVG ') }}</label>
                        <input type="text"
                               id="contact_us_email_svg"
                               name="types[contact_us_email_svg]"
                               class="form-control"
                               value="{{ systemSettingsLocalization('contact_us_email_svg', $lang_key) }}">
                    </div>

                    <div class="mb-3">
                        <label for="contact_us_email"
                               class="form-label">{{ localize('Contact Email Number ') }}</label>
                        <input type="text"
                               id="contact_us_email"
                               name="types[contact_us_email]"
                               class="form-control"
                               value="{{ systemSettingsLocalization('contact_us_email', $lang_key) }}">
                    </div>

                    <div class="col-md-12">
                        <x-form.label for="is_active"
                                      label="{{ localize('Is Active?') }}" />
                        <select name="settings[ai_journey_is_active]" id="is_active" class="form-control">
                            <option value="1" {{ getSetting('ai_journey_is_active') == '1' ? 'selected' : '' }}> {{ localize('Enable') }}</option>
                            <option value="0" {{ getSetting('ai_journey_is_active') == '0' ? 'selected' : '' }}>{{ localize('Disable') }}</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer bg-transparent mt-3">
                    <x-form.button type="submit" class="settingsSubmitButton btn-sm"><i data-feather="save"></i>{{ localize('Save Configuration') }}</x-form.button>
                </div>
            </div>
        </form>
    </div>
</div>
