<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Validation\Rule;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BlogCategoryRequestForm extends FormRequest
{
    use ApiResponseTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "category_name"       => ["bail","required","string","max: 255", Rule::unique('blog_categories', 'category_name')->whereNull('deleted_at')->ignore($this->id)],
            "is_active"           => ["required","numeric"],
        ];
    }

    public function attributes()
    {
        return [
            "is_active"     => "Status",
        ];
    }

    public function getData()
    {
        $data         = $this->validated();
        $data["slug"] = slugMaker($this->category_name, true);

        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("Blog Category Validation Error"),
                [], $validator->errors()
            )
        );
    }
}
