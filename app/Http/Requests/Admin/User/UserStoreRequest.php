<?php

namespace App\Http\Requests\Admin\User;

use App\Services\Model\User\UserService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
        info("User Incoming : ".json_encode(request()->all()));
        // "email:rfc,dns"
        return [
            "name"        => "required|string",
            "email"       => ["required","unique:users,email"],
            "mobile_no"   => ["nullable"],
            "role_id"     => ["required","exists:roles,id"],
            "password"    => "required|min:6|confirmed",
            'is_active'   => 'numeric',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            $this->sendResponse(appStatic()::VALIDATION_ERROR,
                "User Validation errors.", [],
                $validator->errors())
        );
    }


    public function getValidatedData() {
        $data = $this->validated();

        $accountFor                = isCustomerUserGroup() ? appStatic()::TYPE_CUSTOMER_TEAM : appStatic()::TYPE_ADMIN_STAFF;
        $data["password"]          = bcrypt($data["password"]);
        $data["parent_user_id"]    = $accountFor == appStatic()::TYPE_CUSTOMER ? null :  getAdminOrCustomerId();
        $data["user_type"]         = $accountFor;
        $data["is_active"]         = setActiveStatus();
        $data["email_verified_at"] = now(); 

        unset($data['id']);

        return $data;
    }
}
