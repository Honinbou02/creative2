<?php

namespace Modules\WordpressBlog\App\Http\Requests;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WpCredentialRequestForm extends FormRequest
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
            "url"       => ["bail", "required"],
            "site_name" => ["nullable","string"],
            "user_name" => ["required","string"],
            "password"  => ["required","string"],
        ];
    }


    public function attributes()
    {
        return [         
            "is_active" => "Status",
            "user_name" => 'username'
        ];
    }

    public function getData()
    {
        $data              = $this->validated();        
        $data['is_active'] = 1;        
        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                "Wordpress Setting Validation Error",
                [], $validator->errors()
            )
        );
    }
}

