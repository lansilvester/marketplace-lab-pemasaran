<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_name = $this->faker->unique()->word($nb=2, $asText=true);
        $slug = Str::slug($product_name);
        
        return [
            // 'name' => $product_name,
            // 'slug' => $slug,
            // 'short_description' => $this->faker->text(200),
            // 'description' => $this->faker->text(500),
            // 'sale_price' => $this->faker->numberBetween(10,500),
            // 'stock_status' => 'instock',
            // 'quantity'=> $this->faker->numberBetween(100,200),
            // 'image' => 'digital_'.$this->faker->unique()->numberBetween(1,22).'.jpg',
            // 'category_id' => $this->faker->numberBetween(1,5),
            'name' => 'Product',
            'slug' => 'product',
            'short_description' => '',
            'description' => '',
            'sale_price' => 0,
            'stock_status' => 'outofstock',
            'quantity'=> 0,
            'image' => 'default-product.jpg',
            'images' => 'default-product.jpg',
            'category_id' => 1,
            'user_id' => 1,
        ];
    }
}
