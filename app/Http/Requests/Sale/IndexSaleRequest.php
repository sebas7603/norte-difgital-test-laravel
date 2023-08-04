<?php

namespace App\Http\Requests\Sale;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class IndexSaleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'items' => 'bail|nullable|filled|numeric|min:5',
            'page' => 'bail|nullable|filled|numeric|min:1',
            'start_date' => 'bail|nullable|filled|date_format:Y-m-d|before_or_equal:today',
            'end_date' => 'bail|nullable|filled|date_format:Y-m-d|before_or_equal:today|after_or_equal:start_date',
        ];
    }

    public function failedValidation(Validator $validator) : JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'message' => 'There are some validation errors.',
            'error' => [
                'fields' => $validator->errors()
            ]
        ], 400));
    }
}
