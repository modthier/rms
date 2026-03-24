<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequirmentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'quantity' => 'required',
            'total_price' => 'required',
            'requirement_type_id' => 'required',
            'unit_id' => 'required',
          

        ];
    }
}
