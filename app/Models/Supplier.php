<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];

    function purchaseOrders()  {
        return $this->hasMany(PurchaseOrders::class,'supplier_id');
    }
}
