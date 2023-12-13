<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{

	protected $fillable = ['ingredient'];
	
    public function items()
    {
    	return $this->hasMany(Item::class);
    }


    public function stocks()
    {
    	return $this->hasMany(Stock::class);
    }
}
