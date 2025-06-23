
@forelse($details as $quickText)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $quickText->title  ?? '-'}}</td>
        <td>{{ $quickText->description ?? '-' }}</td>
        <td class="text-center">
            @if(isCustomerUserGroup() || isRouteExists("admin.quick-texts.edit"))
                <a href="javascript::void(0);" class="editIcon me-1 addQuickTextBtn" data-id="{{ $quickText->id }}" data-bs-toggle="offcanvas" data-bs-target="#addQuickTextFromSidebar">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Edit') }}"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif
 
            @if(isCustomerUserGroup() || isRouteExists("admin.quick-texts.destroy"))
                <a class="erase text-danger" data-id="{{ $quickText->id }}" data-href="{{ route('admin.quick-texts.destroy', $quickText->id) }}" data-method="DELETE" href="javascript:void(0);">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Delete') }}"><i data-feather="trash" class="icon-14"></i></span>
                </a> 
            @endif
 
        </td>
    </tr>
@empty
     <x-common.empty-row colspan=4 />
@endforelse
{{ paginationFooter($details, 9) }}