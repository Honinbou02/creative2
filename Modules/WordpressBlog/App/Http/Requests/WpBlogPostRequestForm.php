<?php

namespace Modules\WordpressBlog\App\Http\Requests;

use App\Traits\Api\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WpBlogPostRequestForm extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'article_id' => ['required', 'integer'],
            'tags'       => ['nullable', 'array'],
            'categories' => ['nullable', 'array'],
            'author'     => ['required', 'integer'],
            'status'     => ['required', 'string'],
            'website'    => ['required', 'integer'],
            "date"       => ['nullable','date_format:Y-m-d\TH:i'],
        ];
    }

    public function getData()
    {
        $data = $this->validated();

        // Parse and format the date if provided
        if (!empty($data['date'])) {
            try {
                $data['date'] = Carbon::parse($data['date'])->format('Y-m-d\TH:i:s');
            } catch (\Exception $e) {
                $data['date'] = null;
            }
        }

        // Filter out empty values (optional cleanup)
        return array_filter($data, fn($value) => $value !== null && $value !== '');
    }

    protected function failedValidation(Validator $validator)
    {
        $appStatic = appStatic();

        validationException(
            $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("Published Blog Validation Error"),
                [], $validator->errors()
            )
        );
    }

}
