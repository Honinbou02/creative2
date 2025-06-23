@forelse ($usage as $key => $use)
<tr>
    <td class="text-center">
        {{ $key + 1 + ($usage->currentPage() - 1) * $usage->perPage() }}</td>



    <td>
        @php
        $image_path = $use->storage_type == 'aws' ? $use->file_path : urlVersion($use->file_path);
    @endphp
    <a href="{{ $image_path }}" target="_blank" class="d-flex align-items-center fs-sm">{{ $use->title }}</a>
        </a>
    </td>
    <td >
        <span class="">{{ $use->generated_image_resolution }}</span>
    </td>
    <td>  {{ $use->createdBy->name }}</td>
    <td class=""> {{ localize(ucwords(str_replace('_', ' ', $use->content_type))) }}  </td>
    <td class="text-end">
        <span class="fs-sm">{{ date('d M, Y', strtotime($use->created_at)) }}</span>
    </td>


</tr>

{{-- modal --}}

@empty
<x-common.empty-row colspan=6 />
@endforelse
{{ paginationFooter($usage, 6) }}
