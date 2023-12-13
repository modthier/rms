<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'status' , 'user_id' , 'total_price' , 'total_items'
    ];

    public function items()
    {
    	return $this->belongsToMany(Item::class,'order_details')
                    ->withPivot('quantity')
                    ->withPivot('id')
                    ->withPivot('price')
                    ->withTimeStamps();
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id','id');
    }

    public function getItemsByTypes($type)
    {
        $result = DB::table('order_details as os')
                ->select([
                    'os.id' , 'i.name' , 'os.price' , 'os.quantity' , 'os.created_at'
                ])
                ->leftJoin('items as i' ,'os.item_id','i.id')
                ->leftJoin('orders as s','os.order_id','s.id')
                ->where('os.order_id',$this->id)
                ->where('i.item_type_id',$type)
                ->get();
        return $result;
    }


}
