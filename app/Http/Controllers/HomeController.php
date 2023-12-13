<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyExpense;
use Auth;
use Carbon\Carbon;
use App\Models\Order;
use DB;
use Stevebauman\Location\Facades\Location;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
            if(Auth::user()->hasRole('admin')){
                return redirect()->route('admin.dashboard');
            }


            if(Auth::user()->hasRole('user')){
                return redirect()->route('cashier.create');
            }

            if(Auth::user()->hasRole('stockeeper')){
                return redirect()->route('stock.index');
            }
    }


    public function dashboard()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
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
        
        
        return view('dashboard')
            ->with([
                'total_today' => $total_today ,
                'daily_expenses' => $daily_expenses ,
                'total_by_payments' => $total_by_payments,
                'total_by_items' => $total_by_items
            ]);
    }


    public function loc (Request $request){
        
        $ip = "102.126.219.211";
        $data = Location::get();                
        dd($data);
    }
}
