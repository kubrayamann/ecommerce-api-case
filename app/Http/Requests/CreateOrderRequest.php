<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Responses\SystemResponse;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customerId' => 'required|integer|exists:customers,id',
            'items' => 'required|array',
            'items.*.productId' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'customerId.required' => 'Müşteri kimliği gereklidir',
            'customerId.integer' => 'Müşteri kimliği tamsayı olmalıdır',
            'customerId.exists' => 'Müşteri bulunamadı',
            'items.required' => 'Sipariş öğeleri gereklidir',
            'items.*.productId.required' => 'Ürün kimliği gereklidir',
            'items.*.productId.integer' => 'Ürün tamsayı olmalıdır',
            'items.*.productId.exists' => 'Ürün bulunamadı',
            'items.*.quantity.required' => 'Ürün miktarı gereklidir',
            'items.*.quantity.integer' => 'Ürün miktarı tamsayı olmalıdır',
            'items.*.quantity.min' => 'Ürün miktarı en az 1 olmalıdır'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            SystemResponse::error($validator->errors()->first(), 422)
        );
    }
}
