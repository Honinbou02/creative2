@forelse($promptGroups ?? [] as $key => $row)
    <tr>
        <td class="text-left">{{ $key + 1 + ($promptGroups->currentPage() - 1) * $promptGroups->perPage() }}</td>
        <td>{{ $row->group_name }}</td>
        <td>{{ $row->createdBy?->name ?: "" }}</td>
        <td class="text-center">
            @include("common.active-status-button",[
               'active' => $row->is_active,
               'id'     => encrypt($row->id),
               'model'  => 'prompt_groups',
               'name'   => 'is_active',
           ])
        </td>
        <td class="text-center">
            @if(isRouteExists("admin.prompt-groups.edit"))
                <a href="#" data-update-url="{{ route('admin.prompt-groups.update', $row->id) }}"
                    data-url="{{ route('admin.prompt-groups.edit',$row->id) }}"
                    data-id="{{ $row->id }}" class="editIcon">
                    <span title="Edit"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif
            @if(isRouteExists("admin.prompt-groups.destroy"))
                <a href="#" data-id="{{ $row->id }}"
                    data-href="{{ route('admin.prompt-groups.destroy', $row->id) }}"
                    data-method="DELETE" class="erase text-danger ms-1">
                    <span title="Delete User"><i data-feather="trash-2" class="icon-14"></i></span>
                </a>
            @endif
        </td>
    </tr>
@empty
    <x-common.empty-row colspan=5 />
@endforelse
{{ paginationFooter($promptGroups, 5) }}