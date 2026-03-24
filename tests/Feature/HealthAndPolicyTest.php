<?php

namespace Tests\Feature;

use App\Models\DailyConsumption;
use App\Models\Ingredient;
use App\Models\Role;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthAndPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_live_is_public(): void
    {
        $this->getJson(route('health.live'))
            ->assertOk()
            ->assertJson(['status' => 'ok']);
    }

    public function test_cashier_cannot_access_stock_index(): void
    {
        $cashierRole = Role::create(['role' => 'user']);
        $cashier = User::factory()->create(['role_id' => $cashierRole->id]);

        $this->actingAs($cashier)
            ->get(route('stock.index'))
            ->assertForbidden();
    }

    public function test_cashier_cannot_delete_daily_consumption(): void
    {
        $cashierRole = Role::create(['role' => 'user']);
        $stockRole = Role::create(['role' => 'stockeeper']);
        $cashier = User::factory()->create(['role_id' => $cashierRole->id]);
        $stockUser = User::factory()->create(['role_id' => $stockRole->id]);

        $unit = Unit::create(['unit' => 'kg']);
        $ingredient = Ingredient::create(['ingredient' => 'Rice']);
        $stock = Stock::create([
            'ingredient_id' => $ingredient->id,
            'quantity' => 10,
            'total_price' => 100,
            'unit_id' => $unit->id,
            'unit_price' => 10,
            'user_id' => $stockUser->id,
        ]);

        $daily = new DailyConsumption();
        $daily->stock_id = $stock->id;
        $daily->quantity = 1;
        $daily->save();

        $this->actingAs($cashier)
            ->delete(route('dailyConsumption.destroy', $daily->id))
            ->assertForbidden();
    }

    public function test_stockeeper_can_access_stock_index(): void
    {
        $stockRole = Role::create(['role' => 'stockeeper']);
        $stockUser = User::factory()->create(['role_id' => $stockRole->id]);

        $this->actingAs($stockUser)
            ->get(route('stock.index'))
            ->assertOk();
    }

    public function test_cashier_cannot_access_daily_expense_index(): void
    {
        $cashierRole = Role::create(['role' => 'user']);
        $cashier = User::factory()->create(['role_id' => $cashierRole->id]);

        $this->actingAs($cashier)
            ->get(route('dailyExpense.index'))
            ->assertForbidden();
    }

    public function test_cashier_cannot_access_user_management_index(): void
    {
        $cashierRole = Role::create(['role' => 'user']);
        $cashier = User::factory()->create(['role_id' => $cashierRole->id]);

        $this->actingAs($cashier)
            ->get(route('management.index'))
            ->assertForbidden();
    }

    public function test_cashier_cannot_enable_or_disable_users(): void
    {
        $cashierRole = Role::create(['role' => 'user']);
        $cashier = User::factory()->create(['role_id' => $cashierRole->id]);
        $target = User::factory()->create(['role_id' => $cashierRole->id]);

        $this->actingAs($cashier)
            ->post(route('management.enableUser', $target->id))
            ->assertForbidden();

        $this->actingAs($cashier)
            ->post(route('management.disableUser', $target->id))
            ->assertForbidden();
    }
}

