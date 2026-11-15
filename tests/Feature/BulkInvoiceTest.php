<?php

namespace Tests\Feature;

use App\Models\BulkInvoice;
use App\Models\Company;
use App\Models\Item;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulkInvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_cashier_can_create_and_manage_company_records(): void
    {
        $cashier = $this->createUserWithRole('user');

        $this->actingAs($cashier)->get(route('companies.create'))->assertOk();

        $response = $this->actingAs($cashier)->post(route('companies.store'), [
            'name' => 'Acme Group',
            'contact_name' => 'Sam Example',
            'email' => 'accounts@example.test',
            'phone' => '123456789',
            'tax_number' => 'TAX-123',
            'address' => 'Main Street',
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'name' => 'Acme Group',
            'email' => 'accounts@example.test',
        ]);

        $company = Company::firstOrFail();
        $this->actingAs($cashier)->get(route('companies.index'))->assertOk();
        $this->actingAs($cashier)->get(route('companies.edit', $company))->assertOk();
        $this->actingAs($cashier)->put(route('companies.update', $company), [
            'name' => 'Acme Corporation',
            'email' => 'accounts@example.test',
        ])->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', ['id' => $company->id, 'name' => 'Acme Corporation']);
    }

    public function test_invoice_total_is_calculated_and_partial_payments_are_tracked(): void
    {
        $cashier = $this->createUserWithRole('user');
        $company = Company::create(['name' => 'Acme Group']);
        $item = Item::create(['name' => 'Coffee', 'price' => 2.50]);

        $this->actingAs($cashier)->get(route('bulkInvoices.create'))->assertOk();

        $response = $this->actingAs($cashier)->post(route('bulkInvoices.store'), [
            'company_id' => $company->id,
            'issued_on' => '2026-10-31',
            'items' => [
                ['item_id' => $item->id, 'quantity' => 4, 'unit_price' => '3.25'],
            ],
        ]);

        $invoice = BulkInvoice::firstOrFail();
        $response->assertRedirect(route('bulkInvoices.show', $invoice));
        $this->assertSame('13.00', $invoice->total);
        $this->assertSame('BULK-'.str_pad((string) $invoice->id, 6, '0', STR_PAD_LEFT), $invoice->invoice_number);
        $this->assertDatabaseHas('bulk_invoice_items', [
            'bulk_invoice_id' => $invoice->id,
            'item_name' => 'Coffee',
            'quantity' => 4,
            'unit_price' => '3.25',
            'line_total' => '13.00',
        ]);

        $this->actingAs($cashier)->post(route('bulkInvoices.payments.store', $invoice), [
            'amount' => '5.00',
            'paid_on' => '2026-10-31',
            'payment_method' => 'Bank transfer',
        ])->assertRedirect(route('bulkInvoices.show', $invoice));

        $invoice->refresh();
        $this->assertSame('5.00', $invoice->paid_amount);
        $this->assertSame('8.00', $invoice->balance_due);
        $this->assertSame('partial', $invoice->payment_status);
        $this->actingAs($cashier)->get(route('bulkInvoices.show', $invoice))->assertOk();
        $this->actingAs($cashier)->get(route('bulkInvoices.index'))->assertOk();

        $this->actingAs($cashier)->post(route('bulkInvoices.payments.store', $invoice), [
            'amount' => '8.00',
            'paid_on' => '2026-10-31',
        ])->assertRedirect(route('bulkInvoices.show', $invoice));
        $this->assertSame('paid', $invoice->fresh()->payment_status);
    }

    public function test_invoice_payment_cannot_exceed_outstanding_balance(): void
    {
        $cashier = $this->createUserWithRole('user');
        $company = Company::create(['name' => 'Acme Group']);
        $invoice = BulkInvoice::create([
            'company_id' => $company->id,
            'user_id' => $cashier->id,
            'invoice_number' => 'BULK-000001',
            'issued_on' => '2026-10-31',
            'total' => '10.00',
        ]);

        $this->actingAs($cashier)
            ->from(route('bulkInvoices.show', $invoice))
            ->post(route('bulkInvoices.payments.store', $invoice), [
                'amount' => '10.01',
                'paid_on' => '2026-10-31',
            ])
            ->assertRedirect(route('bulkInvoices.show', $invoice))
            ->assertSessionHasErrors('amount');

        $this->assertDatabaseCount('bulk_invoice_payments', 0);
    }

    public function test_stockkeeper_cannot_access_company_or_invoice_management(): void
    {
        $stockkeeper = $this->createUserWithRole('stockeeper');

        $this->actingAs($stockkeeper)
            ->get(route('companies.index'))
            ->assertForbidden();

        $this->actingAs($stockkeeper)
            ->get(route('bulkInvoices.index'))
            ->assertForbidden();
    }

    private function createUserWithRole(string $roleName): User
    {
        $role = Role::create(['role' => $roleName]);

        return User::factory()->create(['role_id' => $role->id]);
    }
}
