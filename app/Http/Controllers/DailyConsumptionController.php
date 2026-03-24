<?php

namespace App\Http\Controllers;

use App\Models\DailyConsumption;
use Illuminate\Http\Request;
use App\Models\Stock;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreDailyConsumptionRequest;

class DailyConsumptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', DailyConsumption::class);
        $dailies = DailyConsumption::with(['stock.ingredient'])
            ->orderBy('created_at', 'desc')
            ->paginate();
       

        return view('dailyConsumption.index',['metaTitle' => 'الاستهلاك اليومي'])->with('dailies',$dailies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', DailyConsumption::class);
        $stocks = Stock::query()
            ->where('quantity', '>', 0)
            ->whereNotNull('ingredient_id')
            ->whereHas('ingredient')
            ->with('ingredient')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dailyConsumption.create',['metaTitle' => 'سحب من المخزون'])
                ->with('stocks',$stocks);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDailyConsumptionRequest $request)
    {
        $this->authorize('create', DailyConsumption::class);
        $stock = Stock::findOrFail($request->stock_id);

        $errors = [];
        if($request->quantity > $stock->quantity) {
            $errors[] = 'لا يمكنك سحب كمية اكثر من الموجودة بالمخزون' ;
            return back()->with('errs',$errors);
        }


        try {
            DB::transaction(function () use ($request, $stock) {
                $daily = new DailyConsumption;
                $daily->stock_id = $request->stock_id;
                $daily->quantity = $request->quantity;
                $daily->save();

                $new_quantity = $stock->quantity - $request->quantity;
                $stock->update(['quantity' => $new_quantity]);
            });

            $request->session()->flash('success','تم سحب الكمية من المخزون بنجاح');
            return redirect()->route('dailyConsumption.index');
        } catch (Exception $e) {
            Log::error('Daily consumption creation failed', [
                'stock_id' => $request->stock_id,
                'error' => $e->getMessage(),
            ]);
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
       $this->authorize('delete', $dailyConsumption);
        
       $stock = Stock::findOrFail($dailyConsumption->stock_id);
    
       $new_stock = $dailyConsumption->quantity + $stock->quantity;
       
       $stock->update([
        'quantity' => $new_stock
       ]);
        

        
        $dailyConsumption->delete();

        return redirect()->route('dailyConsumption.index');
    }
}
