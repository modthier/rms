<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyExpenseSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expense_type_id' => 'required|exists:expense_types,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ];
    }
}

