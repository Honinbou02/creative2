<?php

namespace App\Http\Requests\Admin\ChatThread;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChatThreadRequest extends FormRequest
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
 

        $rules = [
            "message"        => "required|string",
            "images"         => "nullable",
            "chat_thread_id" => "required|exists:chat_threads,id",
        ];

        if(isAiChat($this->content_purpose)){
            $rules["chat_expert_id"] =  "required|exists:chat_experts,id";
        }
        return $rules;
    }

    public function getData()
    {
        $data = $this->validated();
        $data["title"] = "untitled-conversation";
        $data["type"] = "chat";

        return $data;
    }
    public function attributes()
    {
        return [
            'chat_thread_id'=> 'chat conversation'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        validationException(
            $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                localize("Validation error"),
                [],
                $validator->errors()
            )
        );
    }

}
