<?php

namespace App\Http\Livewire;

use App\Models\Review;
use App\Models\Product;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Share;

class DetailsComponent extends Component
{
    public $slug;
    public $qty;
    public function mount($slug){
        $this->slug = $slug;
        $this->qty = 1;
    }

    public function store($product_id, $product_name, $product_price){
        Cart::instance('wishlist')->add($product_id,$product_name, $this->qty,$product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item ditambahkan ke wishlist');
        return redirect()->route('product.wishlist');
    }
    public function increaseQuantity(){
        $this->qty++;
    }
    public function decreseQuantity(){
        if($this->qty > 1){
            $this->qty--;
        }
    }
    public function addToWishlist($product_id, $product_name,$product_price){
        Cart::instance('wishlist')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        $this->emitTo('wishlist-count-component', 'refreshComponent');
        session()->flash('success_message', 'Item '.$product_name.' ditambah ke wishlist');
        return redirect()->route('product.wishlist');

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
    public function render()
    {
        // mengambil data dari model Product
        $product = Product::where('slug', $this->slug)->first();
        // $popular_products = Product::inRandomOrder()->limit(4)->get();
        $popular_products = Review::select('product_id')->distinct('rating','product_id')->where('rating','>',3)->limit(3)->get();
        $related_products = Product::where('category_id', $product->category_id)->inRandomOrder()->limit(5)->get();
        $reviews = Review::all();
        
        if(Auth::check()){
            Cart::instance('wishlist')->store(Auth::user()->email);
        }
        // Data di passing ke view details component
        $share = Share::page(route('product.details',['slug'=>$product->slug]),$product->name)
                ->facebook()
                ->twitter()
                ->whatsapp()->getRawLinks();
        return view('livewire.details-component',
        [
            'product'=>$product,
            'popular_products'=> $popular_products,
            'related_products'=> $related_products,
            'share'=>$share,
            'reviews' => $reviews
        ]
        )->layout('layouts.base');
    }
}
