<?php

namespace App\Repositories;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Order data access. Used for listing and creating orders to simplify testing and keep controllers thin.
 */
class OrderRepository
{
    /**
     * Paginated orders with relations.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedOrders(int $perPage = 10): LengthAwarePaginator
    {
        return Order::with(['items', 'user', 'payment', 'orderType'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Daily total sales (not returned) for a date.
     *
     * @param Carbon $date
     * @return float
     */
    public function getDailyTotal(Carbon $date): float
    {
        return (float) Order::notReturned()
            ->whereBetween('created_at', [$date->copy()->startOfDay(), $date->copy()->endOfDay()])
            ->sum('total_price');
    }

    /**
     * Create an order from array.
     *
     * @param array $data
     * @return Order
     */
    public function create(array $data): Order
    {
        return Order::create($data);
    }
}
