@php
    $articleRoute = route("admin.generator.generateArticles");
    $isWordpressArticle = false;
    if(isset($editArticle)){
        if(isWordpressArticle($editArticle->article_source)){
            $articleRoute = route("admin.articles.update",["article" => $editArticle->id]);
            $isWordpressArticle = true;
        }
    }
@endphp

<div class="content-generator__sidebar">
    <div class="content-generator__sidebar-header pb-0 border-bottom">
        <h6> {{ localize('Generate Article') }} </h6>       
    </div>
    <form id="frmArticleGenerate" action="{{ $articleRoute }}" data-is_edit="{{ isset($editArticle) }}" data-is_wordpress_article="{{ $isWordpressArticle }}" method="POST">
        @csrf
        @if(isset($editArticle) && isWordpressArticle($editArticle->article_source)) @method("PUT") @endif
        <x-form.input type="hidden" name="article_id" id="article_id" value="{{ isset($editArticle) ? $editArticle->id : '' }}" :showDiv="false" />

        <div class="content-generator__sidebar-body tt-custom-scrollbar overflow-y-auto tt-screen-height pt-3">
            <div class="row g-4">
                <div class="col-12">
                    <x-form.label for="contentTopic" class="form-label" isRequired="true"> {{ localize('Topic') }} <small class="text-muted">({{ localize('E.g: SEO tools in 2025') }})</small></x-form.label>
                    <x-form.input type="text" id="contentTopic" name="topic" value="{{ isset($editArticle) ? $editArticle->topic : '' }}" class="form-control form-control-sm"  placeholder="{{ localize('Main idea about your article') }}" required />
                </div>

                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">
                        <x-form.label for="focusKeyword" class="form-label flex-shrink-0 mb-0" isRequired="true">
                            {{ localize('Main Keyword') }} ({{ localize('Max 6 Words:') }}) - <small class="text-muted">{{ localize("E.g: SEO Tools") }}</small>
                        </x-form.label>
                        @if($showGenerateSmallBtn)
                            <x-common.small-btn data-content-purpose="keywords" data-bs-target="#addFormSidebar" label="{{ localize('Generate Keywords') }}"></x-common.small-btn>
                        @endif
                    </div>
                    <x-form.input type="text" id="focusKeyword" name="focus_keyword" value="{{ isset($editArticle) ? $editArticle->focus_keyword : '' }}" class="form-control form-control-sm" placeholder="{{ localize('Keyword for your content quality') }}" required />
                </div>

                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">
                        <x-form.label for="contentKeywords" class="form-label flex-shrink-0 mb-0" isRequired="true">{{ localize('Related Keywords') }}  - <small class="text-muted">{{ localize("NB: Min: 3 Keywords") }}</small></x-form.label>                        
                    </div>
                    <x-form.input name="keywords" type="text" value="{{ isset($editArticle) ? $editArticle->selected_keyword : '' }}" class="form-control form-control-sm" id="contentKeywords" placeholder="{{ localize('Most strategic keyword to anchor your article') }}" required />
                </div>

                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">
                        <x-form.label for="image" class="form-label flex-shrink-0 mb-0" isRequired="true">{{ localize('Title') }} </x-form.label>
                        @if($showGenerateSmallBtn)
                            <x-common.small-btn id="addFrmOffCanvas" data-content-purpose="titles" data-bs-target="#addFormSidebar" label="{{ localize('Generate Title') }}" />
                        @endif
                    </div>
                    <x-form.input type="text" name="title" id="title" value="{{ isset($editArticle) ? $editArticle->selected_title : '' }}" class="form-control form-control-sm" placeholder="{{ localize('Title of your article') }}" required />
                </div>

                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap">
                        <x-form.label for="metaDescription" class="form-label flex-shrink-0 mb-0" isRequired="true">{{ localize('Meta Description') }} </x-form.label>
                        @if($showGenerateSmallBtn)
                            <x-common.small-btn id="addFrmOffCanvas" data-content-purpose="meta_descriptions" data-bs-target="#addFormSidebar" label="{{ localize('Generate Meta') }}" />
                        @endif
                    </div>
                    <x-form.textarea name="meta_description" id="contentMetaDescriptions" class="w-100 form-control" rows="3" placeholder="{{ localize('Meta description of your article') }}" required>
                        {{ isset($editArticle) ? $editArticle->selected_meta_description : '' }}
                    </x-form.textarea>
                </div>

                <div class="col-12 metaDescription-lists" id="metaDescriptionsOverview">
                    <div class="d-block">
                        <h6 class="form-label mb-2">{{ localize("The appearance of your snippet in Google results") }} <span class="cursor-pointer ms-2"> <i data-feather="info" class="icon-14" data-bs-toggle="tooltip" data-bs-placement="left" title="Google considers 70 and 160 as the character limit for the title and description. Descriptions longer than 960px on desktop or 680px on mobile may not be displayed in full length. Title length in pixels. Titles longer than 600px may not be displayed in full length."></i></span></h6>
                        <div class="border-top pt-2">
                            <small class="text-muted">{{ url("/") }} › {{ localize("category") }} › {{ localize("post") }} </small>
                            <h6 class="mb-1 articleTitle">{{ isset($editArticle) ? $editArticle->title : null }}</h6>
                            <p class="mb-1 articleMetaDescription">
                                {{ isset($editArticle) ? $editArticle->selected_meta_description : null }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap  border-bottom pb-1">
                        <x-form.label for="image" class="form-label flex-shrink-0 mb-0" isRequired="true">
                            {{ localize('Outline') }}
                        </x-form.label>

                        @if($showGenerateSmallBtn)
                            <x-common.small-btn id="addFrmOffCanvas" data-content-purpose="outlines" data-bs-target="#addFormSidebar" label="{{ localize('Generate Outline') }}"></x-common.small-btn>
                        @endif
                    </div>
                </div>

                <div class="outline-lists mt-2" id="outlines">
                    @isset($editArticleOutlines)
                        @foreach($editArticleOutlines as $item)
                            <div class="single-outline d-flex align-items-center mb-2 gap-2">
                                <span class="text-muted">H2</span>
                                <input class="form-control form-control-sm" type="text" name="outlines[]" value="{{ $item }}" required="">
                                <button class="btn btn-secondary addOutline btn-icon" type="button"><i data-feather="plus" class="icon-14"></i></button>
                                <button class="btn btn-icon btn-soft-danger delOutline" type="button"><i data-feather="minus" class="icon-14"></i></button>
                            </div>
                        @endforeach 
                    @else
                        <div class="alert alert-secondary">{{ localize('No Outline') }}</div>
                    @endisset
                </div>

                @isset($editArticle)
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap border-bottom pb-2">
                        <x-form.label for="image" class="form-label flex-shrink-0 mb-0">
                            {{ localize('Images') }} - <small class="text-muted">{{ localize("Optional") }}</small>
                        </x-form.label>
                    </div>
                    @include("backend.admin.articles.tab.tab-image")
                </div>
                @endisset
               
                @if ($wpBlogEdit == false)
                    <div class="col-12 mt-1">
                        <div class="d-flex align-items-center gap-3 justify-content-between flex-wrap  border-bottom pb-1">
                            <x-form.label for="core_settings" class="form-label flex-shrink-0 mb-0" isRequired="true">
                                {{ localize("Core Settings") }}
                            </x-form.label>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="text-center">
                            <div class="">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <x-form.label for="language" class="form-label d-block text-start" isRequired="true">
                                            {{ localize('Language') }}
                                        </x-form.label>

                                        <x-form.select class="form-select form-select-transparent form-select-sm" id="language" name="lang">
                                            @foreach (languages() as $item)
                                                <option value = "{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach

                                        </x-form.select>
                                    </div>
                                    <div class="col-md-6">
                                        <x-form.label for="tone" class="form-label d-block text-start" isRequired="true">
                                            {{ localize('Tone') }}
                                        </x-form.label>

                                        <x-form.select class="form-select form-select-transparent form-select-sm" id="tone" name="tone">
                                            @foreach (appStatic()::OPEN_AI_TONES as $key => $name)
                                                @if($key == 'Professional')
                                                    <option value="{{ $key }}" selected>{{ $name }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $name }}</option>
                                                @endif
                                            @endforeach
                                        </x-form.select>
                                    </div>

                                    <div class="col-12">
                                        <x-form.label for="maxArticleLength" class="form-label d-block text-start" isRequired="true">
                                            {{ localize('Article Length') }}
                                        </x-form.label>
                                        <x-form.select class="form-select form-select-transparent form-select-sm" id="maxArticleLength" name="maxArticleLength">                                        
                                            <option value="small">{{ localize('Small (1000 - 2500 words)') }}</option>
                                            <option value="medium">{{ localize('Medium (2500 - 3600 words)') }}</option>
                                            <option value="large">{{ localize('Large (3600 - 5400 words)') }}</option>
                                        </x-form.select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="content-generator__sidebar-footer py-3">
            <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">

                @if(isset($editArticle) )
                    @if(isWordpressArticle($editArticle->article_source))
                        {{-- When Edit Article source is wordpress  --}}
                        <x-form.button class="btn-sm btn-primary rounded-pill generateFinalContent" type="submit">
                            <i data-feather="save" class="icon-12"></i>

                            {{ localize('Save Changes') }}
                        </x-form.button>
                    @else
                        @include("backend.admin.articles.writerap-btn")
                    @endif
                @else
                    @include("backend.admin.articles.writerap-btn")
                @endif
            </div>
        </div>
    </form>

</div>
