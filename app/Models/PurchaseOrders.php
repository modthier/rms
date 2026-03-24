<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrders extends Model
{
	protected $guarded = [];

    protected $casts = [
        'total_price' => 'decimal:2',
        'quantity' => 'decimal:3',
    ];

    public function stock()
    {
        return $this->belongsToMany(Stock::class,'purchase_items','purchase_id','stock_id')
            ->withPivot(['quantity','subtotal','stock_id','ingredient_id','unit_id'])
            ->withTimestamps();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
}
