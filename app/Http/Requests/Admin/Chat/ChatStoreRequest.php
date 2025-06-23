<?php

namespace App\Http\Requests\Admin\Chat;

use Illuminate\Foundation\Http\FormRequest;

class ChatStoreRequest extends FormRequest
{
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
            "title" => "nullable",
            "chat_expert_id" => "required",
        ];

        $appStatic = appStatic();

        $purposeArray = [
            $appStatic::PURPOSE_VISION,
            $appStatic::PURPOSE_CHAT,
            $appStatic::PURPOSE_PDF,
            $appStatic::PURPOSE_AI_IMAGE,
        ];

        if(!in_array($this->content_purpose, $purposeArray) ){
            $rules["chat_expert_id"] =  "required|exists:chat_experts,id";
        }

        info("PDF Chat Incoming Params : ".json_encode($this->request->all()));
        return $rules;
    }

    public function getData()
    {
        $data              = $this->validated();
        $data["title"]     = "untitled-conversation"; 
        $data["type"]      = $this->content_purpose ?? "chat";
        $data["is_active"] = 1;

        return $data;
    }
}
