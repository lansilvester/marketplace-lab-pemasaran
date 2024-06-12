<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class AdminAddProductComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $short_description;
    public $description;
    public $sale_price;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $category_id;
    public $user_id;
    public $images;


    public function mount(){
        $this->stock_status = 'instock';
        $this->featured = 0;
        $this->user_id = Auth::user()->id;
    }
    public function generateSlug(){
        $this->slug = Str::slug($this->name,'-');
    }
    public function update($fields){
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required|unique:products',
            'short_description' => 'required',
            'description' => 'required',
            'sale_price' => 'numeric',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png',
            'category_id'=>'required',
        ]);
    }
    public function addProduct(){
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:products',
            'short_description' => 'required',
            'description' => 'required',
            'sale_price' => 'numeric',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png',
            'category_id'=>'required',

        ]);
        $product = new Product();
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->sale_price = $this->sale_price;
        $product->stock_status = $this->stock_status;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;
        $imageName = Carbon::now()->timestamp. '.' .$this->image->extension();
        $this->image->storeAs('products', $imageName);
        $product->image = $imageName;
        if($this->images){
            $imagesname = '';
            foreach($this->images as $key=>$image){
                $imgName = Carbon::now()->timestamp. $key . '.' .$image->extension();
                $image->storeAs('products', $imgName);
                $imagesname = $imagesname. ','.$imgName;
            }
            $product->images = $imagesname;
        }
        $product->category_id = $this->category_id;
        $product->user_id = $this->user_id;
        $product->save();
        session()->flash('message', 'Product has been created');
    }
    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-add-product-component', [
            'categories'=>$categories
        ])->layout('layouts.base');
    }
}
