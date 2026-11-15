<?php

namespace Tests\Feature;

use App\Models\BulkInvoice;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SummaryInvoiceReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_totals_are_included_in_summary_and_period_link_filters_invoice_list(): void
    {
        $admin = $this->createAdmin();
        $company = Company::create(['name' => 'Acme Group']);
        $invoice = $this->createInvoice($company, $admin, 'BULK-000001', '2026-10-31', '45.25');
        $this->createInvoice($company, $admin, 'BULK-000002', '2026-10-30', '10.00');

        $this->actingAs($admin)
            ->get(route('summary.index'))
            ->assertOk()
            ->assertSee('45.25')
            ->assertSee(route('bulkInvoices.index', [
                'date_from' => '2026-10-31',
                'date_to' => '2026-10-31',
            ]));

        $this->actingAs($admin)
            ->get(route('bulkInvoices.index', [
                'date_from' => '2026-10-31',
                'date_to' => '2026-10-31',
            ]))
            ->assertOk()
            ->assertSee($invoice->invoice_number)
            ->assertDontSee('BULK-000002');
    }

    public function test_date_range_summary_includes_only_invoice_sales_issued_in_range(): void
    {
        $admin = $this->createAdmin();
        $company = Company::create(['name' => 'Acme Group']);
        $this->createInvoice($company, $admin, 'BULK-000001', '2026-10-31', '45.25');
        $this->createInvoice($company, $admin, 'BULK-000002', '2026-10-30', '10.00');

        $this->actingAs($admin)
            ->get(route('summary.search', [
                'date_from' => '2026-10-31',
                'date_to' => '2026-10-31',
            ]))
            ->assertOk()
            ->assertSee('45.25')
            ->assertSee(route('bulkInvoices.index', [
                'date_from' => '2026-10-31',
                'date_to' => '2026-10-31',
            ]));
    }

    private function createAdmin(): User
    {
        $role = Role::create(['role' => 'admin']);

        return User::factory()->create(['role_id' => $role->id]);
    }

    private function createInvoice(
        Company $company,
        User $admin,
        string $number,
        string $issuedOn,
        string $total
    ): BulkInvoice {
        return BulkInvoice::create([
            'company_id' => $company->id,
            'user_id' => $admin->id,
            'invoice_number' => $number,
            'issued_on' => $issuedOn,
            'total' => $total,
        ]);
    }
}
