
@forelse($details as $platform)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td> 
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm tt-avater-info me-1">
                    <img class="rounded rounded-circle" width="50" src="{{ mediaImage($platform->icon_media_manager_id) }}" alt="platform">
                </div>
                <div>{{ $platform->name }} </div>
            </div> 
        </td>
        <td class="text-center">
            @include("common.active-status-button",[
                'active' => $platform->is_active,
                'id'     => encrypt($platform->id),
                'model'  => 'platforms',
                'name'   => 'is_active',
            ])
        </td>
        
        <td class="text-center">
            @if(isRouteExists("admin.platforms.configure-form"))
                <a href="javascript::void(0);" class="text-warning editIcon me-1 configurePlatformBtn" data-id="{{ $platform->id }}" data-bs-toggle="offcanvas" data-bs-target="#configurePlatformFormSidebar">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Configure') }}"><i data-feather="settings" class="icon-14"></i></span>
                </a>
            @endif
            @if(isRouteExists("admin.platforms.edit"))
                <a href="javascript::void(0);" class="editIcon me-1 addPlatformBtn" data-id="{{ $platform->id }}" data-bs-toggle="offcanvas" data-bs-target="#addPlatformFormSidebar">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Edit') }}"><i data-feather="edit" class="icon-14"></i></span>
                </a>
            @endif
        </td>
    </tr>
@empty
     <x-common.empty-row colspan=4 />
     {{-- TODO::SHOHAN - callspan --}}
@endforelse
{{ paginationFooter($details, 9) }}