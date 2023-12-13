<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Unit;
use App\Models\PurchaseOrders;
use DB;
use Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::orderBy('created_at','desc')->paginate();

        return view('stock.index',['metaTitle' => 'قائمة المحزون'])->with('stocks',$stocks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    public function store(Request $request)
    {
        $this->validate($request,[
            'ingredient_id' => 'required' ,
            'quantity' => 'required' , 
            'total_price' => 'required',
            'unit_id' => 'required',
            'unit_price' => 'required'
        ]);

      
        $stock = new  Stock;
        $purchaseOrder = new PurchaseOrders;

        $ingredient = Ingredient::findOrFail($request->ingredient_id);


        DB::beginTransaction();

        try {

            $unit_price = $request->unit_price ;

            $stock->ingredient()->associate($ingredient);
            $stock->quantity = $request->quantity;
            $stock->total_price = $request->total_price;
            $stock->unit_id = $request->unit_id;
            $stock->unit_price = $unit_price;

            $stock->save();

            $purchaseOrder->total_price = $request->total_price;
            $purchaseOrder->quantity = $request->quantity;
            $purchaseOrder->stock()->associate($stock->id);
            $purchaseOrder->user()->associate(Auth::id());
            $purchaseOrder->save();

            DB::commit();

            $request->session()->flash('success','تمت الاضافة بنجاح');
            return redirect()->route('stock.index');
            
        } catch (Exception $e) {
            DB::rollBack();
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
