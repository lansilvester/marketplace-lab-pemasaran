<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class AdminEditProductComponent extends Component
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
    public $images;
    public $category_id;
    public $newimage;
    public $newimages;
    public $product_id;

    public function mount($product_slug){
        $product = Product::where('slug', $product_slug)->first();
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->sale_price = $product->sale_price;
        $this->stock_status = $product->stock_status;
        $this->featured = $product->featured;
        $this->quantity = $product->quantity;
        $this->image = $product->image;
        $this->images = explode(",",$product->images);
        $this->category_id = $product->category_id;
        $this->newimage = $product->newimage;
        // $this->newimages = $product->newimages;
        $this->product_id = $product->id;

    }

    public function generateSlug(){
        $this->slug = Str::slug($this->name,'-');
    }
    public function updated($fields){
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'sale_price' => 'numeric',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'category_id'=>'required',
        ]);
        if($this->newimage){
            $this->validateOnly($fields,[
            'newimage' => 'required|mimes:jpeg,png',
            ]);
        }
    }
    public function updateProduct(){
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
            // 'slug' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($this->product_id)],
            'short_description' => 'required',
            'description' => 'required',
            'sale_price' => 'numeric',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'category_id'=>'required',
        ]);

        if($this->newimage){
            $this->validate([
            'newimage' => 'required|mimes:jpeg,png',
            ]);
        }
        $product = Product::find($this->product_id);

        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->sale_price = $this->sale_price;
        $product->stock_status = $this->stock_status;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;

        if($this->newimage){
            unlink('assets/images/products'.'/'.$product->image);
            $imageName = Carbon::now()->timestamp. '.' .$this->newimage->extension();
            $this->newimage->storeAs('products', $imageName);
            $product->image = $imageName;
        }

        if($this->newimages){
            if($product->images){
                $images = explode(",",$product->images);
                foreach($images as $image){
                    if($image){
                        unlink('assets/images/products'.'/'.$image);

                    }
                }
            }
            $imagesname = '';
            foreach($this->newimages as $key=>$image){
                $imgName = Carbon::now()->timestamp.$key.'.'.$image->extension();
                $image->storeAs('products', $imgName);
                $imagesname = $imagesname.','.$imgName;

            }
            $product->images = $imagesname;
            
        }

        $product->category_id = $this->category_id;
        $product->save();
        
        session()->flash('message', 'Product has been updated');
        redirect()->route('admin.editproduct', ['product_slug' => $product->slug]) ;
    }
    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-edit-product-component', [
            'categories'=>$categories
        ])->layout('layouts.base');
    }
}
