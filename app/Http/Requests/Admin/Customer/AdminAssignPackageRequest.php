<?php

namespace App\Http\Requests\Admin\Customer;

use App\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminAssignPackageRequest extends FormRequest
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
            'assign_subscription_plan_id'   => 'required',
            'assign_payment_method'         => 'required_if:is_paid_assign_package,paid',
            'assign_payment_amount'         => 'required_if:is_paid_assign_package,paid',
        ];
        
    }

    public function messages()
     {
        return [
            'assign_subscription_plan_id.required'  => 'The plan field is required.',
            'assign_payment_amount.required_if'     => 'Please enter the right amount.',
            'assign_payment_method'                 => 'The payment method field is required.',
        ];
    }

    protected function failedValidation(Validator $validator) 
    {
        throw new HttpResponseException($this->sendResponse(appStatic()::VALIDATION_ERROR, localize("There are errors in the form."), [], $validator->errors()));
    }

    public function getUserData() 
    {
        $data = $this->validated();
        return $data;
    }
}
