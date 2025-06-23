@forelse($details as $project)
    <tr>
        <td class="fs-sm"> {{ $loop->iteration }} </td>
        <td>
            @php
                $image_path = $project->storage_type == 'aws' ? $project->file_path : urlVersion($project->file_path);
            @endphp
            @if($project->file_path)
            <a href="{{ $image_path }}" target="_blank" class="d-flex align-items-center fs-sm">{{ $project->title }}</a>
            @else
            <a href="{{ route('admin.videos.downloadVideo', $project->generated_image_path) }}"  class="d-flex align-items-center fs-sm">{{ $project->title }}</a>
            @endif
        </td>
        <td class="fs-sm">{{ localize(ucwords(str_replace('_', ' ', $project->model_name))) }}</td>
        <td>
            <span class="fs-sm">{{ dateFormat($project->created_at) }}</span>
        </td>
        <td class="text-center"> <span
                class="fs-sm text-capitalize">{{ localize(ucwords(str_replace('_', ' ', $project->content_type))) }}</span>
        </td>
       
        <td class="text-center">
            @if($project->file_path) 
            <a href="{{ $image_path }}" target="_blank">
                <span title="download"><i data-feather="download" class="icon-14"></i></span>
            </a>
            @else
            <a href="{{ route('admin.videos.downloadVideo', $project->generated_image_path) }}">
                <span title="Edit"><i data-feather="loader" class="icon-14">{{localize('Process Video')}}</i></span>
            </a>
            @endif
        </td>
    </tr>
@empty
    <x-common.empty-row colspan=7 />
@endforelse
{{ paginationFooter($details, 7) }}