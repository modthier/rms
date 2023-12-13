<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
	protected $fillable = [
         'total_price' , 'quantity' , 'ingredient_id' ,'unit_id' , 'unit_price'
    ];

    public function ingredient()
    {
    	return $this->belongsTo(Ingredient::class);
    }


    public function unit()
    {
    	return $this->belongsTo(Unit::class);
    }


    public function purchaseOrder()
    {
        return $this->hasOne(PurchaseOrders::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    
}
