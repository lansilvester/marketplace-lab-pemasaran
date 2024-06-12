<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

use App\Models\Category;
use App\Models\Review;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShopComponent extends Component
{
    public $sorting; 
    public $pagesize; 

    public function mount(){
        $this->sorting = "default";
        $this->pagesize = 12;
    }

    public function store($product_id, $product_name,$product_price){
        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item Added in Cart');
        return redirect()->route('product.cart');
    }

    public function addToWishlist($product_id, $product_name,$product_price){
        Cart::instance('wishlist')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        $this->emitTo('wishlist-count-component', 'refreshComponent');
        
    }
    
    public function removeFromWishlist($product_id){
        foreach(Cart::instance('wishlist')->content() as $witem){
            if($witem->id == $product_id){
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('wishlist-count-component', 'refreshComponent');
                return;
            }
        }
    }

    use WithPagination;
    public function render()
    {
        if($this->sorting == "date"){
            $products = DB::table('products')
                            ->orderBy('created_at','DESC')
                            ->paginate($this->pagesize);
            $products = Product::orderBy('created_at','DESC')->paginate($this->pagesize);
        }
        else if($this->sorting == "price"){
            $products = Product::orderBy('sale_price','ASC')->paginate($this->pagesize);
        }
        else if($this->sorting == "price-desc"){
            $products = Product::orderBy('sale_price','DESC')->paginate($this->pagesize);
        }
        else{
            $products = Product::paginate($this->pagesize);
        }
        $categories = Category::all();
        
        if(Auth::check()){
            Cart::instance('wishlist')->store(Auth::user()->email);
        }
        $product_populer = Review::select('product_id')->distinct('rating','product_id')->where('rating','>',3)->limit(3)->get();
        
        return view('livewire.shop-component',[
            'products'=>$products,
            'categories'=>$categories,
            'product_populer' => $product_populer
        ])->layout('layouts.base');
    }
}
