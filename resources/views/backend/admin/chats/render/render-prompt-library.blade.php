@foreach ($groupPrompts as $prompt)
    <div class="col-lg-6 col-xl-4 promptBtn" data-prompt="{!! $prompt->description !!}">
        <div class="tt-prompt-single-content p-3 rounded shadow-sm card">
            <h3 class="h6 mb-1">{{ $prompt->name }}</h3>
            <p class="fs-md">{{ $prompt->description }}
        </div>
    </div>
@endforeach
{{ paginationFooterDiv($groupPrompts) }}
