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

                    {{-- Keywords Generate Section --}}
                    <div class="col-12 keywordsNumberOfResultDiv">
                        <div class="row align-items-center g-3">
                            <div class="col-auto flex-grow-1">
                                <x-form.label for="number_of_main_keywords" isRequired="true">{{ localize('Number of Focus/Main Keywords') }}</x-form.label>
                                <x-form.input type="text" class="form-control form-control-sm" id="number_of_main_keywords" value="3" name="number_of_main_keywords" placeholder="3" />
                                <small class="text-muted">{{ localize('Minimum 1 word') }}</small>
                            </div>
                            <div class="col-auto flex-grow-1">
                                <x-form.label for="number_of_keywords" isRequired="true">{{ localize('Related Keywords') }}</x-form.label>
                                <x-form.input type="text"
                                              class="form-control form-control-sm"
                                              id="number_of_keywords"
                                              value="5"
                                              name="number_of_keywords"
                                              placeholder="5" />
                                <small class="text-muted">{{ localize('Minimum 3 words') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 numberOfResultDiv">
                        <div class="row align-items-center g-2">
                            <div class="col-auto flex-grow-1">
                                <x-form.label for="number_of_results" isRequired="true">
                                    {{ localize('Number of Results') }}
                                </x-form.label>
                                <x-form.input type="text" class="form-control form-control-sm" id="number_of_results" value="1" name="number_of_results" placeholder="5" />
                            </div>
                        </div>
                    </div>

                    @include("backend.admin.articles.sidebar.advanced")
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

                    @include("backend.admin.articles.sidebar.keyword")
                    @include("backend.admin.articles.sidebar.titles")
                    @include("backend.admin.articles.sidebar.meta-description")
                    @include("backend.admin.articles.sidebar.outlines")
                    @include("backend.admin.articles.sidebar.images")
                </div>
            </div>
        </div>

    </div>
</form>
