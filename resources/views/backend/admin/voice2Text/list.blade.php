

@forelse($lists as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->title }}</td>
        <td>{{ $row->response }}</td>
        <td>{{ $row->createdBy?->name ?: "" }}</td>
        <td>{{ manageDateTime($row->created_at)  }}</td>
        <td>{{ manageDateTime($row->updated_at)  }}</td>
       
        <td >
           

            @if(isRouteExists("admin.ai-writer.show"))              
                <a href="{{ route('admin.ai-writer.show', $row->id) }}" target="_blank" data-id={{ $row->id }} class="editIcon">
                    <span title="Edit"><i data-feather="eye" class="icon-14"></i></span>
                </a>
            @endif
            @if(isRouteExists("admin.ai-writer.destroy"))
                <x-form.button data-id="{{ $row->id }}"
                               data-href="{{ route('admin.ai-writer.destroy', $row->id) }}"
                               data-method="DELETE"
                               class="erase btn-sm p-0 bg-transparent border-0"
                               type="button">
                    <span title="Delete User"><i data-feather="trash-2" class="icon-14 text-danger"></i></span>
                </x-form.button>
            @endif
        </td>
    </tr>
@empty
        <x-common.empty-row colspan=8 />
@endforelse
{{ paginationFooter($lists, 8) }}