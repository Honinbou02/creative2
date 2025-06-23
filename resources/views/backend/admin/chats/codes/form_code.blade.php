
<div class="content-generator__sidebar-body">
    <div class="row g-3">
        <div class="col-12">

            <x-form.label for="titleInput" class="form-label" label="Type Title" isRequired="true"/>

            <x-form.input name="title"
                          placeholder="What type of code do you want to generate?"
            />

            <x-form.input type="hidden"
                          name="content_purpose"
                          value="code"
            />

        </div>
        <div class="col-12">
            <x-form.label for="descriptionInput"
                          class="form-label"
                          label="Type Description"
                          isRequired="false" />

            <x-form.textarea name="description" placeholder="Generate what type of code."></x-form.textarea>
        </div>
    </div>
</div>
<div class="content-generator__sidebar-footer py-3">
    <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
        <x-form.button class="btn btn-sm btn-primary rounded-pill" id="newCodeGenerate">
            {{ localize('Generate Content') }}
            <i data-feather="rotate-cw" class="icon-14"></i>
        </x-form.button>
    </div>
</div>