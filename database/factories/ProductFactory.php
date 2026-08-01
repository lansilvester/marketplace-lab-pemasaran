<?php

namespace Database\Factories;

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
        $product_name = $this->faker->unique()->words(2, true);
        $slug = Str::slug($product_name);

        return [
            'name' => $product_name,
            'slug' => $slug,
            'short_description' => $this->faker->sentence(10),
            'description' => $this->faker->paragraph(2),
            'sale_price' => $this->faker->numberBetween(10000, 500000),
            'stock_status' => 'instock',
            'quantity' => $this->faker->numberBetween(10, 100),
            'image' => 'default-product.jpg',
            'images' => 'default-product.jpg',
            'category_id' => 1,
            'user_id' => 1,
        ];
    }
}
