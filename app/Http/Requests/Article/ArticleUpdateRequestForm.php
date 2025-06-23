<?php

namespace App\Http\Requests\Article;

use App\Rules\FocusKeywordMaxRule;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ArticleUpdateRequestForm extends FormRequest
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
            'article'            => "nullable",
            'title'              => ['nullable','string'],
            'topic'              => ['nullable','string'],
            'keywords'           => ['nullable','string'],
            'focus_keyword'      => ['nullable' , new FocusKeywordMaxRule(6)],
            'meta_description'   => ['nullable'],
            'selected_image'     => ['nullable'],
          ];
    }

    public function getData()
    {
        $data = $this->validated();
        $data["selected_title"]             = $this->title;
        $data["selected_keyword"]           = $this->keywords;
        $data["selected_meta_description"]  = $this->meta_description;

        // unset title, keywords,meta_description
        unset($data["title"], $data["keywords"], $data["meta_description"]);

        return $data;
    }

    /**
     * @throws \JsonException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->validationException($validator, localize("Failed to Update Article. Validation Error"));
    }
}
