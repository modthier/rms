<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyConsumptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock_id' => 'required|exists:stocks,id',
            'remaining_quantity' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0.01',
        ];
    }
}

