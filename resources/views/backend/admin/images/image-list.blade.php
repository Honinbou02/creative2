@forelse($images as $key=>$image)
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 imageItem {{ $image->content_type }}" id="{{$image->id}}">
        <div class="tt-result-content-wrap">
            <div class="tt-generate-img-wrap position-relative">
                <a
                    href="#imageView"
                    class="tt-generate-img position-relative rounded-3 imgViewModal"
                    data-bs-toggle="modal"
                    data-bs-target="#imageView"
                    data-title="{{ $image->title }}"
                    data-image-url="{{ urlVersion($image->file_path) }}"
                    data-size="{{ $image->generated_image_resolution }}"
                    data-model="{{ $image->model_name }}"
                    data-prompt="{{ $image->prompt }}"
                    data-createdAt="{{ manageDateTime($image->created_at) }}"
                    data-platform="{{ getPlatFormNameByPlatFormType($image->platform) }}">
                    <img src="{{ urlVersion($image->file_path) }}"
                         loading="lazy"
                         alt="{{ $image->title }}"
                         class="img-fluid rounded-3"
                    />
                </a>
                <div class="tt-overly-icon position-absolute d-flex flex-column gap-1 p-1 right-0">
                    <a href="{{ urlVersion($image->file_path) }}" download=""
                        class="overly-btn overly-download bg-success text-light">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{localize('Download Image')}}"><i data-feather="download" class="icon-14"></i></span>
                    </a>
                    <a href="#" class="overly-btn overly-delete bg-white text-light" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasMoveToFolder" onclick="showSaveToFolderModal({{$image->id}}, 'generated_image')">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{localize('Move To Folder')}}"><i data-feather="folder" class="icon-14 text-black"></i></span>
                    </a>
                    <a href="#" data-id="{{ $image->id }}"
                        data-href="{{ route('admin.images.destroy', $image->id) }}" data-method="DELETE"
                        class="erase overly-btn overly-delete bg-danger text-light">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{localize('Delete Image')}}"><i data-feather="trash" class="icon-14"></i></span>
                    </a>
                </div>
            </div>
            <div class="tt-generate-img-info mt-2">
                <p class="tt-line-clamp tt-clamp-1 mb-0"> {{ $image->title }}</p>
                <p class="text-muted fs-md">
                    <span class="badge bg-secondary fw-medium">
                        {{ getPlatFormNameByPlatFormType($image->platform == 'stable_diffusion' ? 2 : $image->platform) }}
                    </span>
                    {{ localize('Size') }}: {{ $image->generated_image_resolution }}
                </p>
            </div>
        </div>
    </div>
@empty
    <x-common.empty-div />
@endforelse

{{ paginationFooter($images, 8) }}
