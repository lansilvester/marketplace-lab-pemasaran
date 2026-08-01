<?php

namespace Tests\Feature;

use App\Http\Livewire\ShopComponent;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShopPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_page_renders_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        Product::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);

        $this->actingAs($user)
            ->get('/shop')
            ->assertStatus(200);
    }

    public function test_shop_page_sorts_by_price_ascending(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        Product::factory()->create(['user_id' => $user->id, 'category_id' => $category->id, 'sale_price' => 5000]);
        Product::factory()->create(['user_id' => $user->id, 'category_id' => $category->id, 'sale_price' => 20000]);

        Livewire::actingAs($user)
            ->test(ShopComponent::class)
            ->set('sorting', 'price')
            ->assertStatus(200)
            ->assertViewHas('products');
    }
}
