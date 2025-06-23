

@forelse($credentials as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->domain }}</td>
        <td>{{ $row->user}}</td>
        <td>{{ $row->password }}</td>
        <td class="text-center"> <i data-feather="{{ $row->is_connection == 1 ? 'check-circle' : 'x-circle' }}"
            class="icon-14 me-2 {{ $row->is_connection == 1 ? 'text-success' : 'text-danger' }}"></i><strong
            class="me-1"></td>
        <td class="d-flex justify-content-center">
            @include("common.active-status-button",[
               'active' => $row->is_active,
               'id'     => encrypt($row->id),
               'model'  => 'wordpress_credentials',
               'name'   => 'is_active',
               
           ])
        </td>
        <td class="text-center">
            @if(isRouteExists("admin.wordpress-credentials.edit") || $row->created_by_id === user()->id)
                <a href="#"
                   data-update-url="{{ route('admin.wordpress-credentials.update', $row->id) }}"
                   data-url="{{ route('admin.wordpress-credentials.edit',$row->id) }}"
                   data-id="{{ $row->id }}"
                   class="editIcon">
                    <span title="Edit"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif

            @if(isRouteExists("admin.wordpress-credentials.destroy") || $row->created_by_id === user()->id)
                <a href="#" data-id="{{ $row->id }}"
                               data-href="{{ route('admin.wordpress-credentials.destroy', $row->id) }}"
                               data-method="DELETE"
                               class="erase btn-sm p-0 bg-transparent border-0"
                               type="button">
                    <span title="{{localize('Delete Record')}}" class="text-danger ms-1"><i data-feather="trash-2" class="icon-14"></i></span>
                </a>
            @endif
        </td>
    </tr>
@empty
     <x-common.empty-row colspan=6 />
@endforelse
{{ paginationFooter($credentials, 6) }}
