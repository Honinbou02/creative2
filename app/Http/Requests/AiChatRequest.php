<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AiChatRequest extends FormRequest
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
        wLog("Code Generator Request",$this->request->all(), \logService()::LOG_OPEN_AI);
        return [
            "title"           => "nullable",
            "description"     => "nullable",
            "content_purpose" => ["required","in:chat,code,text,topic,keywords,title,outline,summary,summary_keywords"],
        ];
    }
}

