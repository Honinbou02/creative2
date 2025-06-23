<?php

namespace App\Http\Requests\Admin\User;

use App\Services\Model\User\UserService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            "name"        => "required|string",
            "email"       => ["required","email:rfc,dns",Rule::unique("users")->ignore($this->user)],
            "mobile_no"   => ["nullable"],
            "role_id"     => ["nullable","exists:roles,id"],
            'is_active'   => 'numeric',
        ];
    }

    /**
     * @throws \JsonException
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            $this->sendResponse(appStatic()::VALIDATION_ERROR,
                "User Validation errors.", [],
                $validator->errors())
        );
    }


    public function getValidatedData() {
        $data = $this->validated();


        $data["parent_user_id"]    = getAdminOrCustomerId();
        $data["user_type"]         = appStatic()::TYPE_ADMIN_STAFF;
        $data["is_active"]         = setActiveStatus();

        unset($data['id']);

        return $data;
    }
}
