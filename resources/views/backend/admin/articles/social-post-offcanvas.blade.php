<!-- Offcanvas -->
<form class="offcanvas offcanvas-end social-post-form" action="{{ route('admin.socials.posts.article-post-generation') }}"
    data-bs-backdrop="static" id="offcanvasSocialPosts" tabindex="-1"> 
        @csrf
        
        <x-form.input type="hidden"
        name="content_purpose"
        value="{{appStatic()::PURPOSE_SOCIAL_POST_GENERATION}}"/> 
        
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">{{ localize('Generate Social Posts') }}</h5>
            <span class="tt-close-btn" data-bs-dismiss="offcanvas">
                <i data-feather="x"></i>
            </span>
        </div>
        <x-common.splitter />
        <div class="offcanvas-body" data-simplebar>
            <div class="social-post-contents" id="social-post-contents">
                
            </div>
        </div>
        <div class="offcanvas-footer border-top bg-light">
            <div class="d-flex gap-3 align-items-center">
                <x-form.button class="btn-sm btn-primary rounded-pill generateSocialPostBtn" type="submit">
                    <i data-feather='rotate-cw' class='icon-10'></i> {{ localize('Generate Posts') }}
                </x-form.button>
            </div>
        </div>
    </form>
</form> <!-- offcanvas template end-->

