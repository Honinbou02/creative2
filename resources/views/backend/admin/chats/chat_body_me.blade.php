<div class="d-flex justify-content-end mt-4 tt-message-wrap tt-message-me">
    <div class="d-flex flex-column align-items-end">
        <div class="d-flex align-items-start">
            <div class="me-3 p-3 rounded-3 text-end mw-450 tt-message-text">
                {{ $message->title ?? '' }}

                @if(!empty($message->file_path))
                    <ul class="list-unstyled d-flex justify-content-end align-items-center gap-2 mb-0 mt-3">
                        @if(isset($rawFile))
                            <li>
                                <div class="avatar avatar-xl">
                                    <a href="{{ asset($message->file_path) }}" target="_blank">
                                        <img class="rounded chatBodyPdfImg"
                                             loading="lazy"
                                             src="{{ asset('assets/img/pdf-icon.svg') }}"
                                             alt="Image Alt"
                                        />
                                    </a>
                                </div>
                            </li>
                        @else
                            @php
                                $files = json_decode($message->file_path, true) ?? [];
                            @endphp
                            @forelse($files as $key=>$file)
                                <li>
                                    <div class="avatar avatar-xl">
                                        <img class="rounded"
                                             loading="lazy"
                                             src="{{ urlVersion($file[0]) }}"
                                             alt="Image Alt" />
                                    </div>
                                </li>
                            @empty

                            @endforelse
                        @endif

                    </ul>

                @endif
            </div>

            <div class="avatar avatar-md flex-shrink-0">
                <img class="rounded-circle"
                     src="{{ avatarImage(user()->avatar) }}"
                     alt=" avatar"
                     loading="lazy"
                />
            </div>
        </div>
    </div>
</div>
