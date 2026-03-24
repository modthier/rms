<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_number' => 'nullable|integer|min:1',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ];
    }
}

