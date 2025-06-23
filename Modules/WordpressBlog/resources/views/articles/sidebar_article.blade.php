<form action="" method="POST" id="addFrm">
    <div class="offcanvas offcanvas-end" id="addFormSidebar" tabindex="-1">
        @method('POST')
        @csrf
        <x-form.input name="id" id="id" type="hidden" value="" showDiv=0 />
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title" id="generated-title">{{ localize('Generate Article') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>

        <x-common.splitter />
        <div class="offcanvas-body">
            <div class="withoutWordpressRow" id="withoutWordpressRow">
                
                <div class="row g-3">
                    <div class="col-12">
                        <x-form.label for="number_of_results" isRequired="true">
                            {{ localize('Number of Results') }}
                        </x-form.label>

                        <x-form.input type="text" class="form-control form-control-sm" id="number_of_results"
                            value="1" name="number_of_results" placeholder="Ex 5" />

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
                                <div class="row g-3" id="advanced_option">
                                    <div class="col-md-6">


                                        <x-form.label for="language" class="form-label d-block text-start"
                                            isRequired="true">
                                            {{ localize('Language') }}
                                        </x-form.label>

                                        <x-form.select name="language"
                                            class="form-select form-select-transparent form-select--sm" id="language">
                                            @foreach (languages() as $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach

                                        </x-form.select>

                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label d-block text-start">
                                            {{ localize('Tone') }}
                                            <span class="text-primary">*</span>
                                        </label>
                                        <select class="form-select form-select-transparent form-select--sm">
                                            <option selected>{{ localize('Select') }}</option>
                                            @foreach (appStatic()::OPEN_AI_TONES as $key => $name)
                                                <option value="{{ $key }}">{{ $name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="maxArticleLength" class="form-label d-block text-start">
                                            {{ localize('Max Article Length (Words)') }}
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="maxArticleLength"
                                            placeholder="10">
                                    </div>
                                </div>
                                <div class="row g-3" id="advanced_option_image">
                                    @if (getSetting('generate_image_option') == 'dall_e_2')
                                        @include('common.dall-e-2')
                                    @elseif(getSetting('generate_image_option') == 'dall_e_3')
                                        @include('common.dall-e-3')
                                    @elseif(getSetting('generate_image_option') == 'stable_diffusion')
                                        @include('common.stability-ai')
                                    @else
                                        @include('common.dall-e-2')
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-center">
                            <x-form.button type="button" class="btn-sm generateContents">
                                {{ localize('Generate Content') }}
                            </x-form.button>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr class="my-2">
                    </div>
                    <div class="row keywordsRow rowPadding">
                        <div class="col-12">
                           
                            <div class="d-flex align-items-center justify-content-between gap-2 flxe-wrap">
                                <h6 class="mb-0"> {{ localize('Custom Keywords') }} </h6>
                                <label
                                    class="form-label cursor-pointer btn btn-sm btn-secondary rounded-pill fw-medium">
                                    {{localize('Add Keyword')}} <i data-feather="plus" class="icon-14 ms-1"></i>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="p-4 rounded border">
                                <div class="mb-4">
                                    <x-form.label for="yourKeyword">{{ localize('Your Keyword') }}</x-form.label>
                                    <x-form.input :showDiv="false" name="yourKeyword" type="text"
                                        class="form-control form-control-sm" id="yourKeyword"
                                        placeholder="Enter your keyword" />
                                </div>

                                <x-form.button id="addKeyword"
                                    class="btn bttn-sm btn-primary d-inline-flex align-items-center justify-content-center gap-1"
                                    type="button">
                                    <span class="d-inline-block text-white"> {{ localize('Add Custom Keyword') }}
                                    </span>
                                </x-form.button>
                            </div>
                        </div>

                        <div class="col-12 ">
                            <h6>{{ localize('Generated Keywords') }}</h6>
                            <ul class="keyword-list render-keywords">

                                @isset($keywords)
                                    @include('backend.admin.articles.render.render-keywords', [
                                        'keywords' => $keywords,
                                    ])
                                @endisset
                            </ul>
                        </div>
                    </div>

                    <div class="row titlesRow rowPadding">
                        <div class="col-12">
                            <h6>{{ localize('Generated Titles') }}</h6>
                            <ul class="keyword-list render-titles">
                                @isset($titles)
                                    @include('backend.admin.articles.render.render-titles', [
                                        'titles' => $titles,
                                    ])
                                @endisset
                            </ul>
                        </div>
                    </div>

                    <div class="row outlinesRow rowPadding">
                        <div class="col-12">
                            <h6>{{ localize('Outlines') }}</h6>
                            <ul class="p-0 m-0 list-unstyled render-outlines">
                                @isset($outlines)
                                    @include('backend.admin.articles.render.render-outlines', [
                                        'outlines' => $outlines,
                                    ])
                                @endisset
                            </ul>
                        </div>
                    </div>

                    <div class="row imagesRow rowPadding">
                        <div class="render-images">
                            @isset($images)
                                @include('backend.admin.articles.render.render-images', [
                                    'images' => $images,
                                ])
                            @endisset
                        </div>


                    </div>
                    <div class="row publishedToWordpressRow rowPadding">
                        <div class="col-12">


                        </div>
                    </div>
                </div>
            </div>
            @if (isModuleActive('WordpressBlog'))
                <div class="wordpressBlogRow" id="wordpressBlogRow">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="">
                                        <h6>{{ localize('Published Website') }}</h6>
                                    </label>
                                    @isset($websites)
                                        @foreach ($websites as $website)
                                            <li class="p-0 d-flex">
                                                <input class="form-check-input cursor-pointer me-2" name="website"
                                                    value="{{ $website->id }}" type="checkbox"
                                                    id="website{{ $website->id }}" data-name="{{ $website->domain }}">
                                                <label for="website{{ $website->id }}"
                                                    class="cursor-pointer">{{ $website->domain }}</label>
                                            </li>
                                        @endforeach
                                    @endisset

                                </div>
                                <h6>{{ localize('Category') }}</h6>
                                <div class="col-12">
                                    @isset($categories)
                                        @foreach ($categories as $item)
                                            <li class="p-0 d-flex">
                                                <input class="form-check-input cursor-pointer me-2" name="categories[]"
                                                    value="{{ $item->wp_id }}" type="checkbox"
                                                    id="category{{ $item->wp_id }}"
                                                    data-name="{{ $item->category_name }}">
                                                <label for="category{{ $item->wp_id }}"
                                                    class="cursor-pointer">{{ $item->category_name }}</label>
                                            </li>
                                        @endforeach
                                    @endisset


                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <x-form.label for="status" label="{{ localize('Status') }}" isRequired=true />
                                    <x-form.select name="status" id="status">
                                        @foreach (WP_STATUS as $type => $title)
                                            <option value="{{ $type }}">{{ $title }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                                <div class="col-6 mb-3">
                                    <x-form.label for="author" label="{{ localize('Author') }}" isRequired=true />
                                    <x-form.select name="author" id="author">
                                        @isset($authors)
                                            @foreach ($authors as $author)
                                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                                            @endforeach
                                        @endisset

                                    </x-form.select>
                                </div>
                                <div class="col-12 mb-3">
                                    <x-form.label for="tags[]" label="{{ localize('Tags') }}" isRequired=true />
                                    <x-form.select name="tags[]" class="select2" id="wp_tags" multiple>

                                        @isset($tags)
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->wp_id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        @endisset
                                    </x-form.select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</form>
