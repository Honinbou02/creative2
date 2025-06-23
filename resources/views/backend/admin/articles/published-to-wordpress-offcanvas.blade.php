<!-- Offcanvas -->
<form class="offcanvas offcanvas-end published-to-wordpress-form" action="{{ route('admin.wordpress-posts-published.store') }}"
    data-bs-backdrop="static" id="offcanvasPublishedToWordpress" tabindex="-1"> 
        @csrf
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">{{ localize('Push to Wordpress') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body" data-simplebar>
            <div class="published-to-wordpress-contents" id="published-to-wordpress-contents"></div>
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-flex gap-3 align-items-center">
                <x-form.button id="publishToWordPressBtn" class="published-to-wordpress-submit-btn"><i data-feather="trending-up" class="icon-14"></i> {{ localize('Push to WordPress') }}</x-form.button>
            </div>
        </div>
    </div>
</form> <!-- offcanvas template end-->

