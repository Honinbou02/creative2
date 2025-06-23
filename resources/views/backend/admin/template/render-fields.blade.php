{{-- @isset($fields) --}}
    @foreach ($fields as $field)
        <div class="row g-2">
            <div class="col-6 col-md-3">
                <div class="mb-3">
                    <x-form.label for="input_types" label="{{ localize('Input Type') }}" />
                    <x-form.select name="input_types[]" id="input_types">
                        @foreach (appStatic()::INPUT_TYPES as $value => $intputType)
                            <option value="{{ $value }}" {{ $field->field->type == $value ? 'selected' : '' }}>
                                {{ $intputType }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mb-3">
                    <x-form.label for="input_names" label="{{ localize('Input Name') }}" isRequired=true />
                    <x-form.input name="input_names[]" id="input_names" onchange="generateInputNames(true)" type="text"
                        placeholder="{{ localize('Input Name') }}" value="{{ $field->field->name }}" showDiv=false />
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mb-3">
                    <x-form.label for="input_labels" label="{{ localize('Input Label') }}" isRequired=true />
                    <x-form.input name="input_labels[]" id="input_labels" value="{{ $field->label }}" type="text"
                        placeholder="{{ localize('Input Label') }}" showDiv=false />
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mb-3 mt-4">
                    <button type="button" class="ms-1 btn btn-sm btn-soft-danger">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
{{-- @endisset --}}
