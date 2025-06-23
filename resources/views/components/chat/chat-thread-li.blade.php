@props([
    'chat_thread_id' => null,
    'totalWords' => 0,
    'id',
    'title',
    'created_at',
    'active' => false,
])
<li data-ct="{{ isset($chat_thread_id) ? $chat_thread_id : null }}" id="{{$id}}" data-chat_thread_id="{{ $id }}"
    class="d-flex chatThreadLi align-items-center justify-content-between  {{ $active ? 'active' : '' }}">
    <a href="javascript:void(0);" class="" data-chat_thread_id="{{ $id }}">
        <span>
            <p class="mb-0 tt_update_text" id="tt_update_text_{{$id}}" data-id={{ $id }} data-name="chat-title-{{ $id }}">
                {{ $title }}</p>
            <small class="text-muted">{{ $created_at }} </small>
        </span>
    </a>
    <div class="dropdown tt-tb-dropdown">
        <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i data-feather="more-vertical" class="ms-1 fs-sm"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end shadow">
            
            <a class="dropdown-item tt_editable">
                <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
            </a>
         
            <a href="#" data-id="{{ $id }}"
                data-href="{{ route('admin.chat-thread.destroy', $id) }}"
                data-method="DELETE"
                class="deleteChatThread dropdown-item"
                type="button">
                <span title="" class="text-danger ms-1"><i data-feather="trash-2" class="icon-14 me-2"></i>{{ localize('Delete') }}</span>
            </a>
            
        </div>
    </div>
</li>
