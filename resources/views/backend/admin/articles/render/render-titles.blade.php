@php
    // $titles = textReplace($titles,"'","");
    // $titles = textReplace($titles,'"',"");

    // $titles = explode(',', trim($titles, "[]"));
@endphp
@forelse($titles as $key => $title)
    <li class="keyword-list__item">
        <div class="form-check tt-checkbox mb-0">
            <x-form.input
                    name="title"
                    type="radio"
                    class="form-check-input cursor-pointer mb-0 titleRadioInput"
                    id="titleList{{ $key }}"
                    value="{{ $title }}"
                    :showDiv="false"
            />
            <x-form.label for="titleList{{$key}}" class="form-label fw-normal cursor-pointer mb-0">{{ $title }}</x-form.label>
        </div>
    </li>
@empty
@endforelse