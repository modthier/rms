<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Requirement;
use App\Models\DailyExpense;
use Illuminate\Http\Request;
use App\Models\PurchaseOrders;
use App\Http\Requests\SummaryDateRangeRequest;

class SummaryController extends Controller
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
        $todayStart = $today->copy()->startOfDay();
        $todayEnd = $today->copy()->endOfDay();
        $total = Order::notReturned()->sum('total_price');
        $total_today = Order::notReturned()->whereBetween('created_at', [$todayStart, $todayEnd])->sum('total_price');
        $total_week = Order::notReturned()->thisWeek()->sum('total_price');
        $total_month = Order::notReturned()->thisMonth()->sum('total_price');

        $po_total = PurchaseOrders::sum('total_price');
        $po_today = PurchaseOrders::whereBetween('created_at', [$todayStart, $todayEnd])->sum('total_price');
        $po_week = PurchaseOrders::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_price');
        $po_month = PurchaseOrders::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('total_price');

        $expense_total = DailyExpense::sum('amount');
        $expense_today = DailyExpense::whereBetween('created_at', [$todayStart, $todayEnd])->sum('amount');
        $expense_week = DailyExpense::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
        $expense_month = DailyExpense::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('amount');



          // requirement totals
          $requirement_total = Requirement::sum('total_price');
          $requirement_today = Requirement::whereBetween('created_at', [$todayStart, $todayEnd])
                            ->sum('total_price');
          $requirement_week = Requirement::whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
                            ->sum('total_price');
          $requirement_month = Requirement::whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                           ->sum('total_price');
  
          // expense end total


          //
            $net_profit_year = $total - ($expense_total+$requirement_total+$po_total);
            $net_profit_month = $total_month - ($expense_month+$requirement_month+$po_month);
            $net_profit_week = $total_week - ($expense_week+$requirement_week+$po_week);
            $net_profit_today = $total_today - ($expense_today+$requirement_today+$po_today);

          //


        return view('summary.index',['metaTitle' => "التقرير المفصل"])
          ->with([
              'total' => $total ,
              'total_today' => $total_today,
              'total_week' => $total_week ,
              'total_month' => $total_month,
              'expense_total' => $expense_total,
              'expense_today' => $expense_today,
              'expense_week' => $expense_week,
              'expense_month' => $expense_month,
              'requirement_total' => $requirement_total,
              'requirement_today' => $requirement_today,
              'requirement_week' => $requirement_week,
              'requirement_month' => $requirement_month,
              'po_total' => $po_total,
              'po_today' => $po_today,
              'po_week' => $po_week,
              'po_month' => $po_month,
              'net_profit_year' => $net_profit_year,
              'net_profit_month' => $net_profit_month,
              'net_profit_week' => $net_profit_week,
              'net_profit_today' => $net_profit_today,
              ]
          );
    }

    
    public function search(SummaryDateRangeRequest $request)
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $from = Carbon::parse($request->date_from)->startOfDay();
        $to = Carbon::parse($request->date_to)->endOfDay();

        $total = Order::notReturned()
            ->whereBetween('created_at', [$from, $to])
            ->sum('total_price');
       

        $po_total = PurchaseOrders::whereBetween('created_at', [$from, $to])
                         ->sum('total_price');        
        // expense totals
      
        $expense_total = DailyExpense::whereBetween('created_at', [$from, $to])
                          ->sum('amount');
    
        // expense end total
        
        $requirement_total = Requirement::whereBetween('created_at', [$from, $to])
                            ->sum('total_price');
         
   
        $net_profit = $total - ($expense_total+$requirement_total+$po_total);

        return view('summary.dateSearch',['metaTitle' => "تقرير بين تاريخين"])
          ->with([
              'total' => $total ,
              'expense_total' => $expense_total,
              'requirement_total' => $requirement_total,
              'net_profit' => $net_profit,
              'po_total'=> $po_total
              ]
          );
    }

    
}
