<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Support\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PenjualComponent extends Component
{
    public $sorting;

    public $pagesize;

    public $penjual;

    public function mount($penjual)
    {
        $this->penjual = $penjual;
        $this->sorting = 'default';
        $this->pagesize = 12;
    }

    public function store($product_id, $product_name, $product_price)
    {
        Cart::instance('cart')->add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item Added in Cart');

        return redirect()->route('product.cart');
    }

    public function addToWishlist($product_id, $product_name, $product_price)
    {
        Cart::instance('wishlist')->add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        $this->dispatch('refreshComponent')->to('wishlist-count-component');
    }

    public function removeFromWishlist($product_id)
    {
        foreach (Cart::instance('wishlist')->content() as $witem) {
            if ($witem->id == $product_id) {
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->dispatch('refreshComponent')->to('wishlist-count-component');

                return;
            }
        }
    }

    use WithPagination;

    public function render()
    {
        if ($this->sorting == 'date') {
            $products = DB::table('products')
                ->where('user_id', $this->penjual)
                ->orderBy('created_at', 'DESC')
                ->paginate($this->pagesize);
        } elseif ($this->sorting == 'price') {
            $products = Product::orderBy('sale_price', 'ASC')
                ->paginate($this->pagesize);
        } elseif ($this->sorting == 'price-desc') {
            $products = Product::orderBy('sale_price', 'DESC')->
                                paginate($this->pagesize);
        } else {
            $products = Product::where('user_id', $this->penjual)->paginate($this->pagesize);
        }
        $categories = Category::all();

        $penjual = Product::where('user_id', $this->penjual)->get();
        $popular_products = Review::select('product_id')->distinct('rating', 'product_id')->where('rating', '>', 3)->limit(3)->get();

        if (Auth::check()) {
            Cart::instance('wishlist')->store(Auth::user()->email);
        }

        return view('livewire.penjual-component', [
            'penjual' => $penjual,
            'popular_products' => $popular_products,
            'products' => $products,
            'categories' => $categories,
        ])->layout('layouts.base');
    }
}
