<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Unit;
use App\Http\Requests\StoreStockRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Stock::class);
        $stocks = Stock::with(['ingredient', 'unit'])->orderBy('created_at', 'desc')->paginate();

        return view('stock.index',['metaTitle' => 'قائمة المحزون'])->with('stocks',$stocks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Stock::class);
        $ingredients = Ingredient::all();
        $units = Unit::all();
        return view('stock.create',['metaTitle' => 'اضافة  للمخزون '])
                ->with([
                    'ingredients' => $ingredients ,
                    'units' => $units
                ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockRequest $request)
    {
        $this->authorize('create', Stock::class);
        $ingredient = Ingredient::findOrFail($request->ingredient_id);

        try {
            DB::transaction(function () use ($request, $ingredient) {
                $stock = new Stock;
                $stock->ingredient()->associate($ingredient);
                $stock->quantity = $request->quantity;
                $stock->total_price = $request->total_price;
                $stock->unit_id = $request->unit_id;
                $stock->unit_price = $request->unit_price;
                $stock->save();
            });

            $request->session()->flash('success','تمت الاضافة بنجاح');
            return redirect()->route('stock.index');
            
        } catch (Exception $e) {
            Log::error('Stock creation failed', [
                'ingredient_id' => $request->ingredient_id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('stock.index');
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        $this->authorize('update', $stock);
        $stock->load(['ingredient', 'unit']);
        $ingredients = Ingredient::all();
        $units = Unit::all();
        return view('stock.edit',['metaTitle' => 'اضافة  للمخزون '])
                ->with([
                    'ingredients' => $ingredients ,
                    'units' => $units ,
                    'stock' => $stock
                ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        $this->authorize('update', $stock);
        $this->validate($request,[
            'ingredient_id' => 'required' ,
            'quantity' => 'required' , 
            'total_price' => 'required',
            'unit_id' => 'required'
        ]);

        $ingredient = Ingredient::findOrFail($request->ingredient_id);


        $data = [
            'ingredient_id' => $ingredient->id,
            'quantity' => $request->quantity ,
            'total_price' => $request->total_price,
            'unit_id' => $request->unit_id
        ];

        if($stock->update($data)){
            $request->session()->flash('success','تم تحديث المخزون بنجاح');
            return redirect()->route('stock.index');
        }else {
             return redirect()->route('stock.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
