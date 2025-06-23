<div class="content-generator__sidebar">
    <div class="content-generator__sidebar-header">
        <h5> {{ localize('Generate Article') }} </h5>       
    </div>
    <form id="frmArticleGenerate" action="{{ route('admin.generator.generateArticles') }}" method="POST">
        @csrf
        <div class="content-generator__sidebar-body">
            <div class="row g-3">
                <div class="col-12">
                    <x-form.label for="contentTopic" class="form-label" isRequired="true"> {{ localize('Topic') }}
                    </x-form.label>
                    <x-form.input type="text" class="form-control form-control-sm" id="contentTopic" name="topic"
                        value="{{ isset($editArticle) ? $editArticle->topic : '' }}"
                        placeholder="{{ localize('What type of article do you want to generate?') }}" />

                    {{-- Hidden Article ID --}}
                    <x-form.input type="hidden" name="article_id" id="article_id"
                        value="{{ isset($editArticle) ? $editArticle->id : '' }}" :showDiv="false" />
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">
                        <x-form.label for="contentKeywords" class="form-label flex-shrink-0 mb-0" isRequired="true">
                            {{ localize('Keywords') }}
                        </x-form.label>

                        <x-common.small-btn id="addFrmOffCanvas" data-content-purpose="keywords" data-bs-target="#addFormSidebar"></x-common.small-btn>
                        
                    </div>

                    <x-form.input name="keywords" type="text"
                        value="{{ isset($editArticle) ? $editArticle->selected_keyword : '' }}"
                        class="form-control form-control-sm" id="contentKeywords"
                        placeholder="{{ localize('What type of article do you want to generate?') }}" />
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">
                        <x-form.label for="image" class="form-label flex-shrink-0 mb-0" isRequired="true">
                            {{ localize('Title') }} </x-form.label>

                        <x-common.small-btn id="addFrmOffCanvas" data-content-purpose="titles" data-bs-target="#addFormSidebar"></x-common.small-btn>                        
                    </div>

                    <x-form.input name="title" type="text" class="form-control form-control-sm" id="title"
                        value="{{ isset($editArticle) ? $editArticle->selected_title : '' }}"
                        placeholder="{{ localize('What type of article do you want to generate?') }}" />
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">

                        <x-form.label for="image" class="form-label flex-shrink-0 mb-0" isRequired="true">
                            {{ localize('Outline') }}
                        </x-form.label>

                        <x-common.small-btn id="addFrmOffCanvas" data-content-purpose="outlines" data-bs-target="#addFormSidebar"></x-common.small-btn>
                    </div>

                </div>

                <div class="outline-lists" id="outlines">
                    @isset($editArticleOutlines)
                        @foreach ($editArticleOutlines as $item)
                            <div class="single-outline d-flex align-items-center mb-2 gap-2">
                                <span>#</span>
                                <input class="form-control form-control-sm" type="text" name="outlines[]" value="{{ $item }}"
                                    required="">
                                <button class="btn btn-secondary addOutline btn-icon" type="button"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-plus">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg></button>
                                <button class="btn btn-icon btn-soft-danger delOutline" type="button"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg></button>
                            </div>
                        @endforeach

                    @endisset
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">
                        <x-form.label for="image" class="form-label flex-shrink-0 mb-0">
                            {{ localize('Image') }} </x-form.label>

                        <x-common.small-btn id="addFrmOffCanvas" data-content-purpose="image" id="image" data-bs-target="#addFormSidebar"></x-common.small-btn>
                    </div>
                    <div class="input-group input--group input--group-sm flex-shrink-0">
                        <span class="input-group-text lh-1">
                            <span class="material-symbols-rounded">
                                info
                            </span>
                        </span>
                        <input type="text" class="form-control form-control-sm" name="image_prompt" id = "image_prompt"
                            placeholder="{{ localize('Ex: writerap Image') }}">
                    </div>
                </div>
               
                <div class="col-12">
                    <div class="text-center">
                        
                        <div class="d-flex align-items-center tt-advance-options cursor-pointer mt-3 mb-2">
                            <x-form.label
                                    class="form-label cursor-pointer btn btn-sm btn-secondary rounded-pill fw-medium"
                                    for="tt-advance-options">
                                    <i class="las la-plus"></i>
                                    {{ localize("Advance Options") }}
                            </x-form.label>
                        </div>
                        <div class="toggle-next-element__is tt-advance-options-content">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <x-form.label isRequired="true" for="language"
                                        class="form-label d-block text-start">
                                        {{ localize('Language') }}
                                    </x-form.label>

                                    <x-form.select class="form-select form-select-transparent form-select-sm"
                                        id="language" name="lang">
                                        @foreach (languages() as $item)
                                            <option value = "{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach

                                    </x-form.select>
                                </div>
                                <div class="col-md-6">
                                    <x-form.label isRequired="true" for="tone"
                                        class="form-label d-block text-start">
                                        {{ localize('Tone') }}
                                    </x-form.label>

                                    <x-form.select class="form-select form-select-transparent form-select-sm"
                                        id="tone" name="tone">
                                        @foreach (appStatic()::OPEN_AI_TONES as $key => $name)
                                            <option value = "{{ $key }}">{{ $name }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>

                                <div class="col-12">
                                    <x-form.label for="maxArticleLength" class="form-label d-block text-start">
                                        {{ localize('Max Article Length (Words)') }}
                                    </x-form.label>

                                    <x-form.input type="text" class="form-control form-control-sm"
                                        id="maxArticleLength" placeholder="10" name="max_article_length" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isModuleActive('WordpressBlog') && wpCredential())
                    @if ((isCustomerUserGroup() && (allowPlanFeature("allow_wordpress"))) || (!isCustomerUserGroup()))
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">

                                <x-form.label for="image" class="form-label flex-shrink-0 mb-0" isRequired="true">
                                    {{ localize('Publish to Wordpress') }}
                                </x-form.label>
                                
                                <x-common.small-btn id="addFrmOffCanvas" data-content-purpose="publish_to_wordpress" data-bs-target="#addFormSidebar" label="Setup"></x-common.small-btn>
                            </div>

                        </div>
                    @endif
                @endif
            </div>
        </div>
        <div class="content-generator__sidebar-footer py-3">
            <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">

                <x-form.button class="btn-sm btn-primary rounded-pill generateFinalContent" type="submit">
                    {{ localize('Generate Article') }}
                    <i data-feather="rotate-cw" class="icon-12"></i>
                </x-form.button>
                <x-form.button class="btn-sm btn-secondary rounded-pill StopGenerate" disabled>
                    {{ localize('Stop Generation') }}
                    <i data-feather="stop-circle" class="icon-14"></i>
                </x-form.button>
            </div>
        </div>
    </form>

</div>
