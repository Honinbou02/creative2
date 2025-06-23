
    <div class="row g-2 mb-3 border-bottom pb-4">
            @forelse ($templates as $template)
        <div class="col-lg-3 col-md-4" id="{{$template->id}}">
            <div class="card flex-column h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="tt-integration-card__icon p-2">
                            @if($template->icon)
                                {!! $template->icon !!}
                            @else
                            {{localize('WR')}}
                            @endif
                        </div>
                        @if (isRouteExists('admin.templates.show') || isCustomerUserGroup())
                            <a href="{{ route('admin.templates.show', $template->id) }}" class="">
                                <x-common.small-btn label="Generate" title="{{ localize('Generate Content') }}"></x-common.small-btn>
                            </a>
                        @endif
                    </div>
                    <h3 class="h5">{{ $template->template_name }}</h3>
                    <p class="tt-line-clamp tt-clamp-2">{{ $template->description }}</p>
                </div>
                <div
                    class="mt-auto card-footer bg-transparent pb-2 pt-0 border-top-0 d-flex justify-content-between flex-wrap">
                    <div class="hstack gap-3">
                        <div class="d-flex align-items-center gap-1">
                            <i data-feather="file-text" class="icon-14 flex-shrink-0"></i>
                            <span class="d-inline-block flex-grow-1">
                                {{ $template->template_word_counts() }}
                            </span>
                        </div>
                        
                        @if($template->total_favourite)
                        <div class="d-flex align-items-center gap-1">
                            <i data-feather="heart" class="icon-14 flex-shrink-0"></i>
                            <span class="d-inline-block flex-grow-1">
                                {{ $template->total_favourite }}
                            </span>
                        </div>
                        @endif
                       
                        <div class="d-flex align-items-center gap-1">
                            <span class="badge {{$template->is_active == 1 ? 'bg-soft-success' : 'bg-soft-danger'}}  rounded-pill text-capitalize">
                                {{ $template->is_active == 1 ? localize('Enable') : localize('Disable')}}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-center">

                        @if (isRouteExists('admin.templates.edit') || $template->created_by_id === userID())
                            <a href="#"
                                data-update-url="{{ route('admin.templates.update', $template->id) }}"
                                data-url="{{ route('admin.templates.edit', $template->id) }}"
                                data-id="{{ $template->id }}" class="editIcon">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Template"><i data-feather="edit" class="icon-14"></i></span>
                            </a>
                        @endif
                        @if (isRouteExists('admin.templates.destroy') || $template->created_by_id === userID())
                            <button data-id="{{ $template->id }}"
                                data-href="{{ route('admin.templates.destroy', $template->id) }}"
                                data-method="DELETE" class="erase btn-sm p-0 bg-transparent border-0"
                                type="button">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Delete Template') }}"><i data-feather="trash-2"
                                        class="icon-14 text-danger"></i></span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
    <x-common.empty-div />
    @endforelse
</div>

{{ paginationFooterDiv($templates) }}
  