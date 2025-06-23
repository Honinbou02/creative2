<?php

namespace App\Http\Requests\Admin\TextToSpeech;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TextToSpeechRequestForm extends FormRequest
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
            'engine'          => ['required', 'string'],
            'model'           => ['required_if:engine,'.appStatic()::ENGINE_OPEN_AI],
            'voice'           => ['required'],
            'speed'           => ['required_if:engine,'.appStatic()::ENGINE_OPEN_AI],
            'response_format' => ['required_if:engine,'.appStatic()::ENGINE_OPEN_AI],
            'title'           => ['required','string'],
            'content'         => ['required']
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException($this->sendResponse(appStatic()::VALIDATION_ERROR, "There are errors in the form.", [], $validator->errors()));
    }

    public function getData()
    {

        $data                 = $this->validated();
        return $data;
    }

}
