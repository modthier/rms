<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Models\PurchaseOrders;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\PurchaseOrderSearchRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', PurchaseOrders::class);
        $pos = PurchaseOrders::with(['supplier', 'user'])->orderBy('created_at', 'desc')->paginate();
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $today = Carbon::today();
        $todayStart = $today->copy()->startOfDay();
        $todayEnd = $today->copy()->endOfDay();

        $total = PurchaseOrders::sum('total_price');
        $total_today = PurchaseOrders::whereBetween('created_at', [$todayStart, $todayEnd])->sum('total_price');
        $total_week = PurchaseOrders::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_price');
        $total_month = PurchaseOrders::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('total_price');

        return view('purchaseOrders.index', ['metaTitle' => 'قائمة المشتريات'])->with([
            'pos' => $pos,
            'total' => $total,
            'total_today' => $total_today,
            'total_week' => $total_week,
            'total_month' => $total_month,
            'suppliers' => Supplier::all(),
        ]);
    }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', PurchaseOrders::class);
        $ingredients = Ingredient::all();
        $units = Unit::all();
        return view('purchaseOrders.create')->with([
            'ingredients' => $ingredients ,
            'units' => $units,
            'suppliers' => Supplier::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        $this->authorize('create', PurchaseOrders::class);
        try {
            DB::transaction(function () use ($request) {
                $quantity = 0;
                foreach ($request->items as $id => $guan) {
                    $quantity += $guan['quantity'];
                }

                $purchase = PurchaseOrders::create([
                    'total_price' => $request->total,
                    'quantity' => $quantity,
                    'supplier_id' => $request->supplier_id,
                    'user_id' => Auth::user()->id,
                    'invoice_number' => $request->invoice_number,
                ]);

                foreach ($request->items as $id => $quantity) {
                    $stockExist = Stock::where('ingredient_id', $id)->where('unit_id', $request->input('unit_id_' . $id))->first();
                    if ($stockExist) {
                        $stockExist->update([
                            'quantity' => $quantity['quantity'] + $stockExist->quantity,
                            'total_price' => $request->input('subtotal_' . $id),
                            'unit_price' => $request->input('subtotal_' . $id) / $quantity['quantity'],
                        ]);

                        $purchase->stock()->attach($stockExist->id, [
                            'ingredient_id' => $id,
                            'quantity' => $quantity['quantity'],
                            'subtotal' => $request->input('subtotal_' . $id),
                            'unit_id' => $request->input('unit_id_' . $id),
                        ]);
                    } else {
                        $stock = Stock::create([
                            'ingredient_id' => $id,
                            'quantity' => $quantity['quantity'],
                            'unit_id' => $request->input('unit_id_' . $id),
                            'total_price' => $request->input('subtotal_' . $id),
                            'unit_price' => $request->input('subtotal_' . $id) / $quantity['quantity'],
                        ]);

                        $purchase->stock()->attach($stock->id, [
                            'ingredient_id' => $id,
                            'quantity' => $quantity['quantity'],
                            'subtotal' => $request->input('subtotal_' . $id),
                            'unit_id' => $request->input('unit_id_' . $id),
                        ]);
                    }
                }
            });

            return redirect()->route('purchaseOrders.index')->with('success','تم حفظ فاتورة الشراء بنجاح');
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchaseOrders = PurchaseOrders::findOrFail($id);
        $this->authorize('view', $purchaseOrders);
        $details = DB::table('purchase_orders')
                    ->select(['purchase_items.subtotal','purchase_items.quantity','ingredients.ingredient',
                    'units.unit','purchase_items.created_at'])
                    ->leftJoin('purchase_items','purchase_items.purchase_id','purchase_orders.id')
                    ->leftJoin('units','purchase_items.unit_id','units.id')
                    ->leftJoin('ingredients','purchase_items.ingredient_id','ingredients.id')
                    ->where('purchase_orders.id',$purchaseOrders->id)
                    ->orderBy('purchase_items.id','desc')
                    ->get();
        return view('purchaseOrders.show',['metaTitle' => 'تفاصيل الفاتورة'])->with([
            'purchaseOrder' => $purchaseOrders,
            'details' => $details
        ]);
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseOrders = PurchaseOrders::findOrFail($id);
        $this->authorize('update', $purchaseOrders);
        $ingredients = Ingredient::all();
        $units = Unit::all();
        $details = DB::table('purchase_orders')
                    ->select(['purchase_items.subtotal','purchase_items.quantity','ingredients.ingredient',
                    'units.unit','purchase_items.created_at','purchase_items.ingredient_id','purchase_items.unit_id'])
                    ->leftJoin('purchase_items','purchase_items.purchase_id','purchase_orders.id')
                    ->leftJoin('units','purchase_items.unit_id','units.id')
                    ->leftJoin('ingredients','purchase_items.ingredient_id','ingredients.id')
                    ->where('purchase_orders.id',$purchaseOrders->id)
                    ->orderBy('purchase_items.id','desc')
                    ->get();
        return view('purchaseOrders.edit',['metaTitle' => 'تعديل فاتورة شراء'])
                ->with([
                    'ingredients' => $ingredients ,
                    'units' => $units ,
                    'purchaseOrder' => $purchaseOrders,
                    'suppliers' => Supplier::all(),
                    'details' => $details,
                ]);
    }

   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(StorePurchaseOrderRequest $request, $id)
    {
        $purchaseOrders = PurchaseOrders::findOrFail($id);
        $this->authorize('update', $purchaseOrders);
        try {
            DB::transaction(function () use ($request, $purchaseOrders) {
                foreach ($purchaseOrders->stock as $item) {
                    $stockExist = Stock::where('id', $item->pivot->stock_id)
                        ->where('ingredient_id', $item->pivot->ingredient_id)
                        ->where('unit_id', $item->pivot->unit_id)
                        ->first();

                    $stockExist->update([
                        'quantity' => $stockExist->quantity - $item->pivot->quantity,
                        'total_price' => $stockExist->total_price - $item->pivot->subtotal,
                    ]);
                }

                $purchaseOrders->stock()->detach();
                $purchaseOrders->delete();

                $quantity = 0;
                foreach ($request->items as $id => $guan) {
                    $quantity += $guan['quantity'];
                }

                $purchase = PurchaseOrders::create([
                    'total_price' => $request->total,
                    'quantity' => $quantity,
                    'supplier_id' => $request->supplier_id,
                    'user_id' => Auth::user()->id,
                    'invoice_number' => $request->invoice_number,
                ]);

                foreach ($request->items as $id => $quantity) {
                    $stockExist = Stock::where('ingredient_id', $id)->where('unit_id', $request->input('unit_id_' . $id))->first();
                    if ($stockExist) {
                        $stockExist->update([
                            'quantity' => $quantity['quantity'] + $stockExist->quantity,
                            'total_price' => $request->input('subtotal_' . $id),
                            'unit_price' => $request->input('subtotal_' . $id) / $quantity['quantity'],
                        ]);

                        $purchase->stock()->attach($stockExist->id, [
                            'ingredient_id' => $id,
                            'quantity' => $quantity['quantity'],
                            'subtotal' => $request->input('subtotal_' . $id),
                            'unit_id' => $request->input('unit_id_' . $id),
                        ]);
                    } else {
                        $stock = Stock::create([
                            'ingredient_id' => $id,
                            'quantity' => $quantity['quantity'],
                            'unit_id' => $request->input('unit_id_' . $id),
                            'total_price' => $request->input('subtotal_' . $id),
                            'unit_price' => $request->input('subtotal_' . $id) / $quantity['quantity'],
                        ]);

                        $purchase->stock()->attach($stock->id, [
                            'ingredient_id' => $id,
                            'quantity' => $quantity['quantity'],
                            'subtotal' => $request->input('subtotal_' . $id),
                            'unit_id' => $request->input('unit_id_' . $id),
                        ]);
                    }
                }
            });

            return redirect()->route('purchaseOrders.index')->with('success','تم تحديث فاتورة الشراء بنجاح');
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    function search(PurchaseOrderSearchRequest $request)  {
        $this->authorize('viewAny', PurchaseOrders::class);
        $pos = new PurchaseOrders;

        if ($request->has('invoice_number') && !empty($request->invoice_number)) {
            $pos = $pos->whereRaw('(id = ? or invoice_number = ?)',[$request->invoice_number,$request->invoice_number]);
        }

        if ($request->has('supplier_id') && !empty($request->supplier_id)) {
            $pos = $pos->where('supplier_id',$request->supplier_id);
        }

        $pos = $pos->orderBy('id','desc')->paginate(20);

        return view('purchaseOrders.search',['metaTitle' => 'نتائج البحث'])->with([
            'pos' => $pos,
            'suppliers' => Supplier::all(),
        ]);
    }
}
