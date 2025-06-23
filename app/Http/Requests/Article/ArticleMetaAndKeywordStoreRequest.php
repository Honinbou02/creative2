<?php

namespace App\Http\Requests\Article;

use App\Rules\FocusKeywordMaxRule;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ArticleMetaAndKeywordStoreRequest extends FormRequest
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
            "article_id"       => "required|exists:articles,id",
            "content_body"     => [
                "required",
                isFocusKeyword($this->is_focus_keyword) ? new FocusKeywordMaxRule(6) : ""
            ],
            "is_focus_keyword" => "required|in:1,2", // 1: Focus Keyword, 2: Meta Description
        ];
    }

    public function messages()
    {
        return [
            "content_body.required" => $this->is_focus_keyword == 1 ? localize("Please enter focus keyword") :  localize("Please enter meta description"),
        ];
    }

    /**
     * @throws \JsonException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->validationException($validator, localize("Form Validation Error"));
    }

}
