<?php

namespace Modules\SocialPilot\App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class QuickTextRequestForm extends FormRequest
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
            "title"        => ["required"],
            "description"  => ["required"],
        ];
    }


    public function attributes()
    {
        return [];
    }

    public function getData()
    {
        return $this->validated();
    }

    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();
        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("Quick text Validation Error, Some inputs are required"),
                [], $validator->errors()
            )
        );
    }
}
