
@forelse($details as $post)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm tt-avater-info me-1">
                    <img class="rounded rounded-circle" src="{{ mediaImage($post->platform?->icon_media_manager_id) }}" alt="platform">
                </div>
                <div>{{ $post->platform?->name }} </div>
            </div> 
        </td>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm tt-avater-info me-1">
                    <img class="rounded rounded-circle" width="50" src="{{ decodedFieldValue($post->platformAccount->account_details, 'avatar_thumbnail') }}" alt="platform">
                </div>
                <div>{{ $post->platformAccount->account_name }} </div>
            </div> 
        </td>
        <td>{{ $post->created_at ? $post->created_at->diffForHumans() : '-' }}</td> 
        <td>{{ $post->schedule_time ? date('d, M Y, h:i A', strtotime($post->schedule_time)) : '-' }}</td> 
        <td>
            <span class="text-capitalize badge bg-soft-{{appStatic()::POST_STATUS_BADGE_BY_VALUE[$post->post_status]}}">
                {{ strtolower(appStatic()::POST_STATUS_BY_VALUE[$post->post_status]) }}
            </span>
            @if ($post->platform_api_response != null && $post->platform?->slug != appStatic()::PLATFORM_INSTAGRAM) <i data-feather="alert-circle" class="icon-16 cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ json_decode($post->platform_api_response)->response }}"></i>@endif 
        </td>
        <td>
            <span class="text-capitalize badge bg-soft-{{appStatic()::POST_TYPES_BADGE_BY_VALUE[$post->post_type]}}">
                {{ strtolower(appStatic()::POST_TYPES_BY_VALUE[$post->post_type]) }}
            </span>
        </td>
        <td class="text-center"> 
            @if(isCustomerUserGroup() || isRouteExists("admin.socials.posts.destroy"))
                <a class="erase text-danger" data-id="{{ $post->id }}" data-href="{{ route('admin.socials.posts.destroy', $post->id) }}" data-method="DELETE" href="javascript:void(0);">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Delete') }}"><i data-feather="trash" class="icon-14"></i></span>
                </a> 
            @endif
        </td>
    </tr>
@empty
     <x-common.empty-row colspan=8 />
@endforelse
{{ paginationFooter($details, 8) }}