

@forelse($blogs as $blog)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $blog->title }}</td>
        <td>{{$blog->category->category_name}}</td>
        <td>{{ @$blog->createdBy->name}}</td>
        <td class="text-center">
            @include("common.active-status-button",[
               'active' => $blog->is_active,
               'id'     => encrypt($blog->id),
               'model'  => 'blog',
               'name'   => 'is_active',
           ])
        </td>
        <td class="text-center">
            @if(isRouteExists("admin.blogs.edit"))
                <a href="#"
                   data-update-url="{{ route('admin.blogs.update', $blog->id) }}"
                   data-url="{{ route('admin.blogs.edit',$blog->id) }}"
                   data-id="{{ $blog->id }}"
                   class="editIcon">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Edit') }}"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif

            @if(isRouteExists("admin.blogs.destroy"))
                <a href="#" data-id="{{ $blog->id }}"
                               data-href="{{ route('admin.blogs.destroy', $blog->id) }}"
                               data-method="DELETE"
                               class="erase btn-sm p-0 bg-transparent border-0"
                               type="button">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Delete') }}" class="text-danger ms-1"><i data-feather="trash-2" class="icon-14"></i></span>
                </a>
            @endif
        </td>
    </tr>
@empty
     <x-common.empty-row colspan=6 />
@endforelse
{{ paginationFooter($blogs, 6) }}
