<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
	protected $fillable = [
         'total_price' , 'quantity' , 'ingredient_id' ,'unit_id' , 'unit_price'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'quantity' => 'decimal:3',
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
        return $this->belongsToMany(PurchaseOrders::class,'purchase_items','stock_id','purchase_id') 
        ->withPivot(['quantity','subtotal','stock_id','ingredient_id','unit_id'])
        ->withTimestamps();   
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    
}
