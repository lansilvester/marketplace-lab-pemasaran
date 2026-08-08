<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class TransaksiComponent extends Component
{
    public $transactions;

    public function mount()
    {
        $sellerId = Auth::id();

        if (in_array(Auth::user()->utype, ['ADM', 'OPT'])) {
            $this->transactions = Order::with('items.product')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $this->transactions = Order::where('seller_id', $sellerId)
                ->with('items.product')
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function updateStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return;
        }

        if ($order->seller_id !== Auth::id() && !in_array(Auth::user()->utype, ['ADM', 'OPT'])) {
            session()->flash('error_message', 'Anda tidak berhak mengubah status transaksi ini.');
            return;
        }

        $order->status = $status;
        $order->save();

        foreach ($this->transactions as &$transaction) {
            if ($transaction->id == $orderId) {
                $transaction->status = $status;
                break;
            }
        }
        unset($transaction);
    }

    public function render()
    {
        return view('livewire.admin.transaksi-component')->layout('layouts.base');
    }
}
