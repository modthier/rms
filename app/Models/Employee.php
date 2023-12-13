<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use App\Models\Advance;

class Employee extends Model
{
    protected $fillable = [
        'name' , 'salary' , 'day_salary' , 'hire_date'
    ];

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }


    public function advances(){
        return $this->hasMany(Advance::class);
    }

    public function getAdvance($id)
    {
    	$now = Carbon::now();
        $currentYear = $now->year;
        $currentMonth = $now->format('M');
        $add = 0;
    	$advance = Advance::select('amount')
    			->where('employee_id',$id)
    			->where('month',$currentMonth)
    			->where('year',$currentYear)
    			->get();
    	foreach ($advance as $a ) {
    		$add = $a->amount ;
    	}
    	return $add;
    }

    
}
