@php
    // $metaDescriptions = textReplace($metaDescriptions,"'","");
    // $metaDescriptions = textReplace($metaDescriptions,'"',"");

    // $metaDescriptions = explode(',', trim($metaDescriptions, "[]"));
@endphp

@forelse($metaDescriptions ?? [] as $key => $metaDescription)
    <li class="keyword-list__item">
        <div class="form-check tt-checkbox mb-0">
            <x-form.input
                    name="meta_descriptions[]"
                    type="radio"
                    class="form-check-input cursor-pointer mb-0 metaDescriptionInput"
                    id="metaDescriptionList{{ $key }}"
                    value="{{ $metaDescription }}"
                    :showDiv="false"
            />

            <x-form.label for="metaDescriptionList{{$key}}" class="form-label cursor-pointer fw-normal mb-0" >{{ $metaDescription }}</x-form.label>
        </div>
    </li>
@empty
@endforelse

