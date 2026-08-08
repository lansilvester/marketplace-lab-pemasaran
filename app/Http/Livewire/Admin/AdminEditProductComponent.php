<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
        abort_unless($product, 404);
        if(!in_array(Auth::user()->utype, ['ADM','OPT']) && $product->user_id !== Auth::id()){
            abort(403);
        }
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
        abort_unless($product, 404);
        if(!in_array(Auth::user()->utype, ['ADM','OPT']) && $product->user_id !== Auth::id()){
            abort(403);
        }

        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->sale_price = $this->sale_price;
        $product->stock_status = $this->stock_status;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;

        if($this->newimage){
            if($product->image && $product->image !== 'default-product.jpg'){
                $path = public_path('assets/images/products/'.$product->image);
                if(file_exists($path)){
                    unlink($path);
                }
            }
            $imageName = Carbon::now()->timestamp.uniqid().'.'.$this->newimage->extension();
            $this->newimage->storeAs('products', $imageName);
            $product->image = $imageName;
        }

        if($this->newimages){
            if($product->images){
                $images = explode(",",$product->images);
                foreach($images as $image){
                    if($image && $image !== 'default-product.jpg'){
                        $path = public_path('assets/images/products/'.$image);
                        if(file_exists($path)){
                            unlink($path);
                        }
                    }
                }
            }
            $imagesname = '';
            foreach($this->newimages as $key=>$image){
                $imgName = Carbon::now()->timestamp.$key.uniqid().'.'.$image->extension();
                $image->storeAs('products', $imgName);
                $imagesname = $imagesname === '' ? $imgName : $imagesname.','.$imgName;
            }
            $product->images = $imagesname;
        }

        $product->category_id = $this->category_id;
        $product->save();

        session()->flash('message', 'Product has been updated');
        return redirect()->route('admin.editproduct', ['product_slug' => $product->slug]);
    }
    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-edit-product-component', [
            'categories'=>$categories
        ])->layout('layouts.base');
    }
}
