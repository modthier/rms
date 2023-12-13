<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\ItemType;
use App\Models\Unit;
use Storage;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('id','desc')->paginate();

        return view('items.index',['metaTitle' => 'جميع الاصناف'],compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemTypes = ItemType::all();
        $ingredients = Ingredient::all();
        $units = Unit::all();

        return view('items.create',['metaTitle' => 'صنف جديد'],compact('itemTypes','ingredients','units'));
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
            'name' => 'required',
            'price' => 'required',
            'icon' => 'required|image|max:10000',
            'item_type_id' => 'required',
            'ingredient_id' => 'required'
         ]);



        if ($request->hasFile('icon')) {
            $file = $request->icon;
            $icon = uniqid().".".$file->getClientOriginalExtension();
            $file->storeAs('images\items',$icon,'public');
        }


        $item = new Item;

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'icon' => $icon,
            'item_type_id' => $request->item_type_id,
            'ingredient_id' => $request->ingredient_id
        ];

        if($item::create($data)) {
            $request->session()->flash('success','تم حفظ الصنف بنجاح');
            return redirect()->route('item.index');
        }else {
            return redirect()->route('item.create');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $itemTypes = ItemType::all();
        $ingredients = Ingredient::all();
        $units = Unit::all();

        return view('items.edit',['metaTitle' => 'تحديث صنف'],compact('itemTypes','ingredients','item','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'weight' => 'required' ,
            'icon' => 'image|max:10000',
            'item_type_id' => 'required',
            'ingredient_id' => 'required',
            'unit_id' => 'required'
         ]);

        if ($request->hasFile('icon')) {
            $file = $request->icon;
            $icon = uniqid().".".$file->getClientOriginalExtension();
            $file->storeAs('images\items',$icon,'public');

            Storage::disk('items')->delete($item->image);
        }else {
            $icon = $item->icon;
        }

        

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'weight' => $request->weight,
            'icon' => $icon,
            'item_type_id' => $request->item_type_id,
            'ingredient_id' => $request->ingredient_id,
            'unit_id' => $request->unit_id
        ];

        if($item->update($data)) {
            $request->session()->flash('success','تم تحديث الصنف بنجاح');
            return redirect()->route('item.index');
        }else {
            return redirect()->route('item.edit',$item->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
