<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrders extends Model
{
	protected $fillable = [
        'total_price' , 'quantity' , 'stock_id' , 'user_id'
    ];

    public function stock()
    {
    	return $this->belongsTo(Stock::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
