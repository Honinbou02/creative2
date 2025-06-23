@php
    $className = isset($isMain) && $isMain ? "mainKeywordInput" : "relatedKeywordInput";
    $inputType = isset($isMain) && $isMain ? "radio" : "checkbox";
@endphp

@forelse($keywords as $key=>$keyword)
    <li class="keyword-list__item">
        <div class="form-check tt-checkbox mb-0">
            <x-form.input
                    name="keywords[]"
                    type="{{ $inputType }}"
                    class="form-check-input cursor-pointer mb-0 {{ $className }}"
                    id="{{ $className }}keywordList{{ $key }}"
                    value="{{ $keyword }}"
                    :showDiv="false"
            />

            <x-form.label for="{{ $className }}keywordList{{$key}}" class="form-label cursor-pointer fw-normal mb-0" >{{ $keyword }}</x-form.label>
        </div>
    </li>
@empty
@endforelse

