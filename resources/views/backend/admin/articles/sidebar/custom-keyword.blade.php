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