<div class="d-flex justify-content-start mt-4 tt-message-wrap">
    <div class="d-flex flex-column align-items-start">
        <div class="d-flex align-items-start">
            <div class="avatar avatar-md flex-shrink-0">
                <img class="rounded-circle" loading="lazy" src="{{ asset('assets/img/avatar/1.jpg') }}" alt="avatar" />
            </div>
            <div class="ms-3 p-3 rounded-3 text-start mw-650 tt-message-text msg-wrapper aiResponseBox">
                @if ($message->type == appStatic()::PURPOSE_AI_IMAGE)
                    <a href="#imageView" class="imgViewModal">
                        <img class="rounded" src="{{ asset($message->response) }}" width="200" height="200"
                            alt="avatar" />
                    </a>
                    <div class="tt-overly-icon pt-3 d-flex justify-content-between">
                        <a href="#imageView" data-title="{{ $message->prompt }}"
                            data-image-url="{{ urlVersion($message->file_path) }}"
                            class="overly-btn overly-view imgViewModal" data-bs-toggle="modal"
                            data-bs-target="#imageView">
                            <span><i data-feather="eye" class="icon-14"></i></span>
                        </a>
                        <a href="{{ urlVersion($message->file_path) }}" download=""
                            class="overly-btn overly-download">
                            <span><i data-feather="download" class="icon-14"></i></span>
                        </a>

                    </div>
                @else
                    {!! convertToHtml($message->response) !!}
                    <button type="button" class="border-0 btn btn-icon btn-soft-primary rounded-circle txt-copy-btn d-none shadow-sm copyChat" data-type="single">
                        <span data-feather="copy"></span>
                    </button>
                @endif
                
            </div>
        </div>
    </div>
</div>

