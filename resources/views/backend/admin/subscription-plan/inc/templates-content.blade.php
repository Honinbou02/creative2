@foreach ($template_categories as $category)
    <div class="row g-2 pb-4 template-categorys-wrapper">
        <input type="hidden" id="plan_id" name="plan_id" value="{{ $subscription_plan->id }}">
        <input type="hidden" id="template_type" name="template_type" value="{{ $type }}">
        <div class="col-12">
            <div class="d-flex align-items-center mt-2">
                <div class="form-check form-switch me-2">
                    <input type="checkbox" class="form-check-input" id="all_templates-{{ $category->id }}"
                        name="all_templates-{{ $category->id }}" onchange="toggleGroupAll(this)">
                </div>
                <h6 class="mb-0"><label class="form-check-label fw-medium ms-1 cursor-pointer"
                        for="all_templates-{{ $category->id }}">{{ localize($category->category_name) }}</label></h6>
            </div>
        </div>

        @foreach ($category->adminTemplates as $template)
       
                <div class="col-6 col-md-4">
                    <div class="alert alert-secondary d-flex flex-wrap mb-0 py-2">
                        <label class="flex-grow-1 cursor-pointer" for="template-{{ $template->id }}">
                            {{ $template->template_name }}
                        </label>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" class="form-check-input permission-checkbox" name="templates[]"
                                id="template-{{ $template->id }}" value="{{ $template->id }}"
                                @if (in_array($template->id, $exitTemplateIds)) checked @endif>
                        </div>
                    </div>
                </div>
        @endforeach
    </div>
@endforeach
