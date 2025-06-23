@forelse($brandVoices as $key => $brandVoice)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $brandVoice->brand_name }}</td>
    <td>
        <a href="{{ $brandVoice->brand_website }}" target="_blank">
            {{ $brandVoice->brand_website }}
        </a>
    </td>
    <td>
        @php
            $industries = json_decode($brandVoice->industry) ;

            $industryNames = [];
            foreach($industries as $industry){
                $industryNames[] = $industry;
            }
            echo implode(", ", $industryNames);
        @endphp
    </td>
    <td title="{{ $brandVoice->brand_description }}">{!! Str::limit($brandVoice->brand_description, 60 ) !!}</td>
    <td>{{ $brandVoice->products->count() }}</td>
    <td>
        @if(isRouteExists("admin.brand-voices.edit") || isCreatedByMe($brandVoice, userID()))
            <a
                href="#"
                data-update-url="{{ route('admin.brand-voices.update', $brandVoice->id) }}"
                data-url="{{ route('admin.brand-voices.edit',$brandVoice->id) }}"
                data-id="{{ $brandVoice->id }}"
                data-bs-toggle="offcanvas"
                data-bs-target="#addBrandVoiceFromSidebar"
                class="editIcon editBrandVoice">
                    <i data-feather="edit" class="icon-14" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Brand Voice"></i>
            </a>
        @endif
        @if(isRouteExists("admin.brand-voices.destroy") || isCreatedByMe($brandVoice, userID()))
            <a href="#" data-id="{{ $brandVoice->id }}"
                data-href="{{ route('admin.brand-voices.destroy', $brandVoice->id) }}"
                data-method="DELETE"
                class="erase btn-sm p-0 bg-transparent border-0"
                type="button">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{localize('Delete Category')}}" class="text-danger ms-1"><i data-feather="trash-2" class="icon-14"></i></span>
            </a>
        @endif
    </td>
</tr>
@empty
    <x-common.empty-row colspan=7 />
@endforelse
{{ paginationFooter($brandVoices, 7) }}