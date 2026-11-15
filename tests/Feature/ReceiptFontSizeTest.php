<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\OrderType;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceiptFontSizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_save_receipt_font_size(): void
    {
        $role = Role::create(['role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);
        $setting = Setting::create([
            'name' => 'Restaurant',
            'receipt_mode' => Setting::RECEIPT_MODE_DUAL,
        ]);

        $this->actingAs($admin)
            ->put(route('setting.update', $setting), [
                'name' => $setting->name,
                'receipt_mode' => Setting::RECEIPT_MODE_DUAL,
                'receipt_font_size' => 20,
            ])
            ->assertRedirect(route('setting.index'));

        $this->assertDatabaseHas('settings', [
            'id' => $setting->id,
            'receipt_font_size' => 20,
        ]);
    }

    public function test_receipt_font_size_must_be_within_the_supported_range(): void
    {
        $role = Role::create(['role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);
        $setting = Setting::create([
            'name' => 'Restaurant',
            'receipt_mode' => Setting::RECEIPT_MODE_DUAL,
        ]);

        $this->actingAs($admin)
            ->from(route('setting.edit', $setting))
            ->put(route('setting.update', $setting), [
                'name' => $setting->name,
                'receipt_mode' => Setting::RECEIPT_MODE_DUAL,
                'receipt_font_size' => 25,
            ])
            ->assertRedirect(route('setting.edit', $setting))
            ->assertSessionHasErrors('receipt_font_size');

        $this->assertDatabaseHas('settings', [
            'id' => $setting->id,
            'receipt_font_size' => Setting::DEFAULT_RECEIPT_FONT_SIZE,
        ]);
    }

    public function test_setting_forms_show_the_saved_size_and_live_preview(): void
    {
        $role = Role::create(['role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);
        $setting = Setting::create([
            'name' => 'Restaurant',
            'receipt_mode' => Setting::RECEIPT_MODE_DUAL,
            'receipt_font_size' => 19,
        ]);

        $this->actingAs($admin)
            ->get(route('setting.edit', $setting))
            ->assertOk()
            ->assertSee('name="receipt_font_size"', false)
            ->assertSee('value="19"', false)
            ->assertSee('id="receipt-size-preview"', false);

        $this->get(route('setting.index'))
            ->assertOk()
            ->assertSee('id="receipt-size-preview"', false)
            ->assertSee('value="16"', false);
    }

    public function test_pos_receipt_uses_the_configured_font_size(): void
    {
        $role = Role::create(['role' => 'user']);
        $cashier = User::factory()->create(['role_id' => $role->id]);
        Setting::create([
            'name' => 'Restaurant',
            'receipt_mode' => Setting::RECEIPT_MODE_DUAL,
            'receipt_font_size' => 18,
        ]);
        Setting::clearCache();
        $item = Item::create(['name' => 'Coffee', 'price' => 2.50]);
        $payment = Payment::create(['method' => 'Cash']);
        $orderType = OrderType::create(['name' => 'Takeaway']);

        $response = $this->actingAs($cashier)->post(route('cashier.store'), [
            'items' => [$item->id => ['quantity' => 2]],
            'price'.$item->id => '5.00',
            'total' => '5.00',
            'payment_id' => $payment->id,
            'order_type_id' => $orderType->id,
        ]);

        $response->assertOk()
            ->assertSee('style="--receipt-font-size: 18px"', false);
    }
}
