<?php

namespace App\Http\Requests\Sale;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Closure;

class StoreSaleRequest extends FormRequest
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
            'total' => 'missing',
            'branch_id' => 'bail|required|numeric|min:1|exists:App\Models\Branch,id',
            'client_id' => 'bail|required|numeric|min:1|exists:App\Models\Client,id',
            'salesman_id' => 'bail|required|numeric|min:1|exists:App\Models\Salesman,id',
            'products' => 'bail|required|array',
            'products.*.price' => 'missing',
            'products.*.subtotal' => 'missing',
            'products.*.quantity' => 'bail|required|numeric|min:1',
            'products.*.id' => [
                'bail',
                'required',
                'numeric',
                'distinct',
                'exists:App\Models\Product,id',
                function (string $attribute, mixed $value, Closure $fail) {
                    $productExists = DB::table('branch_product')
                        ->where('product_id', '=', $value)
                        ->where('branch_id', '=', $this->branch_id)
                        ->first();
                    if (!$productExists) {
                        $fail('The selected :attribute is not available for branch ' . $this->branch_id . '.');
                    }
                },
            ],
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
