<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartComponent extends Component
{
    public $groupedItems;
    public $sellers;

    public function increaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;

        // Cek stok produk
        $productModel = Product::find($product->id);
        if ($qty > $productModel->quantity) {
            session()->flash('error_message', 'Jumlah barang melebihi stok yang tersedia');
            return;
        }

        Cart::instance('cart')->update($rowId, $qty);
        $this->emitTo('cart-count-component', 'refreshComponent');
    }
    // Fungsi untuk mengurangi 1 item cart - button
    public function decreaseQuantity($rowId){
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty-1;
        Cart::instance('cart')->update($rowId, $qty);
        $this->emitTo('cart-count-component', 'refreshComponent');
    }

    public function destroy($rowId){
        Cart::instance('cart')->remove($rowId);
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('success_message', 'Item has been removed');

    }
    public function destroyAll(){
        Cart::instance('cart')->destroy();
        $this->emitTo('cart-count-component', 'refreshComponent');
    }
    public function switchToSaveForLater($rowId){
        $item = Cart::instance('cart')->get($rowId);
        Cart::instance('cart')->remove($rowId);
        Cart::instance('saveForLater')->add($item->id, $item->name,1,$item->price)->associate('App\Models\Product');
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('success', 'Item telah di save');
    }
    public function mount()
    {
    // Mengelompokkan item berdasarkan penjual
    $this->groupedItems = Cart::instance('cart')->content()->groupBy(function ($item) {
        return $item->model->user_id;
    });

    // Mendapatkan informasi penjual
    $sellerIds = $this->groupedItems->keys();
    $this->sellers = User::whereIn('id', $sellerIds)->get()->keyBy('id');
    }

    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
