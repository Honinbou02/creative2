<?php

namespace App\Http\Requests\Admin\ChatCategory;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChatCategoryUpdateRequest extends FormRequest
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
            "category_name" => ["required", Rule::unique("chat_categories")->ignore($this->chat_category->id) ,"string","max:255"],
            "is_active"     => "required|numeric",
        ];
    }


    public function attributes()
    {
        return [
            "category_name" => "Category Name",
            "is_active"     => "Is Active",
        ];
    }

    public function getData()
    {
        $data = $this->validated();
        $data["slug"] = slugMaker($this->category_name);

        return $data;
    }


    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("Chat Category Validation Error"),
                [], $validator->errors()
            )
        );
    }
}
