
@isset($editBrandVoice)
    @method('PUT')
@else
    @method('POST')
@endisset


<div class="row g-2">
    <div class="col-lg-12">
        <div class="mb-2">
            <x-form.label for="title" label="{{ localize('Brand Title') }}" isRequired="true"></x-form.label>
            <x-form.input
                    name="brand_name"
                    id="brand_name"
                    isRequired="true"
                    value="{{ isset($editBrandVoice) ? $editBrandVoice->brand_name : old('brand_name') }}"
            />
            <small> {{ localize('Ex. Apple Co.') }}</small>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="mb-2">
            <x-form.label for="title" label="{{ localize('Brand Website') }}" isRequired="true"></x-form.label>
            <x-form.input
                    id="brand_website"
                    name="brand_website"
                    value="{{ isset($editBrandVoice) ? $editBrandVoice->brand_website : old('brand_website') }}"
                    isRequired="true"
            />
            <small> {{ localize('Ex.') }} {{ url("/") }}</small>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="mb-2">
            <x-form.label for="title" label="{{ localize('Brand Industry') }}" isRequired="true"></x-form.label>
            <x-form.select class="select2Tag form-control" multiple="multiple" name="industry[]">
                <option value=""></option>
                @isset($editBrandVoice)
                    @php
                        $industry = $editBrandVoice->industry;
                        $industries = json_decode($industry);
                        $industryNames = [];
                        foreach($industries as $industry){
                            $industryNames[] = $industry;
                        }
                    @endphp

                    @foreach($industryNames ?? [] as $industryName)
                        <option value="{{ $industryName }}" selected>{{ $industryName }}</option>
                    @endforeach
                @endisset
            </x-form.select>
            <small>{{ localize("Type industry name & Press Enter to type another") }}</small>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="mb-2">
            <x-form.label for="title" label="{{ localize('Brand Tagline') }}" isRequired="true"></x-form.label>
            <x-form.input
                    id="brand_tagline"
                    value="{{ isset($editBrandVoice) ? $editBrandVoice->brand_tagline : old('brand_tagline') }}"
                    name="brand_tagline"
                    isRequired="true"
            />
            <small> {{ localize('Ex. Innovative Solutions for Modern Business') }}</small>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="mb-2">
            <x-form.label for="title" label="{{ localize('Target Audience') }}" isRequired="true"></x-form.label>
            <x-form.input
                    id="brand_audience"
                    value="{{ isset($editBrandVoice) ? $editBrandVoice->brand_audience : old('brand_audience') }}"
                    name="brand_audience"
                    isRequired="true"
            />
            <small> {{ localize('Ex. Your Target audience.') }}</small>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="mb-2">
            <x-form.label for="title" label="{{ localize('Voice Tone') }}" isRequired="true"></x-form.label>
            <x-form.select
                    id="brand_tone"
                    name="brand_tone"
                    class="select2"
                    isRequired="true">
                @forelse($tones as $tone)
                    <option value="{{ $tone }}" @selected(isset($editBrandVoice) && $editBrandVoice->brand_tone == $tone)>
                        {{ localize($tone) }}
                    </option>
                @empty

                @endforelse
            </x-form.select>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="mb-2">
            <x-form.label for="title" label="{{ localize('Brand Description') }}" isRequired="true"></x-form.label>
            <x-form.textarea
                    id="brand_description"
                    name="brand_description"
                    isRequired="true">{{ isset($editBrandVoice) ? $editBrandVoice->brand_description : old('brand_description') }} </x-form.textarea>
            <small>{{ localize("Ex. Write about your brand/company") }}</small>
        </div>
    </div>

    <div class="col-lg-12">
        <h5 class="mb-2">{{ localize("Products Or Services") }}</h5>
        <div class="table-responsive-md">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ localize("Product Or Service Name") }}</th>
                        <th>{{ localize("Description") }}</th>
                        <th>{{ localize("Type") }}</th>
                        <th>{{ localize("Action") }}</th>
                    </tr>
                </thead>
                <tbody class="productServicesTbody">
                    @isset($editBrandVoice)
                        @forelse($editBrandVoice->products ?? [] as $key=>$product)
                            @include("backend.admin.brand-voice.tr-brand-product")
                        @empty
                            @include("backend.admin.brand-voice.tr-brand-product")
                        @endforelse
                    @else
                        @include("backend.admin.brand-voice.tr-brand-product")
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
