<?php

namespace App\Http\Requests\Admin\BrandVoice;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BrandVoiceStoreRequest extends FormRequest
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
            "brand_name"     => "required",
            "brand_website"  => "required",
            "industry"       => "array",
            "industry.*"     => "required",
            "brand_tagline"  => "required",
            "brand_audience" => "required",
            "brand_tone"     => "required",
            "brand_description" => "required",
            "names"          => "array",
            "names.*"        => "string",
            "descriptions"   => "array",
            "descriptions.*" => "string",
            "types"          => "array",
            "types.*"        => "string",
        ];
    }

    public function getData()
    {
        $data             = $this->validated();
        $data["industry"] = !empty($this->industry) ? json_encode($this->industry) :  null;

        return $data;
    }

    /**
     * @throws \JsonException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->validationException($validator, localize("Brand Voice Validation Error"));
    }

}
