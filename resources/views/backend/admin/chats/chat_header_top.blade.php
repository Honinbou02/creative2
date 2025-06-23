<div
    class="p-3 border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between bg-light-subtle tt-chat-header">
    <div class="col-auto d-flex align-items-center">
        <div class="dropdown">
            <button class="btn border-0 p-0 rounded d-flex align-items-center activeExpert" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <div class="tt-experties d-flex align-items-center me-2">
                    <div class="avatar avatar-md flex-shrink-0">
                        <img class="rounded-circle" src="{{ avatarImage($chatExpert->avatar) }}" alt="avatar" />
                    </div>
                    <div class="ms-2 text-start d-none d-md-block">
                        <h6 class="mb-0 lh-1">{{ $chatExpert->expert_name ?? localize('VisionAI') }}</h6>
                        <span class="text-muted fs-sm">{{ $chatExpert->short_name ?? localize('Image Expert') }}</span>
                    </div>
                </div>

                @if (!in_array(currentRoute(), ['admin.chats.aiPDFChat', 'admin.chats.aiImageChat', 'admin.chats.aiVisionChat']))
                    <span class="material-symbols-rounded fs-20">
                        unfold_more
                    </span>
                @endif
            </button>
            @if (!in_array(currentRoute(), ['admin.chats.aiPDFChat', 'admin.chats.aiImageChat', 'admin.chats.aiVisionChat']))
                <div class="dropdown-menu shadow-lg border-0">

                    @forelse($experts ?? [] as $key=>$expert)
                        <div data-name="{{ $expert->expert_name }}" data-id="{{ $expert->id }}"
                            data-img="{{ avatarImage($expert->avatar) }}" data-short_name="{{ $expert->short_name }}"
                            class="tt-experties d-flex align-items-center px-2 mb-2 cursor-pointer pickExpert">
                            <div class="avatar avatar-md flex-shrink-1">
                                <img class="rounded-circle" loading="lazy" src="{{ avatarImage($expert->avatar) }}"
                                    alt="avatar" />
                            </div>
                            <div class="ms-2 text-start">
                                <h6 class="mb-0 lh-1">{{ $expert->expert_name }}</h6>
                                <span class="text-muted fs-sm">{{ $expert->short_name }}</span>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            @endif
        </div>

    </div>
    <div class="tt-chat-action d-flex align-items-center">
        @if (currentRoute() == 'admin.chats.index' && getSetting('enable_serper') != 0)
            <div class="form-check form-switch d-flex me-2">
                <label for="realTimeData">
                    <input type="checkbox" class="form-check-input me-2 cursor-pointer" id="realTimeData"
                        name="real_time_data">
                    <span class="d-none d-md-flex cursor-pointer">
                        {{ localize('Real-Time Data') }}
                    </span>

                </label>
            </div>
        @endif
        <div class="dropdown tt-tb-dropdown me-2">
            <button type="button" class="btn p-0 fullscreen-toggler" >
                <span class="fullscreen-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Full Screen">
                    <i data-feather="maximize"></i>
                </span>
                <span class="exit-fullscreen-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Exit Full Screen">
                    <i data-feather="minimize"></i>
                </span>
            </button>
        </div>
        <div class="dropdown tt-tb-dropdown me-2">
            <button type="button" class="btn p-0" id="addFrmOffCanvas" data-bs-toggle="offcanvas tooltip"
            data-bs-target="#addSendMailSidebar" title="Send to email"><i data-feather="send"></i></button>
        </div>
        <div class="dropdown tt-tb-dropdown me-2">
            <button type="button" class="btn p-0 copyChat" data-type="full" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy the conversation"><i data-feather="copy"></i></button>
        </div>
        <div class="dropdown tt-tb-dropdown me-2">
            <button type="button" class="btn p-0 shareChat" data-type="full" data-bs-toggle="tooltip" data-bs-placement="top" title="Share the conversation"><i data-feather="share"></i></button>
        </div>
        <div class="dropdown tt-tb-dropdown me-2">
            <button class="btn p-0" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                aria-haspopup="true" aria-expanded="true">
                <i data-feather="download"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow">
                <a class="dropdown-item downloadChatBtn" data-download_type="pdf" href="javascript:void(0);">
                    <i data-feather="file" class="me-2"></i> {{ localize('PDF') }}
                </a>
                <a class="dropdown-item downloadChatBtn"  data-download_type="html" href="javascript:void(0);">
                    <i data-feather="code" class="me-2"></i> {{ localize('HTML') }}
                </a>
                <a class="dropdown-item downloadChatBtn"  data-download_type="word" href="javascript:void(0);">
                    <i data-feather="file-text" class="me-2"></i>{{ localize('MS Word') }}
                </a>
            </div>
        </div>

        <div class="dropdown tt-tb-dropdown me-2">
            <button type="button" class="btn p-0 deleteConversation" data-bs-toggle="modal"
                data-bs-target="#deleteConversation" title="Delete the chat history"><i data-feather="trash"></i></button>
        </div>
        <div class="dropdown tt-tb-dropdown d-md-none">
            <button type="button" class="btn p-0 tt-chat-history-mobile"><i data-feather="plus"
                    class="icon-14"></i></button>
        </div>
    </div>
    <!-- chat history for mobile device start -->
    <div class="tt-chat-history flex-column d-flex border-bottom">
        <!-- ai chat history search start -->
        <div class="tt-search-box px-2 py-3 border-bottom">
            <div class="input-group">
                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"><i
                        data-feather="search"></i></span>
                <input class="form-control form-control-sm rounded-pill" type="text" placeholder="Search...">
            </div>
        </div>
        <!-- ai chat history search end -->

        <!-- ai chat history start -->

        <div class="mt-auto text-center py-3">
            <button class="tt-custom-link-btn rounded-pill px-3 py-2 btn btn-dark border-0">
                {{ localize('New Conversation') }}<i data-feather="plus" class="icon-14 ms-1"></i>
            </button>
        </div>
        <!-- ai chat history end -->
    </div>
    <!-- chat history for mobile device end -->
</div>
<div class="modal fade" id="sendMessageMail" tabindex="-1" aria-labelledby="sendMessageMailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendMessageMailLabel">{{ localize('Send Chat to Email') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label class="form-label">{{ localize('Type Email') }}</label>
                        <input type="email" class="form-control" name="email"
                            placeholder="{{ localize('Type an email') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ localize('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ localize('Send') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteConversation" tabindex="-1" aria-labelledby="deleteConversationLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendMessageMailLabel">{{ localize('Delete Conversation') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.chat.delete-conversation') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="chat_thread_id" id="delete_chat_thread_id">
                    <input type="hidden" name="chat_expert_id" id="delete_chat_expert_id">
                    <h5 class="text-center">{{ localize('Are you sure to delete ?') }}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ localize('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ localize('Confirm') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
