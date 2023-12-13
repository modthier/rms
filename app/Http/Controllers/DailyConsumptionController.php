<?php

namespace App\Http\Controllers;

use App\Models\DailyConsumption;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Rules\DailyConsumptionRule;
use DB;

class DailyConsumptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dailies = DailyConsumption::orderBy('created_at','desc')->paginate();
       

        return view('dailyConsumption.index',['metaTitle' => 'الاستهلاك اليومي'])->with('dailies',$dailies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stocks = Stock::where('quantity','>',0)->get();

        return view('dailyConsumption.create',['metaTitle' => 'سحب من المخزون'])
                ->with('stocks',$stocks);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'stock_id' => 'required' ,
            'remaining_quantity' => 'required',
            'quantity' => ['required']
        ]);

        $stock = Stock::findOrFail($request->stock_id);

        $errors = [];
        if($request->quantity > $stock->quantity) {
            $errors[] = 'لا يمكنك سحب كمية اكثر من الموجودة بالمخزون' ;
            return back()->with('errs',$errors);
        }


        DB::beginTransaction();

        try {

            $daily = new DailyConsumption;
            $daily->stock_id = $request->stock_id;
            $daily->quantity = $request->quantity;
            $daily->save();

            $new_quantity = $stock->quantity - $request->quantity;
            $stock->update(['quantity' => $new_quantity]);
            $request->session()->flash('success','تم سحب الكمية من المخزون بنجاح');

            DB::commit();
            return redirect()->route('dailyConsumption.index');


        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('dailyConsumption.create');
        }

    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DailyConsumption  $dailyConsumption
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyConsumption $dailyConsumption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DailyConsumption  $dailyConsumption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyConsumption $dailyConsumption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DailyConsumption  $dailyConsumption
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyConsumption $dailyConsumption)
    {
        
       $stock = Stock::findOrFail($dailyConsumption->stock_id);
    
       $new_stock = $dailyConsumption->quantity + $stock->quantity;
       
       $stock->update([
        'quantity' => $new_stock
       ]);
        

        
        $dailyConsumption->delete();

        return redirect()->route('dailyConsumption.index');
    }
}
