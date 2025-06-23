<div class="tt-chat-history flex-md-column d-md-flex">
    <!-- ai chat history search start -->
    <div class="tt-search-box px-2 py-3 border-bottom">
        <div class="input-group">
            <span class="position-absolute top-50 start-0 translate-middle-y ms-2">
                <i data-feather="search"></i>
            </span>
            <input class="form-control form-control-sm rounded-pill searchThread"
                   type="text"
                   placeholder="Search..."
            />
        </div>
    </div>
    <!-- ai chat history search end -->

    <!-- ai chat history start -->
    <div class="tt-history-list-wrap tt-custom-scrollbar">
        <span class="p-3 fs-sm d-block d-none" id="notFoundMessage">No matching conversations found</span>
        <ul class="tt-chat-history-list list-unstyled chatThreadsList">
            @include("backend.admin.chats.chat_threads")
        </ul>
    </div>
    <div class="mt-auto text-center py-3 d-flex justify-content-center">
        <x-form.button type="button"
                       class="tt-custom-link-btn rounded-pill px-3 py-2 btn btn-dark border-0 newConversation">
            {{ localize("New Conversation") }} <i data-feather="plus" class="icon-14 ms-1"></i>
        </x-form.button>
    </div>
    <!-- ai chat history end -->
</div>
