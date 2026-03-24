<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

/**
 * REST API for orders: list, today summary, daily report.
 */
class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected OrderRepository $orderRepository
    ) {
    }

    /**
     * List orders (paginated).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = $this->orderRepository->getPaginatedOrders(15);
        return response()->json($orders);
    }

    /**
     * Today's sales and expenses summary.
     *
     * @return JsonResponse
     */
    public function todaySummary(): JsonResponse
    {
        $report = $this->orderService->getDailyReport();
        return response()->json([
            'total_today' => $report['total_today'],
            'daily_expenses' => $report['daily_expenses'],
            'total_by_payments' => $report['total_by_payments'],
            'total_by_items' => $report['total_by_items'],
        ]);
    }
}
