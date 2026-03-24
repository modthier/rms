<?php

namespace App\Http\Controllers;

use App\Models\RequirementType;
use Illuminate\Http\Request;

class RequirementTypeController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requirementType = RequirementType::all();

        return view('requirementType.index',['metaTitle' => 'انواع احتياجات المطعم'])->with('requirementType',$requirementType);
    }

   
    public function create()
    {
        return view('requirementType.create');
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

        $requirementType = new RequirementType;

        $requirementType->name = $request->name;

        if ($requirementType->save()) {
            $request->session()->flash('success','تم حفظ نوع المتطلب  بنجاح');
            return redirect()->route('requirementType.index');
        }else {
            return redirect()->route('requirementType.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(RequirementType $requirementType)
    {
        return view('requirementType.sh',compact('requirementType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(RequirementType $requirementType)
    {
        return view('requirementType.edit',compact('requirementType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequirementType $requirementType)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        

        $requirementType->name = $request->name;

        if ($requirementType->update(['name' => $request->name ])) {
            $request->session()->flash('success','تم تحديث نوع المتطلب  بنجاح');
            return redirect()->route('requirementType.index');
        }else {
            return redirect()->route('requirementType.edit',$requirementType->id);
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
