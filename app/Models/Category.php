<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $guarded = "id";
    
    public function product(){
        // return $this->belongsTo(Category::class, 'category_id');
        return $this->hasMany(Product::class);
    }
}