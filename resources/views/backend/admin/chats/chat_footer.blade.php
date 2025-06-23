<div class="mt-auto text-center border-top d-flex justify-content-between align-items-end">
    <form method="POST" action="{{ route('admin.chats.conversation') }}" enctype="multipart/form-data"
        class="p-3 d-block w-100" id="{{ $content_purpose == appStatic()::PURPOSE_AI_IMAGE ? 'chat_form' : 'chat_form' }}">
        @csrf
        <x-form.input type="hidden" name="chat_thread_id" value="{{ @$chat_thread_id }}" :showDiv="false"
            class="chatThreadId" />

        <x-form.input type="hidden" name="content_purpose" value="{{ $content_purpose }}" :showDiv="false"
            class="" />

        <x-form.input :showDiv="false" type="hidden" name="chat_expert_id" value="{{ @$chat_expert_id }}"
            class="chatExpertId" />

        <div class="form-input mb-3">
            <x-form.textarea class="form-control" id="textarea-input" name="message" cols="5" rows="2"
                placeholder="Type Your message here...">{{ old('message') }}</x-form.textarea>
        </div>

        {{-- Dynamically selected image load here . --}}
        <div class="tt-product-thumb tt-vision-thumb mt-2 text-start"> </div>

        <div class="row g-2">
            <div class="col-auto d-flex align-items-center flex-grow-1">
                @if (currentRoute() === 'admin.chats.aiVisionChat' || currentRoute() === 'admin.chats.aiPDFChat')
                    <div class="dropdown tt-tb-dropdown dropup me-2">

                        <button type="button" class="btn btn-secondary btn-icon btn-sm rounded-circle flex-shrink-0"
                            role="button" data-bs-toggle="dropdown" aria-expanded="true">
                            <i data-feather="paperclip" class="icon-14"></i>
                        </button>
                       
                        <div class="dropdown-menu shadow-lg">

                            @if (currentRoute() === 'admin.chats.aiPDFChat')
                                <label for="selectPDF" class="dropdown-item ">
                                    <i data-feather="file" class="me-2 icon-14"></i> {{ localize('Upload PDF') }}

                                    <input type="file" class="d-none" id="selectPDF" accept=".pdf" name="pdfFile" />
                                </label>
                            @endif

                            @if (currentRoute() === 'admin.chats.aiVisionChat')
                                <label for="selectImages" class="dropdown-item ">
                                    <i data-feather="image" class="me-2 icon-14"></i> {{ localize('Upload Image') }}

                                    <input type="file" class="d-none" id="selectImages"
                                        {{ isOpenAiEngine() ? 'multiple' : '' }} name="images[]" accept="image/*" />
                                </label>
                            @endif

                        </div>
                    </div>
                @endif
                
                <button type="button" id="recordButton"
                    class="btn btn-secondary btn-icon btn-sm rounded-circle flex-shrink-0 me-2">
                    <i data-feather="mic" class="icon-14"></i>
                </button>

                <button class="btn btn-sm btn-icon rounded-circle bg-secondary d-none me-2" type="button"
                    id="stopButton"><i data-feather="pause"></i></button> 
                @isset($groupPrompts)
                    
                <button type="button" class="btn btn-secondary btn-icon btn-sm rounded-circle flex-shrink-0 me-2" data-bs-toggle="modal" data-bs-target="#promptModal">
                    <i data-feather="file-text" class="icon-14"></i>
                </button>
                @endisset
            </div>
            <div class="col-auto d-flex align-items-center">
                @if (currentRoute() !== 'admin.chats.aiImageChat')
                    <x-form.button class="btn btn-sm btn-secondary rounded-pill msgStopBtn" type="reset" disabled="disabled">
                        {{ __('Stop') }}
                        <i data-feather="stop-circle" class="icon-14"></i>
                    </x-form.button>
                @endif
                <x-form.button class="btn btn-sm btn-primary rounded-pill ms-2 tt-send-btn msgSendBtn" type="submit">
                    {{ localize('Send') }}
                    <i data-feather="send" class="icon-14"></i>
                </x-form.button>
            </div>
        </div>
    </form>
</div>
