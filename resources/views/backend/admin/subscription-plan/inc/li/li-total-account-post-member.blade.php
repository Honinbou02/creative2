<li>
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <span>
                <i data-feather="check-circle" class="icon-14 me-2 text-success"></i>
                <strong
                        class="tt_update_text"
                        id="total_social_platform_account_per_month"
                        data-name="total_social_platform_account_per_month"
                        onkeypress="nonNumericFilter()">{{ $subscriptionPlan->total_social_platform_account_per_month }}</strong> {{ localize('Social Platform Accounts') }}
            </span>

            <span class="tt-edit-icon ms-2 text-muted" id="allow_word_edit">
                <i class="tt_editable cursor-pointer icon-14"
                    data-name="total_social_platform_account_per_month"
                    data-feather="edit"></i>
            </span>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="form-check tt-checkbox">
                <input class="form-check-input cursor-pointer tt_editable"
                        type="checkbox"
                        id="show_total_social_platform_account"
                        data-name="show_total_social_platform_account"
                        @if ($subscriptionPlan->show_total_social_platform_account == 1) checked @endif>
            </div>

            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input cursor-pointer" checked disabled>
            </div>
        </div>
    </div>
</li>
<li>
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <span>
                <i data-feather="check-circle" class="icon-14 me-2 text-success"></i>
                <strong
                        class="tt_update_text"
                        id="total_social_platform_post_per_month"
                        data-name="total_social_platform_post_per_month"
                        onkeypress="nonNumericFilter()">{{ $subscriptionPlan->total_social_platform_post_per_month }}</strong> {{ localize('Social Platform Posts') }}
            </span>

            <span class="tt-edit-icon ms-2 text-muted" id="allow_word_edit">
                <i class="tt_editable cursor-pointer icon-14"
                    data-name="total_social_platform_post_per_month"
                    data-feather="edit"></i>
            </span>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="form-check tt-checkbox">
                <input class="form-check-input cursor-pointer tt_editable"
                        type="checkbox"
                        id="show_total_social_platform_post"
                        data-name="show_total_social_platform_post"
                        @if ($subscriptionPlan->show_total_social_platform_post == 1) checked @endif>
            </div>

            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input cursor-pointer" checked disabled>
            </div>
        </div>
    </div>
</li>