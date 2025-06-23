@props([
    'color'         => 'primary',
    'shadow'        => '',
    'rounded'       => '',
    'rounded0'      => '',
    'roundedPill'   => '',
    'full'          => '',
    'icon'          => '',
    'circle'        => '',
    'type'          => '',
])

@if($shadow)
    @php $shadow = ' btn-shadow'; @endphp
@endif
@if($rounded)
    @php $rounded = ' rounded'; @endphp
@endif
@if($roundedPill)
    @php $roundedPill = ' rounded-pill'; @endphp
@endif
@if($rounded0)
    @php $rounded0 = ' rounded-0'; @endphp
@endif
@if($circle)
    @php $circle = ' rounded-circle'; @endphp
@endif
@if($full)
    @php $full = ' d-block w-100'; @endphp
@endif
@if($icon)
    @php $icon = ' btn-icon'; @endphp
@endif

@php $type = isset($type) ? $type : 'submit'; @endphp

<button {{ $attributes->merge(['class' => "d-flex align-items-center gap-1 btn btn-sm btn-".$color.$shadow.$rounded.$roundedPill.$rounded0.$circle.$full.$icon, 'type' =>  $type]) }}>{{ $slot }}</button>
