<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderMonthyReportExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        
        return DB::table('orders as o')
                    ->select(DB::raw('t.name , sum(od.quantity) as total_quantity,sum(od.price) as total_price'))
                    ->leftJoin('order_details as od','od.order_id','o.id')
                    ->leftJoin('items as t','t.id','od.item_id')
                    ->groupBy('t.name')
                    ->whereBetween('od.created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                    ->get();
    }
}
