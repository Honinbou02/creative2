<!-- Offcanvas -->
<div class="offcanvas offcanvas-end" id="offCanvasArticleSeoChecker" tabindex="-1"> 
    @csrf
    <x-form.input type="hidden" name="article_id" id="article_id" class="articleId" value="{{ isset($editArticle) ? $editArticle->id : 0 }}" />

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ localize('SEO Checker') }}</h5>
        <span class="tt-close-btn" data-bs-dismiss="offcanvas">
            <i data-feather="x"></i>
        </span>
    </div>
    <x-common.splitter />
    <div class="offcanvas-body offCanvasArticleSeoCheckerContainer" data-simplebar>
        <div class="row g-3">
            <div class="col-12 mt-1">
                <div class="card">
                    <div class="card-body">
                        <div id="seoChart"></div>

                        <div class="w-100">
                            <div class="row g-3 meeterSectionReport category_section_blade">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="tt-custom-scrollbar overflow-y-auto overflow-x-hidden seoFeedBacks seo_report"> 
                    
                </div>
            </div>
        </div>            
    </div>
</div>

<!-- offcanvas template end-->

