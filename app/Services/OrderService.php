<?php

namespace App\Services;

use App\Models\Order;
use App\Models\DailyExpense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Order-related business logic: reports, totals, and aggregates.
 */
class OrderService
{
    /** Cache TTL for daily totals (seconds). 1 hour. */
    public const CACHE_DAILY_TOTALS_TTL = 3600;

    /**
     * Get daily report: sales, expenses, and aggregates by payment and item.
     *
     * @param Carbon|null $date Report date. Defaults to today.
     * @return array{total_today: float, daily_expenses: float, total_by_payments: \Illuminate\Support\Collection, total_by_items: \Illuminate\Support\Collection}
     */
    public function getDailyReport(?Carbon $date = null): array
    {
        $date = $date ?? Carbon::today();
        $totals = $this->getDailyTotals($date);

        return [
            'total_today' => $totals['total_sales'],
            'daily_expenses' => $totals['total_expenses'],
            'total_by_payments' => $this->getTotalByPaymentsForDate($date, 'daily'),
            'total_by_items' => $this->getTotalByItemsForDate($date, 'daily'),
        ];
    }

    /**
     * Get daily sales and expenses totals (cached).
     *
     * @param Carbon|null $date Date. Defaults to today.
     * @return array{total_sales: float, total_expenses: float}
     */
    public function getDailyTotals(?Carbon $date = null): array
    {
        $date = $date ?? Carbon::today();
        $cacheKey = 'daily_totals_' . $date->format('Y-m-d');
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();

        return Cache::remember($cacheKey, self::CACHE_DAILY_TOTALS_TTL, function () use ($start, $end) {
            return [
                'total_sales' => Order::notReturned()->whereBetween('created_at', [$start, $end])->sum('total_price'),
                'total_expenses' => DailyExpense::whereBetween('created_at', [$start, $end])->sum('amount'),
            ];
        });
    }

    /**
     * Get weekly report (Saturday–Friday).
     *
     * @return array{total_week: float, daily_expenses: float, total_by_payments: \Illuminate\Support\Collection, total_by_items: \Illuminate\Support\Collection}
     */
    public function getWeeklyReport(): array
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();

        return [
            'total_week' => Order::notReturned()->whereBetween('created_at', [$start, $end])->sum('total_price'),
            'daily_expenses' => DailyExpense::whereBetween('created_at', [$start, $end])->sum('amount'),
            'total_by_payments' => $this->getTotalByPaymentsBetween($start, $end),
            'total_by_items' => $this->getTotalByItemsBetween($start, $end),
        ];
    }

    /**
     * Get monthly report.
     *
     * @return array{total_month: float, daily_expenses: float, total_by_payments: \Illuminate\Support\Collection, total_by_items: \Illuminate\Support\Collection}
     */
    public function getMonthlyReport(): array
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        return [
            'total_month' => Order::notReturned()->whereBetween('created_at', [$start, $end])->sum('total_price'),
            'daily_expenses' => DailyExpense::whereBetween('created_at', [$start, $end])->sum('amount'),
            'total_by_payments' => $this->getTotalByPaymentsBetween($start, $end),
            'total_by_items' => $this->getTotalByItemsBetween($start, $end),
        ];
    }

    /**
     * Totals by payment method for a given date range.
     *
     * @param Carbon $start
     * @param Carbon $end
     * @return \Illuminate\Support\Collection
     */
    protected function getTotalByPaymentsBetween(Carbon $start, Carbon $end): \Illuminate\Support\Collection
    {
        return Order::query()
            ->from('orders as o')
            ->select(DB::raw('p.method, sum(o.total_items) as total_items, sum(o.total_price) as total_price'))
            ->leftJoin('payments as p', 'p.id', 'o.payment_id')
            ->groupBy('o.payment_id')
            ->where('o.returned', 0)
            ->whereBetween('o.created_at', [$start, $end])
            ->get();
    }

    /**
     * Totals by payment for daily (single date); period 'daily' filters by date.
     *
     * @param Carbon $date
     * @param string $period
     * @return \Illuminate\Support\Collection
     */
    protected function getTotalByPaymentsForDate(Carbon $date, string $period): \Illuminate\Support\Collection
    {
        $q = Order::query()
            ->from('orders as o')
            ->select(DB::raw('p.method, sum(o.total_items) as total_items, sum(o.total_price) as total_price'))
            ->leftJoin('payments as p', 'p.id', 'o.payment_id')
            ->groupBy('o.payment_id')
            ->where('o.returned', 0);

        if ($period === 'daily') {
            $q->whereBetween('o.created_at', [$date->copy()->startOfDay(), $date->copy()->endOfDay()]);
        }

        return $q->get();
    }

    /**
     * Totals by item for a date range.
     *
     * @param Carbon $start
     * @param Carbon $end
     * @return \Illuminate\Support\Collection
     */
    protected function getTotalByItemsBetween(Carbon $start, Carbon $end): \Illuminate\Support\Collection
    {
        return $this->buildTotalByItemsQuery()
            ->whereBetween('od.created_at', [$start, $end])
            ->get();
    }

    /**
     * Totals by item for daily (single date).
     *
     * @param Carbon $date
     * @param string $period
     * @return \Illuminate\Support\Collection
     */
    protected function getTotalByItemsForDate(Carbon $date, string $period): \Illuminate\Support\Collection
    {
        $q = $this->buildTotalByItemsQuery();
        if ($period === 'daily') {
            $q->whereBetween('o.created_at', [$date->copy()->startOfDay(), $date->copy()->endOfDay()]);
        }
        return $q->get();
    }

    /**
     * Base query: item name, sum quantity, sum price, grouped by item name.
     * Filters by order.returned = 0 via join.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function buildTotalByItemsQuery(): \Illuminate\Database\Query\Builder
    {
        return DB::table('orders as o')
            ->select(DB::raw('t.name, sum(od.quantity) as total_quantity, sum(od.price) as total_price'))
            ->leftJoin('order_details as od', 'od.order_id', 'o.id')
            ->leftJoin('items as t', 't.id', 'od.item_id')
            ->groupBy('t.name')
            ->where('o.returned', 0);
    }
}
