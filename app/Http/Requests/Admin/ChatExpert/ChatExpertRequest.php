<?php

namespace App\Http\Requests\Admin\ChatExpert;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChatExpertRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'expert_name'          => 'required|string|max:255',
            'short_name'           => 'required|string|max:255',
            'role'                 => 'required|string|max:255',
            'description'          => 'nullable',
            'assists_with'         => 'required|string|max:255',
            'slug'                 => 'nullable',
            'chat_training_data'   => 'text|nullable',
            'avatar'               => 'string|nullable',
            'type'                 => 'string|nullable',
            'is_active'            => 'numeric',
        ];
    }

    public function messages() {
        return [
            'expert_name.required'  => 'The expert name field is required.',
            'expert_name.string'    => 'The expert name field must be a string.',
            'expert_name.max'       => 'The expert name field must not exceed 255 characters.',
            'short_name.required'   => 'The short name field is required.',
            'short_name.string'     => 'The short name field must be a string.',
            'short_name.max'        => 'The short name field must not exceed 255 characters.',
            'role.required'         => 'The expert type field is required.',
            'role.string'           => 'The expert type field must be a string.',
            'role.max'              => 'The expert type field must not exceed 255 characters.',
            'assists_with.required' => 'The assist with field is required.',
            'assists_with.string'   => 'The assist with field must be a string.',
            'assists_with.max'      => 'The assist with field must not exceed 255 characters.',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException($this->sendResponse(appStatic()::VALIDATION_ERROR, localize("There are errors in the form."), [], $validator->errors()));
    }

    public function getValidatedData($id = 0) {
        $data = $this->validated();
        

        $data["is_active"]      = setActiveStatus();

        unset($data['id']);

        return $data;
    }
}
