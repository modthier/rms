<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_orders_index(): void
    {
        $response = $this->get(route('order.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_home(): void
    {
        $role = Role::create(['role' => 'user']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertRedirect();
    }

    public function test_cashier_cannot_view_another_cashier_order_details(): void
    {
        $role = Role::create(['role' => 'user']);
        $owner = User::factory()->create(['role_id' => $role->id]);
        $otherCashier = User::factory()->create(['role_id' => $role->id]);
        $order = Order::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($otherCashier)->get(route('cashier.showSales', $order->id));

        $response->assertForbidden();
    }

    public function test_cashier_cannot_cancel_another_cashier_order(): void
    {
        $role = Role::create(['role' => 'user']);
        $owner = User::factory()->create(['role_id' => $role->id]);
        $otherCashier = User::factory()->create(['role_id' => $role->id]);
        $order = Order::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($otherCashier)->put(route('order.cancelOrder', $order->id));

        $response->assertForbidden();
    }
}
