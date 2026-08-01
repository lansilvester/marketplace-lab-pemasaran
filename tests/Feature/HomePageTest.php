<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\HomeCategory;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_without_data(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('POLIMDO');
    }

    public function test_homepage_renders_when_home_categories_is_missing(): void
    {
        User::factory()->create();
        Category::factory()->create();
        Product::factory()->create();

        $this->assertDatabaseCount('home_categories', 0);

        $this->get('/')
            ->assertStatus(200);
    }

    public function test_homepage_displays_seeded_home_category(): void
    {
        $user = User::factory()->create(['email' => 'homepage@test.com']);
        $category = Category::factory()->create();
        Product::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);
        HomeCategory::factory()->create(['sel_categories' => (string) $category->id]);
        HomeSlider::factory()->create();

        $this->get('/')
            ->assertStatus(200)
            ->assertSee($category->name);
    }

    public function test_homepage_creates_missing_profile_for_authenticated_user(): void
    {
        $user = User::factory()->create(['email' => 'profileless@test.com']);

        $this->assertDatabaseMissing('profiles', ['user_id' => $user->id]);

        $this->actingAs($user)
            ->get('/')
            ->assertStatus(200);

        $this->assertDatabaseHas('profiles', ['user_id' => $user->id]);
    }
}
