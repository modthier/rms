<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On; 
class RealTimeOrder extends Component
{
    
    
    protected $listeners = ['orders_list' => 'render','echo:orders,Hello' => 'render'];
    //#[On('echo:orders,Hello')]
    public function render()
    {
        $orders = Order::where('status',0)->orderBy('id','desc')->get();
        
        return view('livewire.real-time-order')->with([
            'orders'=> $orders,
            
        ]);
    }

    public function updateOrderStatus($order_id)
    {
       
            $status = ['status' => 1];
            $order = Order::find($order_id);
            $order->update($status);
            $this->emit('orders_list');
        
    }
}
