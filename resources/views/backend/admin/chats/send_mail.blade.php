<form action="{{ route('admin.chat.sendInEmail') }}" method="POST" id="addSendMailForm">
    <div class="offcanvas offcanvas-end" id="addSendMailSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">{{ localize('Send Chat to Email') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body">
            <x-common.message class="mb-3" />
            <input type="hidden" name="chat_thread_id" id="email_chat_thread_id">
            <input type="hidden" name="chat_expert_id" id="email_chat_expert_id">
            <input type="hidden" name="article_id" id="email_article_id">
            <div class="mb-3">
                <x-form.label for="email" label="{{ localize('Email') }}" isRequired=true />
                <x-form.input name="email" id="email" required type="text" placeholder="{{ localize('Email') }}"
                    value="" showDiv=false />
            </div>
            
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3">
                <x-form.button id="frmActionBtn">{{ localize('Send') }}</x-form.button>
                <x-form.button color="secondary" type="reset">{{ localize('Reset') }}</x-form.button>
            </div>
        </div>
    </div>
</form>
