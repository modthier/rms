<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'unit_id' => 'required|exists:units,id',
            'unit_price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ingredient_id.required' => 'المكون مطلوب',
            'ingredient_id.exists' => 'المكون غير صالح',
            'quantity.required' => 'الكمية مطلوبة',
            'quantity.min' => 'الكمية يجب أن تكون أكبر من أو تساوي صفر',
            'total_price.required' => 'السعر الإجمالي مطلوب',
            'unit_id.required' => 'الوحدة مطلوبة',
            'unit_id.exists' => 'الوحدة غير صالحة',
            'unit_price.required' => 'سعر الوحدة مطلوب',
        ];
    }
}
