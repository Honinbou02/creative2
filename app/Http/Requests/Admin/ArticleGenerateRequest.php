<?php

namespace App\Http\Requests\Admin;

use App\Rules\FocusKeywordMaxRule;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArticleGenerateRequest extends FormRequest
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
            "article_id"      => "required|exists:articles,id",
            "title"           => "required",
            "keywords"        => "nullable",
            "outlines"        => "required|array",
            "lang"            => "nullable",
            "meta_description" => "required",
            "focus_keyword"    => ["required", new FocusKeywordMaxRule(6)],
        ];
    }

    public function getData()
    {
        $validatedData                    = $this->validated();
        $validatedData["content_purpose"] = "articles";
        $validatedData["stream"]          = true;

        return $validatedData;
    }

    /**
     * @throws \JsonException
     */
    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        $this->validationException($validator,localize("Article Generation Validation Error"));
    }

}
