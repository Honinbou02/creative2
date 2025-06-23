<?php

namespace App\Http\Requests\Admin\Voice;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class VoiceCloneRequest extends FormRequest
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
            "name" => "required|string",
            "description" => "nullable|string",
            "audio_file" => "required|file|mimes:mp3,m4a|max:5250",
            "content_purpose" => "required|string",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Voice Clone Name is required",
            "audio_file.required" => "Audio file is required",
            "audio_file.mimes" => "Audio file must be mp3 or m4a",
            "audio_file.max" => "Audio file size must be less than 5MB",
        ];
    }

    /**
     * @throws \JsonException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->validationException($validator, localize("Failed to Voice Clone. Validation Error"));
    }
}
