<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderComponent extends Component
{
    public $orders;
    public $selectedOrder;


    public function mount()
    {
        $this->orders = Order::where('user_id', Auth::id())->with('items')->get();

        // Decode payment proof JSON to array
        foreach ($this->orders as $order) {
            $order->payment_proof = json_decode($order->payment_proof, true);
        }
}


    public function showOrderDetails($orderId)
    {
        $this->selectedOrder = Order::with('items')->find($orderId);
        $this->dispatchBrowserEvent('show-modal');
    }
    public function render()
    {
        return view('livewire.order-component')->layout('layouts.base');
    }
}
