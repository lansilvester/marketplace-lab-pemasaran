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
        // Ambil ID penjual (seller)
        $sellerId = Auth::id();

        logger('Seller ID: ' . $sellerId);

        // Ambil transaksi yang hanya melibatkan produk yang dijual oleh penjual ini dan berstatus pending
        $this->transactions =Order::where('seller_id', $sellerId)
            ->with('items.product') // Menyertakan relasi items dan produk
            ->orderBy('created_at','desc') // Menyertakan relasi items dan produk
            ->get();

        logger('Jumlah transaksi: ' . $this->transactions->count());
    }
    public function updateStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status;
            $order->save();

            // Update status dalam koleksi transaksi yang ada, agar tidak perlu merefresh seluruh daftar
            foreach ($this->transactions as &$transaction) {
                if ($transaction->id == $orderId) {
                    $transaction->status = $status;
                    break;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.transaksi-component')->layout('layouts.base');
    }
}
