<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CanceledOrdersSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ];
    }
}

