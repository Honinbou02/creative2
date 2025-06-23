@forelse($users ?? [] as $key => $row)
    <tr>
        <td class="text-center">{{ $key + 1 + ($users->currentPage() - 1) * $users->perPage() }}</td>
        <td class="text-center">{{ appStatic()::USER_TYPES[$row->user_type] }}</td>
        <td>
            <strong class="badge bg-accent badge-shadow">
                {{ $row->roles[0]->name ?? "N?A"}}
            </strong>
        </td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->email }}</td>
        <td>{{ $row->mobile_no }}</td>
        <td>{{ manageDateTime($row->created_at,2)  }}</td>
        <td class="text-center">
            @if($row->user_type !== appStatic()::TYPE_ADMIN)
                <a href="#" data-id={{ $row->id }} data-status={{ $row->is_active }} class="changeUserStatus">
                    {!! $row->is_active ? '<span class="text-success" title="Active"><i data-feather="check-circle" class="icon-14"></i></span>' : '<span class="text-danger" title="disable"><i data-feather="x-circle" class="icon-14"></i></span>' !!}
                </a>
            @endif
        </td>
        <td class="text-center">
            @if($row->user_type !== appStatic()::TYPE_ADMIN)
                @if(user()->user_type == appStatic()::TYPE_ADMIN || userID() === $row->created_by_id)
                    <a href="#" data-id={{ $row->id }} class="editIcon">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Edit') }}"><i data-feather="edit" class="icon-14"></i></span>
                    </a>
                @endif
                <a href="#"
                   data-id="{{ $row->id }}"
                   data-url="{{ route('admin.users.destroy', $row->id) }}"
                   data-method="DELETE"
                   class="deleteUser text-danger ms-1">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Delete') }}"><i data-feather="trash-2" class="icon-14"></i></span>
                </a>
            @endif
        </td>
    </tr>
@empty
    <x-common.empty-row colspan=9 />
@endforelse

{{ paginationFooter($users, 9) }}

