<?php

namespace Modules\SocialPilot\App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PostRequestForm extends FormRequest
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
        // {{ $platform->slug }}_post_type - facebook_post_type, instagram_post_type .... 
        $platforms = appStatic()::PLATFORM_LIST;
        $rules = [];

        foreach ($platforms as $platform) {
            $rules["{$platform}_post_type"]     = ['required'];
            $rules["{$platform}_post_details"]  = ['required'];
        }

        $rules['platform_account_ids']      = ['required', 'array'];
        $rules['platform_account_ids.*']    = ['required', 'integer'];

        return $rules;
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
                localize("Quick text Validation Error, Please check the required inputs"),
                [], $validator->errors()
            )
        );
    }
}
