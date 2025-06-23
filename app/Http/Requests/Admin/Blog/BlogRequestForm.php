<?php

namespace App\Http\Requests\Admin\Blog;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BlogRequestForm extends FormRequest
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
            "title"             => ["bail","required","string","max: 255"],
            "blog_category_id"  => ["required","numeric"],
            "is_active"         => ["required","numeric"],
            "tag_ids"           => ["nullable","array"],
            "tag_ids.*"         => ["exists:tags,id"],
            "short_description" => ["nullable"],
            "description"       => ["nullable"],
            "blog_image"        => ["nullable"],
            "meta_title"        => ["nullable"],
            "meta_description"  => ["nullable"],
            "meta_image"        => ["nullable"],
        ];
    }

    public function attributes()
    {
        return [
            "is_active"        => "Status",
            "blog_category_id" => "Category",
        ];
    }

    public function getData()
    {
        $data         = $this->validated();
        $data["slug"] = slugMaker($this->title);

        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("Blog Validation Error"),
                [], $validator->errors()
            )
        );
    }

}
