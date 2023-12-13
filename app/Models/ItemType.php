<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{

    protected $fillable = [
        'type' , 'label'
    ];


    public function items()
    {
    	return $this->hasMany(Item::class);
    }
}
