<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrders;
use Illuminate\Http\Request;

class PurchaseOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pos = PurchaseOrders::orderBy('created_at','desc')->paginate();

        return view('purchaseOrders.index',['metaTitle' => 'قائمة المشتريات'])->with('pos',$pos);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $purchaseOrder = new PurchaseOrders();
        $stock = new Stock();

        DB::beginTransaction();

        try {

            $purchaseOrder->total_price = $request->total_price;
            $purchaseOrder->quantity = $request->quantity;
            $purchaseOrder->stock()->associate($stock->id);
            $purchaseOrder->user()->associate(Auth::id());
            $purchaseOrder->save();

            DB::commit();

            $request->session()->flash('success','Stock  has been Saved');
            return redirect()->route('stocks.create');
            
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('error','Some Error Happend');
            return redirect()->withInputs()->route('stocks.create');
        }
    }

   
    

   
}
