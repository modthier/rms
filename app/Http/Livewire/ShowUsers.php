<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ShowUsers extends Component
{
    protected $listeners = ['echo:channel,Hello' => 'render'];
    public function render()
    {
        $users = User::orderBy('id','desc')->limit(6)->get();
        return view('livewire.show-users')->with('users',$users);
    }

    public function notify()
    {
        $this->emit('show-cart');
    }
}
