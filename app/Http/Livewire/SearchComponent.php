<?php

namespace App\Http\Livewire;

use App\Models\Review;
use App\Models\Product;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Gloudemans\Shoppingcart\Facades\Cart;

class SearchComponent extends Component
{
    public $sorting; 
    public $pagesize; 
    public $search;
    public $product_cat;
    public $product_cat_id;

    public function mount(){
        $this->sorting = 'default';
        $this->pagesize= 12;
        $this->fill(request()->only('search', 'product_cat', 'product_cat_id'));
    }

    public function store($product_id, $product_name,$product_price){
        Cart::add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
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
        if($this->sorting == 'date'){
            $products = Product::where('name','like','%'.$this->search.'%')->where('category_id', 'like','%'.$this->product_cat_id.'%')->orderBy('created_at','DESC')->paginate($this->pagesize);
        }else if($this->sorting=='price'){
            $products = Product::where('name','like','%'.$this->search.'%')->where('category_id', 'like','%'.$this->product_cat_id.'%')->orderBy('sale_price','ASC')->paginate($this->pagesize);
        }else if($this->sorting=='price-desc'){
            $products = Product::where('name','like','%'.$this->search.'%')->where('category_id', 'like','%'.$this->product_cat_id.'%')->orderBy('price_desc','DESC')->paginate($this->pagesize);
        }else{
            $products = Product::where('name','like','%'.$this->search.'%')->where('category_id', 'like','%'.$this->product_cat_id.'%')->paginate($this->pagesize);
        }

        $popular_product = Review::select('product_id')->distinct('rating','product_id')->where('rating','>',3)->limit(3)->get();
        // $products = Product::paginate(12);
        $categories = Category::all();
        return view('livewire.search-component',[
            'search' => $this->search,
            'products'=>$products,
            'categories'=>$categories,
            'popular_product' => $popular_product
        ])->layout('layouts.base');
    }
}
