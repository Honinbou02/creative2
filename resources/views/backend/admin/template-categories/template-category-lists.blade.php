

@forelse($templateCategories as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->category_name }}</td>
        <td>{!! $row->icon ? $row->icon : '--' !!}</td>
        <td>{{ $row->createdBy?->name }}</td>
        <td> <div class="d-flex justify-content-center">
                @include("common.active-status-button",[
                    'active' => $row->is_active,
                    'id'     => encrypt($row->id),
                    'model'  => 'template_category',
                    'name'   => 'is_active',
                    
                ])
            </div>
            
        </td>
        <td class="text-center">
            @if(isRouteExists("admin.template-categories.edit") || $row->created_by_id === userID())
                <a href="#"
                   data-update-url="{{ route('admin.template-categories.update', $row->id) }}"
                   data-url="{{ route('admin.template-categories.edit',$row->id) }}"
                   data-id="{{ $row->id }}"
                   class="editIcon">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Edit Category') }}"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif

            @if(isRouteExists("admin.template-categories.destroy") || $row->created_by_id === userID())
                <a href="#" data-id="{{ $row->id }}"
                               data-href="{{ route('admin.template-categories.destroy', $row->id) }}"
                               data-method="DELETE"
                               class="erase btn-sm p-0 bg-transparent border-0"
                               type="button">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{localize('Delete Category')}}" class="text-danger ms-1"><i data-feather="trash-2" class="icon-14"></i></span>
                </a>
            @endif
        </td>
    </tr>
@empty
     <x-common.empty-row colspan=6 />
@endforelse
{{ paginationFooter($templateCategories, 6) }}
