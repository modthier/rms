<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UpdateOrderStatus extends Component
{
    
    
    public function render()
    {
        return view('livewire.update-order-status');
    }

    
}
