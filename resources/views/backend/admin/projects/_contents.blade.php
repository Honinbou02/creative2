
@forelse($details as $project)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <a href="{{route('admin.generated-content.show', $project->id)}}" class="d-flex align-items-center">
                <div class="ms-1">
                    {{$project->title}}
                </div>
            </a>
        </td>
        <td>{{ $project->model_name }}</td>
        <td>{{ dateFormat($project->created_at) }}</td>
        <td class="text-center">{{ $project->content_type}} </td>
        <td class="text-center">{{ $project->total_words}}</td>
        <td class="text-center">
            @if(isRouteExists("admin.generated-content.show"))
                <a href="{{route('admin.generated-content.show', $project->id)}}" target="_blank"
                   class="eyeIcon">
                    <span title="View"><i data-feather="eye" class="icon-14"></i></span>
                </a>
            @endif

            
        </td>
    </tr>
@empty
     <x-common.empty-row colspan=9 />
@endforelse
{{ paginationFooter($details, 9) }}