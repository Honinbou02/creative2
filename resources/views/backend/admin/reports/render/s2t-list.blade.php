@forelse ($usage as $key => $use)
<tr>
    <td class="text-center">
        {{ $key + 1 + ($usage->currentPage() - 1) * $usage->perPage() }}</td>

    <td>
        <h6 class="fs-sm mb-0 ms-2">{{ $use->title }}</h6>
    </td>
    <td>
        <span class="fw-bold">
            {{ $use->createdBy->name }}
        </span>
    </td>
    <td>
        <span class="fs-sm">{{ date('d M, Y', strtotime($use->created_at)) }}</span>
    </td>

    <td class="text-end">
        <span class="fw-bold">{{ $use->words }}</span>
    </td>
</tr>
@empty
<x-common.empty-row colspan=5 />
@endforelse