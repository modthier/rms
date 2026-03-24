<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenseType = ExpenseType::all();

        return view('expenseType.index',['metaTitle' => 'انواع  المنصرفات'])->with('expenseType',$expenseType);
    }

   
    public function create()
    {
        return view('expenseType.create');
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

        $expenseType = new ExpenseType;

        $expenseType->name = $request->name;

        if ($expenseType->save()) {
            $request->session()->flash('success','تم حفظ نوع المنصرف  بنجاح');
            return redirect()->route('expenseType.index');
        }else {
            return redirect()->route('expenseType.create');
        }
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseType $expenseType)
    {
        return view('expenseType.edit',compact('expenseType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseType $expenseType)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        

        $expenseType->name = $request->name;

        if ($expenseType->update(['name' => $request->name ])) {
            $request->session()->flash('success','تم تحديث نوع المنصرف  بنجاح');
            return redirect()->route('expenseType.index');
        }else {
            return redirect()->route('expenseType.edit',$expenseType->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequirementType $requirementType)
    {
        //
    }
}
