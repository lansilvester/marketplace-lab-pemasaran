<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CheckoutComponent extends Component
{
    use WithFileUploads;

    public $images = [];
    public $imagePreviews = [];

    public function rules()
    {
        return [
            'images.*' => 'required|mimes:jpeg,jpg,png'
        ];
    }

    public function updatedImages()
    {
        // Update preview untuk setiap gambar
        $this->imagePreviews = [];
        foreach ($this->images as $image) {
            $this->imagePreviews[] = $image->temporaryUrl();
        }
    }

    public function checkout()
    {
        // Cek jika ada item dari wishlist
        if (request()->has('wishlist')) {
            $wishlistItem = Cart::instance('wishlist')->get(request()->wishlist);
            if ($wishlistItem) {
                $price = (float) str_replace(',', '', $wishlistItem->price);
                Cart::instance('cart')->add($wishlistItem->id, $wishlistItem->name, 1, $price)->associate('App\Models\Product');
                Cart::instance('wishlist')->remove(request()->wishlist);
            }
        }

        $cartItems = Cart::instance('cart')->content();

        if ($cartItems->isEmpty()) {
            session()->flash('error_message', 'Keranjang belanja masih kosong.');
            return redirect()->route('product.cart');
        }

        $this->validate();

        // Simpan semua gambar yang diupload
        $imageNames = [];
        foreach ($this->images as $image) {
            $imageName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $image->extension();
            $image->storeAs('orders', $imageName);
            $imageNames[] = $imageName;
        }
        $paymentProof = json_encode($imageNames);

        // Kelompokkan item per penjual, lalu buat satu order per penjual
        $itemsBySeller = [];
        foreach ($cartItems as $item) {
            $sellerId = optional($item->model)->user_id;
            if (!$sellerId) {
                session()->flash('error_message', 'Salah satu produk tidak tersedia lagi. Periksa kembali keranjang Anda.');
                return redirect()->route('product.cart');
            }
            $itemsBySeller[$sellerId][] = $item;
        }

        foreach ($itemsBySeller as $sellerId => $sellerItems) {
            $order = new Order();
            $order->user_id = Auth::id();
            $order->seller_id = $sellerId;
            $order->total = round(collect($sellerItems)->sum(function ($item) {
                return (float) $item->total;
            }), 2);
            $order->status = 'pending';
            $order->payment_proof = $paymentProof;
            $order->save();

            foreach ($sellerItems as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->id;
                $orderItem->quantity = $item->qty;
                $orderItem->total = round((float) $item->total, 2);
                $orderItem->save();
            }
        }

        Cart::instance('cart')->destroy();

        session()->flash('message', 'Berhasil melakukan pembayaran. Menunggu Konfirmasi');
        return redirect()->route('product.order');
    }

    public function render()
    {
        return view('livewire.checkout-component')->layout('layouts.base');
    }
}
