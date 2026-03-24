<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderType;
use App\Models\Payment;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected OrderService $service;

    protected function setUp(): void
    {
        parent::setUp();
        if (OrderType::count() === 0) {
            OrderType::create(['name' => 'Test']);
        }
        if (Payment::count() === 0) {
            Payment::create(['method' => 'Cash']);
        }
        $this->service = new OrderService();
    }

    public function test_get_daily_totals_returns_correct_sales(): void
    {
        Order::factory()->create([
            'total_price' => 100,
            'returned' => 0,
            'created_at' => Carbon::today(),
        ]);

        $totals = $this->service->getDailyTotals(Carbon::today());

        $this->assertEquals(100, $totals['total_sales']);
    }

    public function test_get_daily_totals_excludes_returned_orders(): void
    {
        Order::factory()->create([
            'total_price' => 50,
            'returned' => 0,
            'created_at' => Carbon::today(),
        ]);
        Order::factory()->returned()->create([
            'total_price' => 30,
            'created_at' => Carbon::today(),
        ]);

        $totals = $this->service->getDailyTotals(Carbon::today());

        $this->assertEquals(50, $totals['total_sales']);
    }

    public function test_get_daily_report_returns_structure(): void
    {
        Order::factory()->create([
            'total_price' => 100,
            'returned' => 0,
            'created_at' => Carbon::today(),
        ]);

        $report = $this->service->getDailyReport(Carbon::today());

        $this->assertArrayHasKey('total_today', $report);
        $this->assertArrayHasKey('daily_expenses', $report);
        $this->assertArrayHasKey('total_by_payments', $report);
        $this->assertArrayHasKey('total_by_items', $report);
        $this->assertEquals(100, $report['total_today']);
    }
}
