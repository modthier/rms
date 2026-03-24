<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductReportRequest;
use App\Http\Requests\HourlySalesSearchRequest;
use App\Http\Requests\CanceledOrdersSearchRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderMonthyReportExport;
use App\Exports\OrderWeeklyReportExport;

/**
 * Handles order listing, reports (daily/weekly/monthly), exports, and canceled orders.
 */
class OrderController extends Controller
{
    /**
     * Display a listing of orders with totals (all, today, week, month).
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\View
     */
    public function index(OrderRepository $repository)
    {
        $this->authorize('viewAny', Order::class);
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $orders = $repository->getPaginatedOrders(10);

        $total = Order::sum('total_price');
        $total_today = Order::today()->sum('total_price');
        $total_week = Order::thisWeek()->sum('total_price');
        $total_month = Order::thisMonth()->sum('total_price');

        $items = Item::all();

        return view('order.index', ['metaTitle' => 'قائمة المبيعات'])
            ->with([
                'orders' => $orders,
                'total' => $total,
                'total_today' => $total_today,
                'total_week' => $total_week,
                'total_month' => $total_month,
                'items' => $items,
            ]);
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

    /**
     * Show a single order with items, user, payment, and order type.
     *
     * @param Order $order
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\View
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['items.itemType', 'items.ingredient', 'items.unit', 'user', 'payment', 'orderType']);
        return view('order.show', ['metaTitle' => 'تفاصيل المعاملة'])->with('order', $order);
    }

   
    public function edit(Order $order)
    {
        //
    }

    
    public function update(Request $request, Order $order)
    {
        //
    }

    
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        
        $order->items()->detach();
        $order->delete();

        return redirect()->route('order.index');
    }

    /**
     * Daily sales report with expenses and totals by payment and item.
     *
     * @param OrderService $orderService
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\View
     */
    public function dailyReport(OrderService $orderService)
    {
        $report = $orderService->getDailyReport();
        $users = User::all();
        return view('reports.dailyReport', ['metaTitle' => 'التقرير اليومي'])
            ->with([
                'total_today' => $report['total_today'],
                'daily_expenses' => $report['daily_expenses'],
                'total_by_payments' => $report['total_by_payments'],
                'total_by_items' => $report['total_by_items'],
                'users' => $users,
            ]);
    }


    /**
     * Weekly sales report (Saturday–Friday).
     *
     * @param OrderService $orderService
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\View
     */
    public function weeklyReport(OrderService $orderService)
    {
        $report = $orderService->getWeeklyReport();
        return view('reports.weeklyReport', ['metaTitle' => 'التقرير الاسبوعي'])
            ->with([
                'total_week' => $report['total_week'],
                'daily_expenses' => $report['daily_expenses'],
                'total_by_payments' => $report['total_by_payments'],
                'total_by_items' => $report['total_by_items'],
            ]);
    }

    public function exportWeekReport()
    {
        return Excel::download(new OrderWeeklyReportExport, 'OrderWeeklyReport.xlsx');
    }

    /**
     * Monthly sales report.
     *
     * @param OrderService $orderService
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\View
     */
    public function monthlyReport(OrderService $orderService)
    {
        $report = $orderService->getMonthlyReport();
        return view('reports.monthlyReport', ['metaTitle' => 'التقرير الشهري'])
            ->with([
                'total_month' => $report['total_month'],
                'daily_expenses' => $report['daily_expenses'],
                'total_by_payments' => $report['total_by_payments'],
                'total_by_items' => $report['total_by_items'],
            ]);
    }

    public function exporMonthReport()
    {
        return Excel::download(new OrderMonthyReportExport, 'OrderMonthyReport.xlsx');
    }
    public function productReport(ProductReportRequest $request)
    {
        $from = Carbon::parse($request->date_from)->startOfDay();
        $to = Carbon::parse($request->date_to)->endOfDay();

        $report = DB::table('order_details as os')
            ->select([
                'i.name',
                DB::raw('sum(os.quantity) as frequancy'),
                DB::raw('sum(os.price) as total_price'),
            ])
            ->leftJoin('items as i', 'os.item_id', 'i.id')
            ->leftJoin('orders as o', 'o.id', 'os.order_id')
            ->where('o.returned', 0)
            ->where('os.item_id', $request->item_id)
            ->whereBetween('os.created_at', [$from, $to])
            ->groupBy('os.item_id')
            ->paginate(20);

        return view('reports.itemReport', ['metaTitle' => 'تقرير بالمنتج'])
            ->with(['report' => $report]);
    }

    public function dailyTotal($id)
    {
        $user = User::findOrFail($id);
        $result = Order::query()
            ->select(DB::raw('sum(total_price) as total, date(created_at) as created_at'))
            ->where('user_id', $id)
            ->notReturned()
            ->groupBy(DB::raw('date(created_at)'))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('users.daily', ['metaTitle' => 'مجموع المبيعات اليومي'])
            ->with(['results' => $result, 'user' => $user]);
    }

    public function realtime(){
        $name = Setting::getCached();
        return view('order.realtime',['metaTitle'=>'قائمة الطلبات'])->with('name',$name);
    }

    public function canceledOrder()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $orders = Order::with(['items', 'user', 'payment', 'orderType'])
            ->returned()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $total = Order::returned()->sum('total_price');
        $total_today = Order::returned()->today()->sum('total_price');
        $total_week = Order::returned()->thisWeek()->sum('total_price');
        $total_month = Order::returned()->thisMonth()->sum('total_price');

        $users = User::all();

        return view('order.canceledOrder', ['metaTitle' => 'قائمة الطلبات الملغية'])
            ->with([
                'orders' => $orders,
                'total' => $total,
                'total_today' => $total_today,
                'total_week' => $total_week,
                'total_month' => $total_month,
                'users' => $users,
            ]);
    }

    public function canceledSearch(CanceledOrdersSearchRequest $request)
    {
        $from = Carbon::parse($request->date_from)->startOfDay();
        $to = Carbon::parse($request->date_to)->endOfDay();

        $report = Order::query()
            ->where('returned', 1)
            ->whereBetween('created_at', [$from, $to]);

        if ($request->filled('user_id')) {
            $report->where('user_id', $request->user_id);
        }

        $total = $report->sum('total_price');
        $report = $report->paginate(20);
        
        
        $users = User::all();
        return view('order.canceledResult',['metaTitle' => 'نتيجة البحث'])
                ->with([
                    'report' => $report ,
                    'users' => $users,
                    'total_price' => $total,

                ]);
    }


    public function hourlySearch(HourlySalesSearchRequest $request)
    {
        $startAt = Carbon::parse($request->start_date . ' ' . $request->start_time);
        $endAt = Carbon::parse($request->start_date . ' ' . $request->end_time);
        if ($endAt->lt($startAt)) {
            $endAt->addDay();
        }

        $result = Order::notReturned()
            ->where('user_id', $request->user_id)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->sum('total_price');

        $user = User::find($request->user_id);
        $users = User::all();
        return view('reports.hourlyReport', ['metaTitle' => 'بحث في المبيعات حسب المستخدم'])->with([
            'total' => $result,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'start_date' => $request->start_date,
            'user' => $user,
            'users' => $users,
        ]);
    }
}
