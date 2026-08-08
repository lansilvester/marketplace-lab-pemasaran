<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class AdminProductComponent extends Component
{
    use WithPagination;
    public function deleteProduct($id){
        $product = Product::find($id);
        if(!$product){
            return;
        }
        if(!in_array(Auth::user()->utype, ['ADM','OPT']) && $product->user_id !== Auth::id()){
            session()->flash('error_message', 'Anda tidak berhak menghapus produk ini.');
            return;
        }
        if($product->image && $product->image !== 'default-product.jpg'){
            $path = public_path('assets/images/products/'.$product->image);
            if(file_exists($path)){
                unlink($path);
            }
        }
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
        $product->delete();
        session()->flash('message', 'Product has been deleted');
    }

    public function render()
    {
        $products = Product::paginate(10);
        $my_products = Product::where('user_id', Auth::user()->id)->paginate(10);
        return view('livewire.admin.admin-product-component', [
            'products' => $products,
            'my_products' => $my_products
            ])->layout('layouts.base');
    }
}
