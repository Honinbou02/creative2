<?php

namespace App\Http\Requests\AiWriter;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AiWriterRequestForm extends FormRequest
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
            'language'  =>  ['required'],
            'prompt'    =>  ['required']
        ];
    }
    public function getData()
    {
        $data                 = $this->validated();
        $data["slug"]         = slugMaker($this->prompt);
        $data['prompt']       = $this->prompt;
        $data['title']        = $this->prompt;
        $data['content_type'] = appStatic()::PURPOSE_GENERATE_TEXT;

        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                "AI Writer Validation Error",
                [], $validator->errors()
            )
        );
    }
}
