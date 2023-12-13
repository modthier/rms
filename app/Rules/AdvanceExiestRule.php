<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Advance;
use Carbon\Carbon;

class AdvanceExiestRule implements Rule
{

    public $month;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($month)
    {
        $this->month = $month;
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
        $now = Carbon::now();
        $currentYear = $now->format('Y');

        return Advance::where('employee_id',$value)
                        ->where('month',$this->month)
                        ->where('year',$currentYear)
                        ->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'الموظف لديه سلفية  في هذا الشهر مسبقا';
    }
}
