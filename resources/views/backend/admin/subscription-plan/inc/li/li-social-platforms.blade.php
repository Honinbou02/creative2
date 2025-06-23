<li>
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <span>
                <i data-feather="check-circle" class="icon-14 me-2 text-success"></i>
                {{ localize('Facebook Platform') }}
            </span>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="form-check tt-checkbox">
                <input class="form-check-input cursor-pointer tt_editable"
                       type="checkbox"
                       id="show_facebook_platform"
                       data-name="show_facebook_platform"
                       @if ($subscriptionPlan->show_facebook_platform == 1) checked @endif>
            </div>

            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input cursor-pointer tt_editable"
                       id="allow_facebook_platform"
                       data-name="allow_facebook_platform"
                       @if ($subscriptionPlan->allow_facebook_platform == 1) checked @endif>
            </div>
        </div>
    </div>
</li>
<li>
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <span>
                <i data-feather="check-circle" class="icon-14 me-2 text-success"></i>
                {{ localize('Instagram Platform') }}
            </span>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="form-check tt-checkbox">
                <input class="form-check-input cursor-pointer tt_editable"
                       type="checkbox"
                       id="show_instagram_platform"
                       data-name="show_instagram_platform"
                       @if ($subscriptionPlan->show_instagram_platform == 1) checked @endif>
            </div>

            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input cursor-pointer tt_editable"
                       id="allow_instagram_platform"
                       data-name="allow_instagram_platform"
                       @if ($subscriptionPlan->allow_instagram_platform == 1) checked @endif>
            </div>
        </div>
    </div>
</li>
<li>
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <span>
                <i data-feather="check-circle" class="icon-14 me-2 text-success"></i>
                {{ localize('Twitter Platform') }}
            </span>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="form-check tt-checkbox">
                <input class="form-check-input cursor-pointer tt_editable"
                       type="checkbox"
                       id="show_twitter_platform"
                       data-name="show_twitter_platform"
                       @if ($subscriptionPlan->show_twitter_platform == 1) checked @endif>
            </div>

            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input cursor-pointer tt_editable"
                       id="allow_twitter_platform"
                       data-name="allow_twitter_platform"
                       @if ($subscriptionPlan->allow_twitter_platform == 1) checked @endif>
            </div>
        </div>
    </div>
</li>
<li>
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <span>
                <i data-feather="check-circle" class="icon-14 me-2 text-success"></i>
                {{ localize('LinedIn Platform') }}
            </span>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="form-check tt-checkbox">
                <input class="form-check-input cursor-pointer tt_editable"
                       type="checkbox"
                       id="show_linkedin_platform"
                       data-name="show_linkedin_platform"
                       @if ($subscriptionPlan->show_linkedin_platform == 1) checked @endif>
            </div>

            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input cursor-pointer tt_editable"
                       id="allow_linkedin_platform"
                       data-name="allow_linkedin_platform"
                       @if ($subscriptionPlan->allow_linkedin_platform == 1) checked @endif>
            </div>
        </div>
    </div>
</li>
