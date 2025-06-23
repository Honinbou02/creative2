<?php

namespace App\Http\Requests;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PromptRequestForm extends FormRequest
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
            "name" => ["bail","required","string","max: 255", 'unique:prompts,name,'.$this->id],
            'prompt_group_id'=>['required'],
            'description' =>['required'],
            "is_active"  => "required|numeric",
        ];
    }


    public function attributes()
    {
        return [
            "is_active"       => "Is Active",
            "description"     => "Prompt",
            "prompt_group_id" => "Group",
            'name'            => 'Title'
        ];
    }

    public function getData()
    {
        $data = $this->validated();
        $data["slug"] = slugMaker($this->name);

        return $data;
    }


    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("Prompt Validation Error"),
                [],
                $validator->errors()
            )
        );
    }
}
