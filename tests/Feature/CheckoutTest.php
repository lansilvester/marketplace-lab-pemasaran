<?php

namespace Tests\Feature;

use App\Http\Livewire\CheckoutComponent;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Support\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function makeCartUser(): array
    {
        $user = User::factory()->create();
        $seller = User::factory()->create(['email' => 'seller@example.com']);
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $seller->id,
            'category_id' => $category->id,
            'sale_price' => 10000,
            'quantity' => 50,
        ]);

        return [$user, $seller, $product];
    }

    public function test_checkout_creates_order_with_correct_totals(): void
    {
        [$user, $seller, $product] = $this->makeCartUser();

        Cart::instance('cart')->add($product->id, $product->name, 3, $product->sale_price);

        Livewire::actingAs($user)
            ->test(CheckoutComponent::class)
            ->set('images', [UploadedFile::fake()->image('bukti-transfer.jpg')])
            ->call('checkout')
            ->assertRedirect(route('product.order'));

        $order = Order::first();

        $this->assertNotNull($order);
        $this->assertSame($user->id, $order->user_id);
        $this->assertSame($seller->id, $order->seller_id);
        $this->assertSame(30000, $order->total);

        $orderItem = $order->items->first();
        $this->assertSame($product->id, $orderItem->product_id);
        $this->assertSame(3, $orderItem->quantity);
        $this->assertSame(30000, $orderItem->total);
    }

    public function test_checkout_cannot_be_done_with_empty_cart(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CheckoutComponent::class)
            ->set('images', [UploadedFile::fake()->image('bukti-transfer.jpg')])
            ->call('checkout')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
    }

    public function test_checkout_requires_payment_proof_upload(): void
    {
        [$user, $seller, $product] = $this->makeCartUser();

        Cart::instance('cart')->add($product->id, $product->name, 1, $product->sale_price);

        Livewire::actingAs($user)
            ->test(CheckoutComponent::class)
            ->call('checkout')
            ->assertHasErrors(['images']);

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_checkout_clears_the_cart(): void
    {
        [$user, $seller, $product] = $this->makeCartUser();

        Cart::instance('cart')->add($product->id, $product->name, 1, $product->sale_price);

        Livewire::actingAs($user)
            ->test(CheckoutComponent::class)
            ->set('images', [UploadedFile::fake()->image('bukti-transfer.jpg')])
            ->call('checkout');

        $this->assertSame(0, Cart::instance('cart')->count());
    }
}
