@forelse($list ?? [] as $key => $row)
        <div class="col-lg-3 col-md-6">
            <div class="tt-single-expert  p-3 rounded-3">
                <a href="{{route('admin.chats.index', ['chat_expert_id'=>$row->id])}}" class="d-flex align-content-center">
                    <div class="avatar avatar-md">
                        @if ($row->avatar)
                            <img class="rounded-circle" src="{{ avatarImage($row->avatar) }}" alt="{{ $row->expert_name }}" />
                        @else
                            <img class="rounded-circle" src="{{ asset('assets/img/avatar/4.jpg') }}" alt="{{ $row->expert_name }}" />
                        @endif
                    </div>
                    <div class="tt-expert-info ms-2">
                        <h6 class="mb-0">{{ $row->expert_name }}</h6>
                        <p class="text-muted mb-0 small">{{ $row->role }}</p>
                    </div>
                </a>
                @if (!isCustomerUserGroup())
                    <div class="tt-expert-chat d-flex align-items-center gap-2 position-absolute">
                        @include("common.active-status-button",[
                            'active' => $row->is_active,
                            'id'     => encrypt($row->id),
                            'model'  => 'chat_expert',
                            'name'   => 'is_active',
                        ])
                        <a class="link d-inline-block cursor-pointer editIcon" data-id={{ $row->id }} data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Edit Expert Information') }}">
                            <i data-feather="edit-3" class="icon-16"></i>
                        </a>
                    </div> 
                @endif
            </div>
        </div>
@empty
    <x-common.empty-div />
@endforelse

{{ paginationFooterDiv($list) }}

