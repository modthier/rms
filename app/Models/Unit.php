<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = [];
    public function stocks()
    {
    	return $this->hasMany(Stock::class);
    }


    public function items()
    {
    	return $this->hasMany(Item::class);
    }


}
