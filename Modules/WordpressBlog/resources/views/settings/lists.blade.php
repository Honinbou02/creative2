

@forelse($settings as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->domain }}</td>
        <td>{{ $row->user}}</td>
        <td>{{ $row->password }}</td>
        <td class="d-flex justify-content-center">
            @include("common.active-status-button",[
               'active' => $row->is_active,
               'id'     => encrypt($row->id),
               'model'  => 'wordpress_settings',
               'name'   => 'is_active',
               
           ])
        </td>
        <td class="text-center">
            @if(isRouteExists("admin.wordpress-settings.edit") || $row->created_by_id === user()->id)
                <a href="#"
                   data-update-url="{{ route('admin.wordpress-settings.update', $row->id) }}"
                   data-url="{{ route('admin.wordpress-settings.edit',$row->id) }}"
                   data-id="{{ $row->id }}"
                   class="editIcon">
                    <span title="Edit"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif

            @if(isRouteExists("admin.wordpress-settings.destroy") || $row->created_by_id === user()->id)
                <a href="#" data-id="{{ $row->id }}"
                               data-href="{{ route('admin.wordpress-settings.destroy', $row->id) }}"
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
{{ paginationFooter($settings, 6) }}
