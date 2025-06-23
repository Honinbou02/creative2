@forelse($prompts ?? [] as $key => $row)
    <tr>
        <td class="text-left">{{ $key + 1 + ($prompts->currentPage() - 1) * $prompts->perPage() }}</td>
        <td>{{ $row->promptGroup->group_name }}</td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->createdBy?->name ?: "" }}</td>
        <td class="text-center">
            @include("common.active-status-button",[
               'active' => $row->is_active,
               'id'     => encrypt($row->id),
               'model'  => 'prompts',
               'name'   => 'is_active',
           ])
        </td>
        <td class="text-center">
            @if(isRouteExists("admin.prompts.edit"))
                <a href="#" data-update-url="{{ route('admin.prompts.update', $row->id) }}"
                    data-url="{{ route('admin.prompts.edit',$row->id) }}"
                    data-id="{{ $row->id }}" class="editIcon">
                    <span title="Edit"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif
            @if(isRouteExists("admin.prompts.destroy"))
                <a href="#" data-id="{{ $row->id }}"
                    data-href="{{ route('admin.prompts.destroy', $row->id) }}"
                    data-method="DELETE" class="erase text-danger ms-1">
                    <span title="Delete User"><i data-feather="trash-2" class="icon-14"></i></span>
                </a>
            @endif
        </td>
    </tr>
@empty
    <x-common.empty-row colspan=5 />
@endforelse
{{ paginationFooter($prompts, 5) }}