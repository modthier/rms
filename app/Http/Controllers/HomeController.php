<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyExpense;
use Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Services\OrderService;
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

        return redirect()->route('home');
    }


    public function dashboard(OrderService $orderService)
    {
        $report = $orderService->getDailyReport();
        return view('dashboard', ['metaTitle' => 'لوحة التحكم'])
            ->with([
                'total_today' => $report['total_today'],
                'daily_expenses' => $report['daily_expenses'],
                'total_by_payments' => $report['total_by_payments'],
                'total_by_items' => $report['total_by_items'],
            ]);
    }


    public function loc (Request $request){
        
        $ip = "102.126.219.211";
        $data = Location::get();                
        dd($data);
    }
}
