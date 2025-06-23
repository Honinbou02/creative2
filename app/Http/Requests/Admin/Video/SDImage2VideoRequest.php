<?php

namespace App\Http\Requests\Admin\Video;

use Illuminate\Foundation\Http\FormRequest;

class SDImage2VideoRequest extends FormRequest
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
        info("Video Request", $this->all());
        return [
            "image"            => "required|image|mimes:jpeg,png",
            "seed"             => "nullable|integer",
            "cfg_scale"        => "required|numeric|between:0,10",
            "motion_bucket_id" => "required|integer|between:1,255",
        ];
    }
}
