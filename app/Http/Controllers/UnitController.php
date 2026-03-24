<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();

        return view('unit.index',['metaTitle' => 'وحدات القياس'])->with('units',$units);
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
            'unit' => 'required'
        ]);

        $unit = new Unit;

        $unit->unit = $request->unit;

        if ($unit->save()) {
            $request->session()->flash('success','تم حفظ الوحدة بنجاح');
            return redirect()->route('unit.index');
        }else {
            return redirect()->route('unit.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        return view('unit.edit',compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        $this->validate($request,[
            'unit' => 'required'
        ]);

        

        if ($unit->update(['unit'  => $request->unit])) {
            $request->session()->flash('success','تم تحديث الوحدة بنجاح');
            return redirect()->route('unit.index');
        }else {
            return redirect()->route('unit.edit',$unit->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }
}
