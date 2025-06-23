@forelse($videos as $key=>$video)
    <div class="col-lg-3 col-md-6">
        <div class="card flex-column h-100">
            <div class="card-body">
                <div class="video-container">

                    @if(!empty($video->generated_video_url))
                        <video controls>
                            <source src="{{ $video->generated_video_url }}" type="video/mp4">
                            {{ localize("Your browser does not support the video tag.") }}
                        </video>
                    @else
                        <img src="{{ defaultAvatar() }}"
                             data-avatar_id="{{ $video->avatar_id }}"
                             alt="{{ $video->title }}"
                             class="img-fluid loadAvatars videoImg{{ $video->id }}"
                        />
                    @endif
                </div>

                <div class="mt-2">
                    <h3 class="h6">{{ $video->title }}</h3>
                    <p><strong>{{ localize("Script") }}</strong> : {{ $video->video_script }}</p>
                    <p><strong>{{ localize("Status") }}</strong> : <span class="videoStatusCls{{ $video->id }} badge bg-soft-success">{{ $video->generated_video_status }} </span> </p>
                </div>
                <div class="videoBtnArea{{ $video->id }}">
                    @if($video->generated_video_url)
                        <a href="{{ $video->generated_video_url }}"
                           download=""
                           class="btn btn-primary btn-sm ">
                            <i data-feather="download"></i> Download Video
                        </a>
                    @else
                        <button
                                type="button"
                                data-id="{{ $video->id }}"
                                data-video_id="{{ $video->video_id }}"
                                class="btn btn-primary btn-sm checkVideoStatus">
                            {{ localize("Check Status") }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@empty

@endforelse