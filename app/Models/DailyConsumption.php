<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyConsumption extends Model
{
    protected $casts = [
        'quantity' => 'decimal:3',
    ];

    public function ingredient()
    {
    	return $this->belongsTo(Ingredient::class);
    }


    public function stock()
    {
    	return $this->belongsTo(Stock::class);
    }
}
