<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyExpense extends Model
{
	protected $fillable = [
        'title' , 'amount'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
