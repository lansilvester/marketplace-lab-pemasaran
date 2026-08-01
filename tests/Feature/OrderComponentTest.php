<?php

namespace Tests\Feature;

use App\Http\Livewire\OrderComponent;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OrderComponentTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrder(User $user): Order
    {
        return Order::create([
            'user_id' => $user->id,
            'total' => 50000,
            'status' => 'pending',
            'payment_proof' => json_encode(['first.jpg', 'second.jpg']),
        ]);
    }

    public function test_mount_loads_only_orders_belonging_to_authenticated_user(): void
    {
        $user = User::factory()->create(['email' => 'buyer@test.com']);
        $other = User::factory()->create(['email' => 'other@test.com']);

        $ownOrder = $this->makeOrder($user);
        $this->makeOrder($other);

        Livewire::actingAs($user)
            ->test(OrderComponent::class)
            ->assertSet('orders', function ($orders) use ($ownOrder) {
                return $orders->count() === 1
                    && $orders->contains('id', $ownOrder->id);
            });
    }

    public function test_payment_proof_is_decoded_in_mount(): void
    {
        $user = User::factory()->create(['email' => 'buyer@test.com']);
        $this->makeOrder($user);

        Livewire::actingAs($user)
            ->test(OrderComponent::class)
            ->assertSet('orders', function ($orders) {
                $proof = $orders->first()->payment_proof;

                return is_array($proof) && $proof === ['first.jpg', 'second.jpg'];
            });
    }

    public function test_show_order_details_loads_the_selected_order(): void
    {
        $user = User::factory()->create(['email' => 'buyer@test.com']);
        $order = $this->makeOrder($user);

        $component = Livewire::actingAs($user)
            ->test(OrderComponent::class);

        $component->call('showOrderDetails', $order->id);

        $this->assertSame($order->id, $component->instance()->selectedOrder->id);
    }
}
