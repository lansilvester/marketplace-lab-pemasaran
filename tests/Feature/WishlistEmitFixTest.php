<?php

namespace Tests\Feature;

use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\WishlistComponent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WishlistEmitFixTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_add_to_wishlist_no_longer_calls_emit_to(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ShopComponent::class)
            ->call('addToWishlist', 1, 'Produk', 50000)
            ->assertOk();
    }

    public function test_wishlist_remove_no_longer_calls_emit_to(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(WishlistComponent::class)
            ->call('removeFromWishlist', 1)
            ->assertOk();
    }
}
