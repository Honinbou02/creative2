@forelse($blog_categories as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->category_name }}</td>
        <td class="text-center">
            @include('common.active-status-button', [
                'active' => $row->is_active,
                'id' => encrypt($row->id),
                'model' => 'blog_category',
                'name' => 'is_active',
            ])
        </td>
        <td>
            @if ($row->wp_id)
                <span class="badge bg-soft-success rounded-pill text-capitalize">
                    {{ localize('Yes') }} </span>
            @else
                <span class="badge bg-soft-warning rounded-pill text-capitalize">
                    {{ localize('No') }} </span>
            @endif
        </td>
        <td class="text-center">
            @if (isRouteExists('admin.blog-categories.edit'))
                <a href="#" data-update-url="{{ route('admin.blog-categories.update', $row->id) }}"
                    data-url="{{ route('admin.blog-categories.edit', $row->id) }}" data-id="{{ $row->id }}"
                    class="editIcon">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Edit') }}"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif

            @if (isRouteExists('admin.blog-categories.destroy'))
                <a href="#" data-id="{{ $row->id }}"
                    data-href="{{ route('admin.blog-categories.destroy', $row->id) }}" data-method="DELETE"
                    class="erase btn-sm p-0 bg-transparent border-0" type="button">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Delete') }}" class="text-danger ms-1"><i data-feather="trash-2"
                            class="icon-14"></i></span>
                </a>
            @endif
        </td>
    </tr>
@empty
    <x-common.empty-row colspan=5 />
@endforelse
{{ paginationFooter($blog_categories, 5) }}
