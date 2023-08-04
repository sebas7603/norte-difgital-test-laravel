<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class IndexProductRequest extends FormRequest
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
            'branch' => 'bail|nullable|filled|numeric|min:1|exists:App\Models\Branch,id',
            'supplier' => 'bail|nullable|filled|numeric|min:1|exists:App\Models\Supplier,id',
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
