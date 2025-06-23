<form action="" method="POST" id="addFrm">
    <div class="offcanvas offcanvas-end" id="keywordGenerationSidebar" tabindex="-1">
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
                        <div class="row align-items-center g-3">
                            <div class="col-auto flex-grow-1">
                                <x-form.label for="number_of_main_keywords" isRequired="true">{{ localize('Number of Focus/Main Keywords') }}</x-form.label>
                                <x-form.input type="text" class="form-control form-control-sm" id="number_of_main_keywords" value="3" name="number_of_main_keywords" placeholder="5" />
                                <small class="text-muted">{{ localize('Minimum 1 word') }}</small>
                            </div>
                            <div class="col-auto flex-grow-1">
                                <x-form.label for="number_of_keywords" isRequired="true">{{ localize('Number of Keywords') }}</x-form.label>
                                <x-form.input type="text" class="form-control form-control-sm" id="number_of_keywords" value="3" name="number_of_keywords" placeholder="5" />
                                <small class="text-muted">{{ localize('Minimum 3 words') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3" id="advanced_option">
                        <div class="col-md-6">
                            <x-form.label for="language" class="form-label d-block text-start" isRequired="true">{{ localize('Language') }}</x-form.label>
                            <x-form.select name="language" class="form-select form-select-transparent form-select--sm" id="language">
                                @foreach (languages() as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                        <div class="col-md-6">
                            <x-form.label for="Tone" class="form-label d-block text-start" isRequired="true">{{ localize('Tone') }}</x-form.label>
                            <x-form.select name="Tone" class="form-select form-select-transparent form-select--sm" id="tone">                            
                                <option selected>{{ localize('Select') }}</option>
                                @foreach (appStatic()::OPEN_AI_TONES as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                        
                        @if((isCustomerUserGroup() && allowPlanFeature("allow_seo_keyword")) || (isAdmin() || isAdminTeam()))
                            <div class="col-md-6 keywordSeoCheckbox">
                                <x-form.label for="checkSeoForKeyword" class="form-label d-block text-start d-flex align-items-center gap-2 cursor-pointer">
                                    <x-form.input type="checkbox" id="checkSeoForKeyword" name="checkSeoForKeyword" value="1" :showDiv="false" />
                                    {{ localize('Check SEO Analysis for keywords') }}
                                </x-form.label>
                            </div>
                        @endif
                    </div>

                    <div class="col-12 broder-bottom pb-3">
                        <x-form.button type="button" class="btn-sm generateContents">{{ localize('Generate Keywords') }}</x-form.button>
                    </div>
                    <div class="row keywordsRow rowPadding">
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
                </div>
            </div>
        </div>

    </div>
</form>
