<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['method'];

    public function orders()
    {
    	return $this->hasMany(Order::class);
    }
}
