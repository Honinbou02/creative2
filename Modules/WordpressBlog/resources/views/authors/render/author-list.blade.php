@forelse($lists ?? [] as $key => $row)
    <tr>
        <td class="text-left">{{ $key + 1 + ($lists->currentPage() - 1) * $lists->perPage() }}</td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->email }}</td>
        <td>{{ $row->username }}</td>
    </tr>
@empty
    <x-common.empty-row colspan=4 />
@endforelse

{{ paginationFooter($lists, 4) }}
