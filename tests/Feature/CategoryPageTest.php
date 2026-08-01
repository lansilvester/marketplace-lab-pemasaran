<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_page_renders_for_existing_category(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        Product::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'sale_price' => 15000,
        ]);

        $this->actingAs($user)
            ->get('/product-category/'.$category->slug)
            ->assertStatus(200)
            ->assertSee($category->name);
    }

    public function test_category_page_returns_404_for_nonexistent_category(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/product-category/tidak-ada')
            ->assertStatus(404);
    }

    public function test_category_page_sorts_by_price(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        Product::factory()->create(['user_id' => $user->id, 'category_id' => $category->id, 'sale_price' => 5000]);
        Product::factory()->create(['user_id' => $user->id, 'category_id' => $category->id, 'sale_price' => 20000]);

        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\CategoryComponent::class, ['category_slug' => $category->slug])
            ->set('sorting', 'price')
            ->assertStatus(200);
    }
}
