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

class QzPrinterTest extends TestCase
{
    use RefreshDatabase;

    public function test_qz_signing_endpoint_signs_requests_with_the_configured_private_key(): void
    {
        $key = openssl_pkey_new([
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'private_key_bits' => 2048,
        ]);
        $this->assertNotFalse($key);
        $this->assertTrue(openssl_pkey_export($key, $privateKey));
        $keyDetails = openssl_pkey_get_details($key);
        $privateKeyPath = tempnam(sys_get_temp_dir(), 'rms-qz-key-');
        file_put_contents($privateKeyPath, $privateKey);
        config(['qz.private_key_path' => $privateKeyPath]);

        try {
            $role = Role::create(['role' => 'user']);
            $user = User::factory()->create(['role_id' => $role->id]);
            $data = '{"printer":"Kitchen","action":"print"}';

            $response = $this->actingAs($user)
                ->postJson(route('qz.signature'), ['data' => $data])
                ->assertOk()
                ->assertJsonStructure(['signature']);

            $signature = base64_decode($response->json('signature'), true);
            $this->assertNotFalse($signature);
            $this->assertSame(
                1,
                openssl_verify($data, $signature, $keyDetails['key'], OPENSSL_ALGO_SHA512)
            );
        } finally {
            unlink($privateKeyPath);
            openssl_pkey_free($key);
        }
    }

    public function test_qz_certificate_endpoint_reports_missing_server_configuration(): void
    {
        $role = Role::create(['role' => 'user']);
        $user = User::factory()->create(['role_id' => $role->id]);
        config(['qz.certificate_path' => null]);

        $this->actingAs($user)
            ->getJson(route('qz.certificate'))
            ->assertStatus(503)
            ->assertJsonPath('message', 'QZ Tray signing certificate is not configured on the server.');
    }

    public function test_admin_can_save_receipt_printer_names(): void
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
                'customer_printer' => 'Customer Receipt',
                'kitchen_printer' => 'Kitchen Receipt',
            ])
            ->assertRedirect(route('setting.index'));

        $this->assertDatabaseHas('settings', [
            'id' => $setting->id,
            'customer_printer' => 'Customer Receipt',
            'kitchen_printer' => 'Kitchen Receipt',
        ]);
    }

    public function test_pos_receipt_markup_includes_configured_printers_and_receipt_targets(): void
    {
        $role = Role::create(['role' => 'user']);
        $cashier = User::factory()->create(['role_id' => $role->id]);
        Setting::create([
            'name' => 'Restaurant',
            'receipt_mode' => Setting::RECEIPT_MODE_DUAL,
            'customer_printer' => 'Customer Receipt',
            'kitchen_printer' => 'Kitchen Receipt',
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
            ->assertSee('data-customer-printer="Customer Receipt"', false)
            ->assertSee('data-kitchen-printer="Kitchen Receipt"', false)
            ->assertSee('class="qz-receipt-client"', false)
            ->assertSee('class="qz-receipt-kitchen"', false);
    }
}
