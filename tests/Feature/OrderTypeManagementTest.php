<?php

namespace Tests\Feature;

use App\Models\OrderType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTypeManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_order_type_settings_and_add_a_type(): void
    {
        $role = Role::create(['role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($admin)
            ->get(route('orderType.index'))
            ->assertOk()
            ->assertSee('أنواع الطلبات')
            ->assertSee('إضافة نوع الطلب')
            ->assertSee('href="'.route('orderType.index').'"', false);

        $this->actingAs($admin)
            ->post(route('orderType.store'), ['name' => 'توصيل'])
            ->assertRedirect(route('orderType.index'));

        $this->assertDatabaseHas('order_types', ['name' => 'توصيل']);

        $this->get(route('orderType.index'))->assertSee('توصيل');
    }

    public function test_order_type_name_is_required_and_unique(): void
    {
        $role = Role::create(['role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);
        OrderType::create(['name' => 'سفري']);

        $this->actingAs($admin)
            ->from(route('orderType.index'))
            ->post(route('orderType.store'), ['name' => ''])
            ->assertRedirect(route('orderType.index'))
            ->assertSessionHasErrors('name');

        $this->post(route('orderType.store'), ['name' => 'سفري'])
            ->assertRedirect(route('orderType.index'))
            ->assertSessionHasErrors('name');

        $this->assertSame(1, OrderType::where('name', 'سفري')->count());
    }

    public function test_non_admin_cannot_manage_order_types(): void
    {
        $role = Role::create(['role' => 'user']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($user)
            ->get(route('orderType.index'))
            ->assertForbidden();
    }
}
