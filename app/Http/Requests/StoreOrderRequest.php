<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_id' => 'required|exists:payments,id',
            'order_type_id' => 'required|exists:order_types,id',
            'total' => 'required|numeric|min:0',
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
            'items.required' => 'يجب إضافة عنصر واحد على الأقل',
            'items.min' => 'يجب إضافة عنصر واحد على الأقل',
            'items.*.quantity.required' => 'الكمية مطلوبة',
            'items.*.quantity.min' => 'الكمية يجب أن تكون أكبر من صفر',
            'payment_id.required' => 'طريقة الدفع مطلوبة',
            'order_type_id.required' => 'نوع الطلب مطلوب',
        ];
    }
}
