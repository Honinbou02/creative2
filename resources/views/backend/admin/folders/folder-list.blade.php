@forelse($folders as $row)
    <div class="col-md-6 col-lg-3" id="{{$row->id}}">
        <div class="d-flex align-items-center justify-content-between border rounded tt-single-folder">
            <a href="{{route('admin.documents.index', ['folder_id'=>$row->id])}}" target="_blank" class="d-flex align-items-center gap-2 p-3 tt-folder-title">
                <i data-feather="folder" class="me-1 flex-shrink-0" width="32" height="32"></i>
                <div class="tt-folder-title">
                    <h6 class="tt-line-clamp fw-medium tt-clamp-1 mb-0">
                        {{ $row->folder_name }}
                    </h6>
                    <small class="text-muted"> {{$row->generate_images_count + $row->generate_contents_count}} {{ localize('Files') }}</small>
                </div>
            </a>
            <div class="dropdown tt-tb-dropdown pe-2">
                <span class="cursor-pointer tt-dropdown-icon" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i data-feather="more-vertical" class="icon-16"></i></span>
                <div class="dropdown-menu dropdown-menu-end shadow">

                    @if (isRouteExists('admin.folders.edit'))
                        <a href="javascript:void(0);" data-update-url="{{ route('admin.folders.update', $row->id) }}"
                            data-url="{{ route('admin.folders.edit', $row->id) }}" data-id="{{ $row->id }}"
                            class="editIcon dropdown-item">
                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                        </a>
                    @endif

                    @if (isRouteExists('admin.folders.destroy'))
                        <a class="dropdown-item erase" data-id="{{ $row->id }}"
                            data-href="{{ route('admin.folders.destroy', $row->id) }}" data-method="DELETE"
                            class="erase btn-sm p-0 bg-transparent border-0" href="javascript:void(0);">
                            <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
                        </a>
                    @endif
                </div>
            </div>
        </div> 
    </div>
@empty

    <x-common.empty-div />
@endforelse
{{ paginationFooterDiv($folders) }}
