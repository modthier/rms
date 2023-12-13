<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name' , 'price' , 'weight' , 'icon' , 'item_type_id' , 'ingredient_id' ,
        'unit_id'
    ];

    public function orders()
    {
    	return $this->belongsToMany(Order::class,'order_details')
                    ->withPivot('quantity')
                    ->withPivot('id')
                    ->withPivot('price')
                    ->withTimeStamps();
    }


    public function itemType()
    {
    	return $this->belongsTo(ItemType::class,'item_type_id','id');
    }


    public function ingredient()
    {
    	return $this->belongsTo(Ingredient::class,'ingredient_id','id');
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
