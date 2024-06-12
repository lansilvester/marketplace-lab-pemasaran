<?php

namespace App\Http\Livewire;

use App\Models\Review;
use App\Models\Product;
use App\Models\Profile;
use Livewire\Component;
use App\Models\Category;
use App\Models\HomeSlider;
use App\Models\HomeCategory;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class HomeComponent extends Component
{
    public function render()
    {
        if(Auth::check()){
            Cart::instance('wishlist')->restore(Auth::user()->email);
            $userProfile = Profile::where('user_id', Auth::user()->id)->first();
            if(!$userProfile){
                $profile = new Profile();
                $profile->user_id = Auth::user()->id;
                $profile->save();
            }
        }
        $sliders = HomeSlider::where('status', 1)->get();
        $lproducts = Product::orderBy('created_at','DESC')->get()->take(8);
        $category = HomeCategory::find(1);
        
        if ($category !== null) {
            $cats = explode(',',$category->sel_categories);
            $categories = Category::whereIn('id', $cats)->get();
            $no_of_products = $category->no_of_products;
        } else {
            $cats = [];
            $categories = [];
            $no_of_products = 0;
        }

        $categories = Category::whereIn('id', $cats)->get();
        $product_populer = Review::select('product_id')->distinct()->where('rating','>',3)->limit(4)->get();
        
        if(Auth::check()){
            $userProfile = Profile::where('user_id', Auth::user()->id)->first();
            if(!$userProfile){
                $profile = new Profile();
                $profile->user_id = Auth::user()->id;
                $profile->save();
            }
        }

        $no_of_products = $category->no_of_products;
        return view('livewire.home-component',[
            'sliders'=>$sliders,
            'lproducts' => $lproducts,
            'categories' => $categories,
            'no_of_products' => $no_of_products,
            'product_populer' => $product_populer
        ])->layout('layouts.base');
    }
}
