
@forelse($details as $platformAccount)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm tt-avater-info me-1">
                    <img class="rounded rounded-circle" width="50" src="{{ decodedFieldValue($platformAccount->account_details, 'avatar_thumbnail') }}" alt="platform">
                </div>
                <div>{{ $platformAccount->account_name }} </div>
            </div> 
        </td>
        <td>{{ appStatic()::ACCOUNT_TYPE_BY_VALUE[$platformAccount->account_type] }}</td>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm tt-avater-info me-1">
                    <img class="rounded rounded-circle" width="50" src="{{ mediaImage($platformAccount->platform?->icon_media_manager_id) }}" alt="platform">
                </div>
                <div>{{ $platformAccount->platform?->name }} </div>
            </div> 
        </td>
        <td class="text-center"> <span class="badge bg-soft-{{$platformAccount->is_connected ? 'success' : 'danger'}}">{{ localize(appStatic()::IS_CONNECTED[$platformAccount->is_connected]) }}</span></td>
        <td class="text-center">
            {{-- todo::permission --}}
            <a href="#"
            {{-- <a href="{{route('admin.generated-content.show', $platformAccount->id)}}" target="_blank" --}}
                class="eyeIcon me-1">
                <span title="View"><i data-feather="eye" class="icon-14"></i></span>
            </a> 
            <a class="erase text-danger" data-id="{{ $platformAccount->id }}" data-href="{{ route('admin.accounts.destroy', $platformAccount->id) }}" data-method="DELETE" href="javascript:void(0);">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ localize('Delete') }}"><i data-feather="trash" class="icon-14"></i></span>
            </a> 
        </td>
    </tr>
@empty
     <x-common.empty-row colspan=6 />
@endforelse
{{ paginationFooter($details, 9) }}