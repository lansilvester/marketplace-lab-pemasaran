<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Support\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    public $sorting;

    public $pagesize;

    public $category_slug;

    public function mount($category_slug)
    {
        $this->sorting = 'default';
        $this->pagesize = 12;
        $this->category_slug = $category_slug;
    }

    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
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
        $category = Category::where('slug', $this->category_slug)->first();

        if (! $category) {
            abort(404);
        }

        $category_id = $category->id;
        $category_name = $category->name;

        if ($this->sorting == 'date') {
            $products = Product::where('category_id', $category_id)->orderBy('created_at', 'DESC')->paginate($this->pagesize);
        } elseif ($this->sorting == 'price') {
            $products = Product::where('category_id', $category_id)->orderBy('sale_price', 'ASC')->paginate($this->pagesize);
        } elseif ($this->sorting == 'price-desc') {
            $products = Product::where('category_id', $category_id)->orderBy('sale_price', 'DESC')->paginate($this->pagesize);
        } else {
            $products = Product::where('category_id', $category_id)->paginate($this->pagesize);
        }
        // $products = Product::where('category_id', $category_id)->get();
        // $products = Product::paginate($this->pagesize);
        $categories = Category::all();
        if (Auth::check()) {
            Cart::instance('wishlist')->store(Auth::user()->email);
        }

        return view('livewire.category-component', [
            'products' => $products,
            'categories' => $categories,
            'category_name' => $category_name,
        ])->layout('layouts.base');
    }
}
