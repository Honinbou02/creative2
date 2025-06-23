<?php

namespace Modules\WordpressBlog\App\Http\Requests;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class ImportPostContentRequest extends FormRequest
{
    use ApiResponseTrait;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'wp_post_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'wp_post_id.required' => 'Please select wordpress post',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @throws \JsonException
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validationException($validator, localize("Please select wordpress post"));
    }
}
