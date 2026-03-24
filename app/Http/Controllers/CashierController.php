<?php

namespace App\Http\Controllers;


use Exception;
use Carbon\Carbon;
use App\Events\Hello;
use App\Events\OrderStatusChanged;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\ItemType;
use App\Models\OrderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreOrderRequest;
/**
 * Cashier POS: create orders, view sales, print receipts, cancel orders.
 */
class CashierController extends Controller
{
    /**
     * Show POS form with item types, payments, and order types.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\View
     */
    public function create()
    {
    	$types = ItemType::has('items')->get();
        $name = Setting::getCached();
        $payments = Payment::all();
        $order_types = OrderType::all();
    	return view('cashier.create',['metaTitle' => 'نقطة البيع'])->with([
            'types'=> $types ,
            'name' => $name,
            'payments' => $payments,
            'order_types' => $order_types,
        ]);
    }


    /**
     * List cashier's orders and totals (today, week, month, canceled).
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\View
     */
    public function sales()
    {
        $name = Setting::getCached();
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $userId = Auth::id();
        $orders = Order::with(['items', 'payment', 'orderType'])
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->paginate(8);

        $total_today = Order::where('user_id', $userId)->notReturned()->today()->sum('total_price');
        $total_today_canceled = Order::where('user_id', $userId)->returned()->today()->sum('total_price');
        $total_week = Order::where('user_id', $userId)->notReturned()->thisWeek()->sum('total_price');
        $total_month = Order::where('user_id', $userId)->notReturned()->thisMonth()->sum('total_price');

        return view('cashier.sales', ['metaTitle' => 'المبيعات'])
            ->with([
                'orders' => $orders,
                'total_today' => $total_today,
                'total_week' => $total_week,
                'total_month' => $total_month,
                'name' => $name,
                'total_today_canceled' => $total_today_canceled,
            ]);
    }




    public function cashierDashboard()
    {
    	return view('cashier.dashboard');
    }


    /**
     * Create a new order and attach items (within a DB transaction).
     *
     * @param StoreOrderRequest $request
     * @return void
     */
    public function store(StoreOrderRequest $request)
    {
        $this->authorize('create', Order::class);
        $arr = [];

        foreach ($request->items as $id => $quantity) {
            array_push($arr, [$id => ['quantity' => $quantity['quantity'], 'price' => $request->input('price' . $id)]]);
        }

        try {
            $order = DB::transaction(function () use ($request, $arr) {
                $order = new Order;
                $total_quantity = 0;

                foreach ($request->items as $id => $quantity) {
                    $total_quantity += $quantity['quantity'];
                }

                $order->user()->associate(Auth::id());
                $order->total_price = $request->total;
                $order->total_items = $total_quantity;
                $order->payment_id = $request->payment_id;
                $order->order_type_id = $request->order_type_id;
                $order->save();

                foreach ($arr as $a) {
                    $order->items()->attach($a);
                }

                return $order;
            });

            Log::info('Order created', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'total' => $order->total_price,
            ]);

            $order->refresh();
            $order->load(['items.itemType', 'payment', 'orderType']);

            $name = Setting::getCached();

            // Item has item_type_id; ItemType uses id (not item_type_id). Wrong pluck was always null → empty receipt.
            $typeIds = $order->items->pluck('item_type_id')->unique()->filter()->values();
            $types = $typeIds->map(fn ($id) => (object) ['item_type_id' => $id]);

            $today = Carbon::today();
            $order_count = Order::whereBetween('created_at', [$today->copy()->startOfDay(), $today->copy()->endOfDay()])->count();
            $counter = $order_count;

            $html = view('cashier.show')->with([
                'order' => $order,
                'counter' => $counter,
                'name' => $name,
                'types' => $types,
            ])->render();

            return response($html, 200)->header('Content-Type', 'text/html; charset=UTF-8');
        } catch (Exception $e) {
            Log::error('Order creation failed', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);
            return response('Failed to create order', 500);
        }
    }


    /**
     * Show order details for receipt/view.
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\View
     */
    public function showSales(Request $request, Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['items.itemType']);
        $name = Setting::getCached();
        $typeIds = $order->items->pluck('item_type_id')->unique()->filter()->values();
        $types = $typeIds->map(fn ($id) => (object) ['item_type_id' => $id]);
        return view('cashier.order_details')
            ->with(['order' => $order, 'name' => $name, 'types' => $types]);
    }


    /**
     * Delete an order and detach its items.
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->items()->detach();
        $order->delete();

        return redirect()->route('cashier.sales');
    }

    /**
     * Mark order as returned/canceled.
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelOrder(Order $order)
    {
        $this->authorize('cancel', $order);
        $order->update(['returned' => 1]);
        $order->items()->update(['returned' => 1]);
        event(new OrderStatusChanged($order));
        Log::info('Order canceled', ['order_id' => $order->id, 'user_id' => Auth::id()]);
        return redirect()->route('cashier.sales');
    }




}
