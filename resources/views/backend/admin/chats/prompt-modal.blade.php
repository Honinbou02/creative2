<!-- prompt modal start -->
<div class="modal fade" id="promptModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="promptModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 tt-modal-header">
                <div class="d-flex align-items-center">
                    <h3 class="modal-title h5" id="exampleModalLabel">{{ localize('Prompt Library') }}</h3>

                </div>
                <span class="tt-close-btn rounded-circle shadow-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x" class="icon-16"></i>
                </span>
            </div>
            <div class="modal-body tt-prompt-body tt-custom-scrollbar p-0">
                <div class="border-bottom border-top sticky-top bg-light-subtle">
                    <span class="nav-line-tab-left-arrow text-center cursor-pointer ms-2">
                        <i data-feather="chevron-left" class="icon-16"></i>
                    </span>
                    <ul class="nav nav-line-tab fw-medium px-3">
                        <li class="nav-item">
                            <a href="#" class="nav-link  promptGroup active" data-id="all" data-bs-toggle="tab"
                                aria-selected="true">
                                {{ localize('All') }}
                            </a>
                        </li>
                        @isset($groups)
                            @foreach ($groups as $id => $group)
                                <li class="nav-item">
                                    <a href="#prmptGroup{{ $id }}" class="nav-link promptGroup"
                                        data-id="{{ $id }}" data-bs-toggle="tab" aria-selected="false">
                                        {{ $group }}
                                    </a>
                                </li>
                            @endforeach
                        @endisset


                    </ul>
                    <span class="nav-line-tab-right-arrow text-center cursor-pointer me-2">
                        <i data-feather="chevron-right" class="icon-16"></i>
                    </span>
                </div>
                <div class="card">


                    <div class="card-body tt-custom-scrollbar bg-secondary-subtle">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="allPrm">
                                <div class="row g-3" id="renderPromptLibrary">
                                    @isset($groupPrompts)
                                        @foreach ($groupPrompts as $prompt)
                                            <div class="col-lg-6 col-xl-4 promptBtn" data-prompt="{!! $prompt->description !!}">
                                                <div class="tt-prompt-single-content p-3 rounded shadow-sm card">
                                                    <h3 class="h6 mb-1">{{ $prompt->name }}</h3>
                                                    <p class="fs-md">{{ $prompt->description }}
                                                </div>
                                            </div>
                                        @endforeach
                                        {{ paginationFooterDiv($groupPrompts) }}
                                    @endisset
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- prompt modal end -->
