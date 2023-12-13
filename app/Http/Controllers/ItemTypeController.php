<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemTypes = ItemType::orderBy('id','desc')->paginate();

        return view('itemTypes.index',['metaTitle' => 'انواع الأصناف'],compact('itemTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('itemTypes.create');
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
            'type' => 'required',
            'label' => 'required'
        ]);

        $itemType = new ItemType;

        $itemType->type = $request->type;
        $itemType->label = $request->label;

        if($itemType->save()){
            $request->session()->flash('success','تم حفظ نوع الصنف بنجاح');
            return redirect()->route('itemType.index');
        }else {
            return redirect()->route('itemType.create');
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemType $itemType)
    {
        return view('itemTypes.edit',['metaTitle' => 'تحديث نوع الصنف'])->with('itemType',$itemType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemType $itemType)
    {
         $this->validate($request,[
            'type' => 'required',
            'label' => 'required'
        ]);


        if($itemType->update([
            'type' => $request->type,
            'label' => $request->label
        ])){
            $request->session()->flash('success','تم تحديث نوع الصنف بنجاح');
            return redirect()->route('itemType.index');
        }else {
            return redirect()->route('itemType.edit',$itemType->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemType $itemType)
    {
        //
    }
}
