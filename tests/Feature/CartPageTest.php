<?php

namespace Tests\Feature;

use App\Http\Livewire\CartComponent;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Support\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CartPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_page_renders_with_items_in_cart(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $seller = User::factory()->create(['email' => 'seller@test.com']);
        $product = Product::factory()->create(['category_id' => $category->id, 'user_id' => $seller->id]);

        Cart::instance('cart')->add($product->id, $product->name, 1, 50000)->associate(Product::class);

        $response = Livewire::actingAs($user)
            ->test(CartComponent::class)
            ->assertOk();

        $this->assertNotNull($response);
    }

    public function test_cart_page_http_get_renders(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $seller = User::factory()->create(['email' => 'seller2@test.com']);
        $product = Product::factory()->create(['category_id' => $category->id, 'user_id' => $seller->id]);

        Cart::instance('cart')->add($product->id, $product->name, 1, 50000)->associate(Product::class);

        $response = $this->actingAs($user)->get(route('product.cart'));
        $response->assertOk();
    }
}
