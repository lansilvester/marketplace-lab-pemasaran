<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderComponent extends Component
{
    public $orders;

    public $selectedOrder;

    public function mount()
    {
        $this->orders = Order::where('user_id', Auth::id())->with('items')->get();
    }

    public function showOrderDetails($orderId)
    {
        $this->selectedOrder = Order::with('items')->find($orderId);
        $this->dispatch('show-modal');
    }

    public function render()
    {
        return view('livewire.order-component')->layout('layouts.base');
    }
}
