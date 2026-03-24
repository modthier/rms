<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest
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
            'total' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'nullable|string|max:255',
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
            'total.required' => 'المجموع الإجمالي مطلوب',
            'total.min' => 'المجموع يجب أن يكون أكبر من أو يساوي صفر',
            'items.required' => 'يجب إضافة صنف واحد على الأقل',
            'items.min' => 'يجب إضافة صنف واحد على الأقل',
            'items.*.quantity.required' => 'الكمية مطلوبة',
            'items.*.quantity.min' => 'الكمية يجب أن تكون أكبر من أو تساوي صفر',
            'supplier_id.required' => 'المورد مطلوب',
            'supplier_id.exists' => 'المورد غير صالح',
           
        ];
    }
}
