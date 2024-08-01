<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    public function checkout(Request $request)
    {
        // Cek jika ada item dari wishlist
        if ($request->has('wishlist')) {
            // Tambahkan item dari wishlist ke cart
            $item = Cart::instance('wishlist')->get($request->wishlist);
            Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
            Cart::instance('wishlist')->remove($request->wishlist);
        }

        $this->validate();

        $order = new Order();
        $order->user_id = Auth::id();
        $order->total = (float) str_replace(',', '', Cart::instance('cart')->total());
        $order->status = 'pending';

        // Mendapatkan seller_id dari produk pertama di keranjang
        $firstItem = Cart::instance('cart')->content()->first();
        $order->seller_id = $firstItem->model->user_id; // Pastikan model produk memiliki relasi yang benar ke penjual


        // Simpan semua gambar yang diupload
        $imageNames = [];
        foreach ($this->images as $image) {
            $imageName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $image->extension();
            $image->storeAs('orders', $imageName);
            $imageNames[] = $imageName; // Menyimpan nama gambar ke array
        }

        // Gabungkan nama gambar ke dalam satu string atau simpan sesuai kebutuhan
        $order->payment_proof = json_encode($imageNames); // Simpan sebagai JSON jika ingin menyimpan banyak gambar

        $order->save();

        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->quantity = $item->qty;
            $orderItem->total = $item->total;
            $orderItem->save();
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
