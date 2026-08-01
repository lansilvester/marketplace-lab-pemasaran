<?php

namespace Tests\Unit;

use App\Support\Cart;
use Tests\TestCase;

class CartTest extends TestCase
{
    public function test_add_item_to_cart(): void
    {
        session()->flush();

        Cart::instance('cart')->add(1, 'Product A', 1, 10000);

        $this->assertSame(1, Cart::instance('cart')->count());
        $this->assertCount(1, Cart::instance('cart')->content());
    }

    public function test_adding_same_item_increments_quantity(): void
    {
        session()->flush();

        Cart::instance('cart')->add(1, 'Product A', 1, 10000);
        Cart::instance('cart')->add(1, 'Product A', 1, 10000);

        $this->assertSame(2, Cart::instance('cart')->count());
        $this->assertSame(2, Cart::instance('cart')->content()->first()->qty);
    }

    public function test_update_quantity_of_item(): void
    {
        session()->flush();

        $item = Cart::instance('cart')->add(1, 'Product A', 1, 10000);
        Cart::instance('cart')->update($item->rowId, 5);

        $this->assertSame(5, Cart::instance('cart')->content()->first()->qty);
    }

    public function test_update_to_zero_removes_item(): void
    {
        session()->flush();

        $item = Cart::instance('cart')->add(1, 'Product A', 1, 10000);
        Cart::instance('cart')->update($item->rowId, 0);

        $this->assertSame(0, Cart::instance('cart')->count());
    }

    public function test_remove_item_from_cart(): void
    {
        session()->flush();

        $item = Cart::instance('cart')->add(1, 'Product A', 1, 10000);
        Cart::instance('cart')->remove($item->rowId);

        $this->assertSame(0, Cart::instance('cart')->count());
    }

    public function test_destroy_empties_the_cart(): void
    {
        session()->flush();

        Cart::instance('cart')->add(1, 'Product A', 1, 10000);
        Cart::instance('cart')->add(2, 'Product B', 2, 5000);
        Cart::instance('cart')->destroy();

        $this->assertSame(0, Cart::instance('cart')->count());
    }

    public function test_subtotal_and_total_are_calculated_correctly(): void
    {
        session()->flush();

        Cart::instance('cart')->add(1, 'Product A', 2, 10000);
        Cart::instance('cart')->add(2, 'Product B', 1, 5000);

        // 2 * 10000 + 1 * 5000 = 25000
        $this->assertSame('25,000.00', Cart::instance('cart')->subtotal());
        $this->assertSame('25,000.00', Cart::instance('cart')->total());
    }

    public function test_cart_item_exposes_total_and_subtotal(): void
    {
        session()->flush();

        $item = Cart::instance('cart')->add(1, 'Product A', 3, 10000);

        $this->assertEquals(30000, $item->total);
        $this->assertEquals(30000, $item->subtotal);
    }

    public function test_store_and_restore_cart_for_user(): void
    {
        session()->flush();

        Cart::instance('cart')->add(1, 'Product A', 1, 10000);
        Cart::instance('cart')->store('user@example.com');
        Cart::instance('cart')->destroy();

        $this->assertSame(0, Cart::instance('cart')->count());

        Cart::instance('cart')->restore('user@example.com');
        $this->assertSame(1, Cart::instance('cart')->count());
        $this->assertSame('Product A', Cart::instance('cart')->content()->first()->name);
    }

    public function test_different_instances_are_isolated(): void
    {
        session()->flush();

        Cart::instance('cart')->add(1, 'Product A', 1, 10000);
        Cart::instance('wishlist')->add(1, 'Product A', 1, 10000);

        $this->assertSame(1, Cart::instance('cart')->count());
        $this->assertSame(1, Cart::instance('wishlist')->count());

        Cart::instance('cart')->destroy();

        $this->assertSame(0, Cart::instance('cart')->count());
        $this->assertSame(1, Cart::instance('wishlist')->count());
    }
}
