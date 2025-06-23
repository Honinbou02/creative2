<?php

namespace App\Http\Requests\Admin\KeywordGenerate;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class KeywordGenerateRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        info("Generate Keyword Incoming Payloads". json_encode($this->request->all()));
        
        return [
            "topic"                   => "required|string",
            "number_of_main_keywords" => ["required", "integer", "gt:0"],
            "number_of_keywords"      => ["required", "integer", "gt:0"],
            "lang"                    => "required|string",
            "article_id"              => "nullable|sometimes|exists:articles,id",
            "content_purpose"         => "required|in:".contentPurposeInside(),
            "seo_check"               => "nullable|in:0,1"
        ];
    }

    public function attributes()
    {
        return [
            "topic"                   => "Topic",
            "number_of_main_keywords" => "Main Keywords",
            "number_of_keywords"      => "Related Keywords",
            "lang"                    => "Language",
            "article_id"              => "Article ",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->sendResponse(appStatic()::VALIDATION_ERROR, localize("Failed to generate Keyword") , [], $validator->errors()));
    }

}
