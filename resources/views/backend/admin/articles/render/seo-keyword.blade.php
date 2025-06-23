@php
    $className = isset($isMain) && $isMain ? "mainKeywordInput" : "relatedKeywordInput";
    $inputType = isset($isMain) && $isMain ? "radio"            : "checkbox";
@endphp
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ localize("Keyword") }}</th>
                <th>{{ localize("Competition") }}</th>
                <th>{{ localize("CPC") }}</th>
                <th>{{ localize("Volume") }}</th>
            </tr>
        </thead>
        <tbody>
            @php $loopNo = 0; @endphp
            @forelse($keywords as $key => $keyword)
                <tr>
                    <td>
                        <div class="form-check tt-checkbox mb-0">
                            <x-form.input
                                    name="keywords[]"
                                    type="{{ $inputType }}"
                                    class="form-check-input cursor-pointer mb-0 {{ $className }}"
                                    id="{{ $className }}keywordList{{ $key }}"
                                    value="{{ $key }}"
                                    :showDiv="false"
                            />

                            <x-form.label for="{{ $className }}keywordList{{ $key }}" class="form-label cursor-pointer fw-normal mb-0" >{{ $key }}</x-form.label>
                        </div>
                    </td>
                    <td> {{ $keyword["competition"] ?? 0.00 }} </td>
                    <td> {{ $keyword["cpc"] ?? 0.00 }} </td>
                    <td> {{ $keyword["search_volume"] ?? 0 }} </td>
                </tr>
                @php $loopNo++; @endphp
            @empty
            @endforelse
        </tbody>
    </table>
</div>
