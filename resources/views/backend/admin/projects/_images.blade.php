@forelse($details as $project)
    <tr>
        <td class="fs-sm"> {{ $loop->iteration }} </td>
        <td>
            @php
                $image_path = $project->storage_type == 'aws' ? $project->file_path : urlVersion($project->file_path);
            @endphp
            <a href="{{ $image_path }}" target="_blank" class="d-flex align-items-center fs-sm">{{ $project->title }}</a>

        </td>
        <td class="fs-sm">{{ localize(ucwords(str_replace('_', ' ', $project->model_name))) }}</td>
        <td>
            <span class="fs-sm">{{ dateFormat($project->created_at) }}</span>
        </td>
        <td class="text-center"> <span
                class="fs-sm text-capitalize">{{ localize(ucwords(str_replace('_', ' ', $project->content_type))) }}</span>
        </td>
        <td class="text-center fs-sm">{{ $project->generated_image_resolution }}</td>
        <td class="text-center">
            <a href="{{ $image_path }}" target="_blank">
                <span title="Edit"><i data-feather="eye" class="icon-14"></i></span>
            </a>
        </td>
    </tr>
@empty
    <x-common.empty-row colspan=7 />
@endforelse
{{ paginationFooter($details, 7) }}
