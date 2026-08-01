<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\TransaksiComponent;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TransaksiComponentTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrder(User $seller): Order
    {
        $buyer = User::factory()->create(['email' => uniqid().'@test.com']);

        return Order::create([
            'user_id' => $buyer->id,
            'seller_id' => $seller->id,
            'total' => 25000,
            'status' => 'pending',
            'payment_proof' => json_encode(['proof.jpg']),
        ]);
    }

    public function test_mount_loads_only_orders_for_the_current_seller(): void
    {
        $seller = User::factory()->create(['email' => 'seller@test.com', 'utype' => 'PNJ']);
        $otherSeller = User::factory()->create(['email' => 'other-seller@test.com', 'utype' => 'PNJ']);

        $ownOrder = $this->makeOrder($seller);
        $this->makeOrder($otherSeller);

        Livewire::actingAs($seller)
            ->test(TransaksiComponent::class)
            ->assertSet('transactions', function ($transactions) use ($ownOrder) {
                return $transactions->count() === 1
                    && $transactions->first()->id === $ownOrder->id;
            });
    }

    public function test_update_status_changes_order_status_in_database(): void
    {
        $seller = User::factory()->create(['email' => 'seller@test.com', 'utype' => 'PNJ']);
        $order = $this->makeOrder($seller);

        Livewire::actingAs($seller)
            ->test(TransaksiComponent::class)
            ->call('updateStatus', $order->id, 'approved');

        $this->assertSame('approved', $order->fresh()->status);
    }

    public function test_update_status_changes_status_in_loaded_collection(): void
    {
        $seller = User::factory()->create(['email' => 'seller@test.com', 'utype' => 'PNJ']);
        $order = $this->makeOrder($seller);

        Livewire::actingAs($seller)
            ->test(TransaksiComponent::class)
            ->call('updateStatus', $order->id, 'rejected')
            ->assertSet('transactions', function ($transactions) {
                return $transactions->first()->status === 'rejected';
            });
    }
}
