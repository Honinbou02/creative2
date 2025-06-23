<?php

namespace App\Http\Requests\Admin\Tag;

use Illuminate\Validation\Rule;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TagRequestForm extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            "name"       => ["bail","required","string","max: 255", Rule::unique('tags', 'name')->whereNull('deleted_at')->ignore($this->id)],
            "is_wp_sync" => ["nullable","string"],
            "is_active"  => ["required","numeric"],
        ];
    }

    public function attributes()
    {
        return [
            "is_active"     => "Status",
        ];
    }

    public function getData()
    {
        $data         = $this->validated();
        $data["slug"] = slugMaker($this->name);

        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("Tags Validation Error"),
                [], $validator->errors()
            )
        );
    }
}
