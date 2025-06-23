<div class="row p-3">
    @if(isOpenAiEngine(templatesEngine()))
        <x-common.open-ai-error/>
    @endif
    <div class="col-xl-12">
        <div class="card border-0">
            <div class="card content-generator flex-md-row">
                <div class="content-generator__sidebar">
                    <form action="{{ route('admin.socials.posts.ai-assistant-save-contents') }}" data-route="{{ route('admin.socials.posts.ai-assistant.stream') }}" method="POST" id="aiAssistantContentGenerator">
                        @csrf
                        <input class="form-control border-0 px-2 form-control-sm" type="hidden" id="generated_id" name="generated_id">

                        <x-form.input type="hidden"
                                      name="content_purpose"
                                      value="{{appStatic()::PURPOSE_AI_ASSISTANT_CONTENT}}"/> 
                        <div class="content-generator__sidebar-body overflow-y-auto tt-custom-scrollbar tt-screen-height">
                            <div class="row g-3">
                                <div class="col-12">

                                    <x-form.label for="language"
                                                  label="{{ localize('Select input and output language') }}"
                                                  isRequired=true />
                                    <x-form.select name="language" id="language">
                                        @foreach (languages() as $language)
                                            <option value="{{$language->name}}">{{$language->name}}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                                 
                                {{-- form here --}} 
                                <x-form.textarea class="form-control" id="prompt-input" name="prompt" rows="4" placeholder="Type what you want to generate..."></x-form.textarea>

                                @if(templatesEngine() ==  appStatic()::ENGINE_OPEN_AI)
                                <div class="col-12">
                                    <div class="bg-secondary bg-opacity-50 p-lg-4 p-2 rounded-3">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <x-form.label for="max_tokens"
                                                                label="{{ localize('Max Content Length') }}" />
                                                <x-form.input type="text" name="max_tokens"
                                                                class="form-control form-control-sm"
                                                                id="maxArticleLength" placeholder="10" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-form.label for="tone"
                                                                label="{{ localize('Choose a Tone') }}" />
                                                <x-form.select name="tone"
                                                                class="form-select form-select-transparent form-select--sm"
                                                                id="tone">
                                                    @foreach (appStatic()::OPEN_AI_TONE as $key => $item)
                                                        <option value="{{ $key }}">
                                                            {{ localize($item) }}</option>
                                                    @endforeach

                                                </x-form.select>
                                            </div>
                                            <div class="col-md-6">
                                                <x-form.label for="creativity"
                                                                label="{{ localize('Creativity') }}" isRequired=true />
                                                <x-form.select name="creativity"
                                                                class="form-select form-select-transparent form-select--sm"
                                                                id="creativity">

                                                    @foreach (appStatic()::OPEN_AI_CREATIVITY as $key => $name)
                                                        <option value="{{ (int) $key }}">
                                                            {{ localize($name) }}</option>
                                                    @endforeach

                                                </x-form.select>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="content-generator__sidebar-footer py-3">
                            <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
                                <x-form.button class="btn btn-sm btn-primary rounded-pill" type="submit" id="generateContent">
                                    <i data-feather="rotate-cw" class="icon-12"></i>
                                    {{ localize('Generate Content') }}
                                </x-form.button>
                                <x-form.button class="btn btn-sm btn-secondary rounded-pill StopGenerate" disabled id="stopGenerateContent">
                                    <i data-feather="stop-circle" class="icon-14"></i>
                                    {{ localize('Stop Generation') }}
                                </x-form.button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="content-generator__body">
                    <div class="content-generator__body-header">
                        <div class="p-3 py-2 border-bottom bg-light-subtle">
                            <div class="fs-24 fw-bold">{{localize('Your generated content will appear here')}}..</div>
                        </div>
                    </div>
                    <div class="content-generator__body-content p-3">
                        <div id="contentGenerator" class="contentGenerator"></div>
                    </div>
                    <div class="d-flex justify-content-end mt-4 mb-3 px-3">
                        <x-form.button class="px-3 py-1 rounded-pill saveChange"  id="saveChangeButton" disabled color="outline-primary">
                            <i data-feather="mouse-pointer" class="icon-14"></i>
                            {{ localize('Make Me a Post') }}
                        </x-form.button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>