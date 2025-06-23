@if(isUseGeminiAiEngine())

@endif
@forelse($outlines as $key => $outline)
    @if (!empty($outline['outline']))
    @php
        $outline_only = !empty($outline['outline_only']) ? implode(",", $outline['outline_only']) : "";
    @endphp
    <li class="mb-3">
        <div class="form-check tt-article-title p-0">
            <x-form.input
                    name="outline"
                    type="radio"
                    isChecked="@checked($loop->first)"
                    class="form-check-input tt-custom-radio outlineRadioInput"
                    id="outlineList{{ $key }}"
                    value="{{ $outline_only }}"
                    :showDiv="false"
            />

            <x-form.label
                    for="outlineList{{$key}}"
                    class="form-check-label w-100 p-4 rounded-3 bg-light-subtle fw-normal cursor-pointer">
                <ul class="tt-article-outline-list ps-3">
                    @foreach ($outline['outline'] as $section)
                        <li>
                            <div class="d-block fs-14"> {{ $section['section'] }} </div>
                            <small class="d-block"> {{ $section['details'] }} </small>
                        </li>
                    @endforeach
                </ul>
            </x-form.label>
        </div>
    </li>
    @endif
@empty
<div>NOT FOUND</div>
@endforelse