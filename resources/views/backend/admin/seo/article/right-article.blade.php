<div class="content-generator__sidebar content-generator__sidebar--end order-1 oreder-md-2">
    <div class="content-generator__sidebar-header pb-0 d-flex justify-content-between align-items-center gap-3">
        <h5 class="mb-0">{{ localize(" SEO Checker") }}</h5>
        <div class="dropdown tt-tb-dropdown">
            <button type="button" class="btn p-0 fullscreen-toggler">
                <span class="fullscreen-icon">
                    <i data-feather="maximize"></i>
                </span>
                <span class="exit-fullscreen-icon">
                    <i data-feather="minimize"></i>
                </span>
            </button>
        </div>
    </div>
    <div class="content-generator__sidebar-body tt-custom-scrollbar overflow-y-auto tt-screen-height">
        <div class="row g-3">
            <div class="col-12 mt-1">
                <div class="card">
                    <div class="card-body">
                        <div id="seoChart"></div>

                        <div class="w-100">
                            <div class="row g-3 category_section_blade">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="tt-custom-scrollbar overflow-y-auto overflow-x-hidden seo_report"> 
                    
                </div>
            </div>
        </div>
    </div>
    <div class="content-generator__sidebar-footer d-flex align-items-center mt-3">
        <button class="btn btn-sm btn-primary rounded-pill wpPostSeoCheckerBtn">
            <i data-feather="target" class="icon-14 me-1"></i> {{ localize("Check SEO") }}
        </button>
    </div>
</div>
