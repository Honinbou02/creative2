@forelse($text_to_speeches as $speech)
<tr>
    <td class="text-center">{{$loop->iteration}}</td>
    <td>
        <p class="fs-sm mb-0">{{$speech->title}}</p>
    </td>
    <td>
        <span class="fs-sm">{{$speech->created_at}}</span>
    </td>
    <td>
        <span class="fs-sm">{{$speech->type}}</span>
    </td>

    <td class="text-end">
        <div class="form-check form-switch">
           
        @if ($speech->storage_type == 'aws')
            <audio controls class="h-26">
                <source src="{{ $speech->file_path }}" type="audio/ogg">
            </audio>
        @else
            <audio controls class="h-26">
                <source src="{{ urlVersion($speech->file_path) }}" type="audio/ogg">
            </audio>
        @endif
        </div>
    </td>
    <td class="text-center">
       
        <x-form.button data-id="{{ $speech->id }}"
                       data-href="{{ route('admin.text-to-speeches.destroy', $speech->id) }}"
                       data-method="DELETE"
                       class="erase btn-sm p-0 bg-transparent border-0"
                       type="button">
            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Delete TextToSpeech {{$speech->type}}"><i data-feather="trash-2" class="icon-14 text-danger"></i></span>
        </x-form.button>
    </td>
</tr>


@empty

<x-common.empty-row colspan=6 tdClass="py-5" />
@endforelse
{{ paginationFooterDiv($text_to_speeches) }}
