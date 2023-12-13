<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyConsumption extends Model
{
    public function ingredient()
    {
    	return $this->belongsTo(Ingredient::class);
    }


    public function stock()
    {
    	return $this->belongsTo(Stock::class);
    }
}
