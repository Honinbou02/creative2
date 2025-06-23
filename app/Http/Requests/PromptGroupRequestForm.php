<?php

namespace App\Http\Requests;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PromptGroupRequestForm extends FormRequest
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
            "group_name" => ["bail","required","string","max: 255", 'unique:prompt_groups,group_name,'.$this->id],
            "is_active"  => "required|numeric",
        ];
    }


    public function attributes()
    {
        return [
            "group_name" => "Group Name",
            "is_active"     => "Is Active",
        ];
    }

    public function getData()
    {
        $data = $this->validated();
        $data["slug"] = slugMaker($this->group_name);

        return $data;
    }


    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("Prompt Group Validation Error"),
                [],
                $validator->errors()
            )
        );
    }
}

