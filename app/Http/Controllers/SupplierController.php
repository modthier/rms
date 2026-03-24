<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.index',['metaTitle' => 'قائمة الموردين'])->with([
            'suppliers' => Supplier::orderBy('id','desc')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.create',['metaTitle' => 'إضافة مورد  جديد']);
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
            'name' => 'required'
        ]);

        $data = ['name' => $request->name];
        $supplier = Supplier::create($data);
        if ($supplier) {
            $request->session()->flash('success','تم حفظ  المورد بنجاح');
            return redirect()->route('suppliers.index');
        }else{
            return redirect()->route('suppliers.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        $invoices = $supplier->purchaseOrders()->orderBy('id','desc')->paginate(20);
        return view('supplier.show',['metaTitle' => 'عرض بيانات  المورد'])->with([
            'supplier' => $supplier,
            'invoices' =>  $invoices,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit',['metaTitle' => 'تحديث بيانات  المورد'])->with('supplier',$supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        $data = ['name' => $request->name];
        
        if ($supplier->update($data)) {
            $request->session()->flash('success','تم تحديث  المورد بنجاح');
            return redirect()->route('suppliers.index');
        }else{
            return redirect()->route('suppliers.edit',$supplier->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
