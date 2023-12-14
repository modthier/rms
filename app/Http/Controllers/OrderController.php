<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $today = Carbon::today();

        $orders = Order::with('items')->orderBy('created_at','desc')->paginate(10);

        $total = DB::table('orders')->sum('total_price');


        $total_today = DB::table('orders')->whereDate('created_at',$today)->sum('total_price');
        
        $total_week = DB::table('orders')->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('total_price');

        $total_month = DB::table('orders')->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->sum('total_price');

        $items = Item::all();

        return view('order.index',['metaTitle' => 'قائمة المبيعات'])
                ->with([
                    'orders' => $orders ,
                    'total' => $total ,
                    'total_today' => $total_today ,
                    'total_week' => $total_week ,
                    'total_month' => $total_month,   
                    'items' => $items
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('order.show',['metaTitle' => 'تفاصيل المعاملة'])->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->items()->detach();
        $order->delete();

        return redirect()->route('order.index');
    }


    public function dailyReport()
    {
       
        $today = Carbon::today();

        $total_today = DB::table('orders')->whereDate('created_at',$today)->sum('total_price');

        $daily_expenses = DB::table('daily_expenses')->whereDate('created_at',$today)->sum('amount');


        $total_by_payments = DB::table('orders as o')
                    ->select(DB::raw('p.method , sum(o.total_items) as total_items,sum(o.total_price) as total_price'))
                    ->leftJoin('payments as p','p.id','o.payment_id')
                    ->groupBy('o.payment_id')
                    ->whereDate('o.created_at',$today)
                    ->get();


        $total_by_items = DB::table('orders as o')
                    ->select(DB::raw('t.name , sum(od.quantity) as total_quantity,sum(od.price) as total_price'))
                    ->leftJoin('order_details as od','od.order_id','o.id')
                    ->leftJoin('items as t','t.id','od.item_id')
                    ->groupBy('t.name')
                    ->whereDate('od.created_at',$today)
                    ->get();

        return view('reports.dailyReport',['metaTitle' => 'التقرير اليومي'])
                ->with([
                    'total_today' => $total_today ,
                    'daily_expenses' => $daily_expenses ,
                    'total_by_payments' => $total_by_payments ,
                    'total_by_items' =>  $total_by_items
                ]);
    }


    public function weeklyReport()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $total_week = DB::table('orders')->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('total_price');

        $daily_expenses = DB::table('daily_expenses')->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('amount');


        $total_by_payments = DB::table('orders as o')
                    ->select(DB::raw('p.method , sum(o.total_items) as total_items,sum(o.total_price) as total_price'))
                    ->leftJoin('payments as p','p.id','o.payment_id')
                    ->groupBy('o.payment_id')
                    ->whereBetween('o.created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
                    ->get();


        $total_by_items = DB::table('orders as o')
                    ->select(DB::raw('t.name , sum(od.quantity) as total_quantity,sum(od.price) as total_price'))
                    ->leftJoin('order_details as od','od.order_id','o.id')
                    ->leftJoin('items as t','t.id','od.item_id')
                    ->groupBy('t.name')
                    ->whereBetween('od.created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
                    ->get();

        return view('reports.weeklyReport',['metaTitle' => 'التقرير الاسبوعي'])
                ->with([
                    'total_week' => $total_week ,
                    'daily_expenses' => $daily_expenses ,
                    'total_by_payments' => $total_by_payments ,
                    'total_by_items' => $total_by_items
                ]);

        
    }


    public function monthlyReport()
    {
        
        $total_month = DB::table('orders')->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->sum('total_price');

        $daily_expenses = DB::table('daily_expenses')->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
            ->sum('amount');


        $total_by_payments = DB::table('orders as o')
                    ->select(DB::raw('p.method , sum(o.total_items) as total_items,sum(o.total_price) as total_price'))
                    ->leftJoin('payments as p','p.id','o.payment_id')
                    ->groupBy('o.payment_id')
                    ->whereBetween('o.created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                    ->get();


        $total_by_items = DB::table('orders as o')
                    ->select(DB::raw('t.name , sum(od.quantity) as total_quantity,sum(od.price) as total_price'))
                    ->leftJoin('order_details as od','od.order_id','o.id')
                    ->leftJoin('items as t','t.id','od.item_id')
                    ->groupBy('t.name')
                    ->whereBetween('od.created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                    ->get();

        return view('reports.monthlyReport',['metaTitle' => 'التقرير الشهري'])
                ->with([
                    'total_month' => $total_month ,
                    'daily_expenses' => $daily_expenses ,
                    'total_by_payments' => $total_by_payments ,
                    'total_by_items' => $total_by_items
                ]);
    }


    public function productReport(Request $request)
    {
        
        $report = DB::table('order_details as os')
               ->select([
                    'i.name' , DB::raw('sum(os.quantity) as frequancy') , 
                    DB::raw('sum(os.quantity * os.price) as total_price')
               ])
               ->leftJoin('items as i','os.item_id','i.id')
               ->where('os.item_id',$request->item_id)
               ->whereRaw('Date(os.created_at) between ? and ?',[$request->date_from,$request->date_to])
               ->groupBy('os.item_id')
               ->paginate(20);
        
        
        
        
        return view('reports.itemReport',['metaTitle' => 'تقرير بالمنتج'])
                ->with([
                    'report' => $report ,
                ]);
    }

    public function dailyTotal($id)
    {
        $user = User::findOrFail($id);
        $result = DB::table('orders')
                  ->select(
                    DB::raw('sum(total_price) as total,date(created_at) as created_at') 
                    
                  )
                  ->where('user_id',$id)
                  ->groupBy(DB::raw('date(created_at)'))
                  ->orderBy('created_at','desc')
                  ->paginate(20);
       
       return view('users.daily',['metaTitle' => 'مجموع المبيعات اليومي'])
                 ->with(['results' => $result , 'user' => $user]);

    }

    public function realtime(){
        $name = Setting::get()->first();
        return view('order.realtime',['metaTitle'=>'قائمة الطلبات'])->with('name',$name);
    }
}
