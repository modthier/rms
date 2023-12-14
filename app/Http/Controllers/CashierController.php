<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Exception;
use Carbon\Carbon;
use App\Models\Item;
use App\Events\Hello;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\ItemType;
use App\Models\OrderType;
use Illuminate\Http\Request;
//use Str;
class CashierController extends Controller
{

    public function create()
    {
    	$types = ItemType::has('items')->get();
        $name = Setting::get()->first();
        $payments = Payment::all();
        $order_types = OrderType::all();
    	return view('cashier.create',['metaTitle' => 'نقطة البيع'])->with([
            'types'=> $types ,
            'name' => $name,
            'payments' => $payments,
            'order_types' => $order_types,
        ]);
    }


    public function  sales()
    {
        
        $name = Setting::get()->first();
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $today = Carbon::today();
        
            
        $orders = Order::where('user_id',Auth::id())->orderBy('id','desc')
                         ->paginate(8);

        $total_today = DB::table('orders')
                ->where('user_id',Auth::id())
                ->whereDate('created_at',$today)
                ->sum('total_price');
        
        $total_week = DB::table('orders')->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
        ->where('user_id',Auth::id())
        ->sum('total_price');

        $total_month = DB::table('orders')
                          ->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                          ->where('user_id',Auth::id())
                          ->sum('total_price');
        
         return view('cashier.sales',['metaTitle' => 'المبيعات'])
           ->with([
             'orders' => $orders ,
             'total_today' => $total_today,
             'total_week' => $total_week,
             'total_month' => $total_month,
             'name' => $name
         ]);
       
    }




    public function cashierDashboard()
    {
    	return view('cashier.dashboard');
    }


    public function store(Request $request)
    {
        $arr = [];

        foreach ($request->items as $id=>$quantity) {
              array_push($arr, [$id => ['quantity' => $quantity['quantity'],'price' => $request->input('price'.$id) ]] );
        }

        $order = new Order;
        try {

            $total_quantity = 0;
            foreach ($request->items as $id=>$quantity) {
              $total_quantity = $total_quantity + $quantity['quantity'];
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
                       

            broadcast(new Hello());
            DB::commit(); 
            
            $name = Setting::get()->first();
            $types = DB::table('order_details as os')
                        ->select('i.item_type_id')
                        ->leftJoin('items as i' ,'os.item_id','i.id')
                        ->leftJoin('orders as s','os.order_id','s.id')
                        ->where('os.order_id',$order->id)
                        ->groupBy('i.item_type_id')
                        ->get();
           // dd($types);
            $view = view('cashier.show')->with(['order' => $order , 'name' => $name , 'types' => $types ])->render();
            echo $view;

        } catch (Exception $e) {
            DB::rollBack();
            
            
        }
    }


    public function showSales(Request $request,Order $order)
    {
        $name = Setting::get()->first();
        return view('cashier.order_details')
            ->with(['order' => $order , 'name' => $name]); 
    }


    public function destroy(Order $order)
    {
        

        $order->items()->detach();
        $order->delete();

        return redirect()->route('cashier.sales');
    }

    


    
}
