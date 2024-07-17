<?php

namespace App\Http\Livewire;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

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

    public function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371; // Radius bumi dalam kilometer

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // Jarak dalam kilometer

        return $distance;
    }

    public function render()
    {

        $user = Auth::user();
        $userLatitude = $user->profile->latitude;
        $userLongitude = $user->profile->longitude;

        if($this->sorting == 'date'){
            $products = Product::where('name','like','%'.$this->search.'%')
            ->where('category_id', 'like','%'.$this->product_cat_id.'%')
            ->orderBy('created_at','DESC')
            ->get();
        }else if($this->sorting=='price'){
            $products = Product::where('name','like','%'.$this->search.'%')
            ->where('category_id', 'like','%'.$this->product_cat_id.'%')
            ->orderBy('sale_price','ASC')
            ->get();
        }else if($this->sorting=='price-desc'){
            $products = Product::where('name','like','%'.$this->search.'%')
            ->where('category_id', 'like','%'.$this->product_cat_id.'%')
            ->orderBy('price_desc','DESC')
            ->get();
        }else{
            $products = Product::where('name','like','%'.$this->search.'%')
            ->where('category_id', 'like','%'.$this->product_cat_id.'%')
            ->get();
        }

        $popular_product = Review::select('product_id')->distinct('rating','product_id')->where('rating','>',3)->limit(3)->get();


                // Menghitung jarak dari pengguna ke setiap produk
        foreach ($products as $product) {
            $productLatitude = $product->user->profile->latitude; // Ganti dengan atribut latitude penjual
            $productLongitude = $product->user->profile->longitude; // Ganti dengan atribut longitude penjual

            $distance = $this->calculateDistance($userLatitude, $userLongitude, $productLatitude, $productLongitude);

            $product->distance = $distance; // Menambahkan atribut jarak ke objek produk
        }

        // Urutkan produk berdasarkan jarak terdekat
        $products = $products->sortBy('distance');

        $categories = Category::all();
        return view('livewire.search-component',[
            'search' => $this->search,
            'products'=>$products,
            'categories'=>$categories,
            'popular_product' => $popular_product,
            'lat' => $userLatitude,
            'long' => $userLongitude,
        ])->layout('layouts.base');
    }
}
