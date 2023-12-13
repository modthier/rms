<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DailyConsumptionRule implements Rule
{

    public $availabe_quantity;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($availabe_quantity)
    {
        $this->$availabe_quantity = $availabe_quantity;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (int) $value <= (int) $this->availabe_quantity;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
       return 'لا يمكنك سحب كمية اكثر من الموجودة بالمخزون';

    }
}
