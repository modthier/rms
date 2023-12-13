<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredients = Ingredient::orderBy('id','desc')->paginate();

        return view('ingredient.index',compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ingredient.create',['metaTitle' => 'مكون أساسي جديد']);
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
            'ingredient' => 'required'
        ]);

        $ingredient = new Ingredient;

        $ingredient->ingredient = $request->ingredient;

        if($ingredient->save()){
            $request->session()->flash('success','تم حفظ المكون الاساسي بنجاح');
            return redirect()->route('ingredient.index');
        }else {
            
            return redirect()->route('ingredient.create');
        }

    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function edit(Ingredient $ingredient)
    {
        return view('ingredient.edit')->with('ingredient',$ingredient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $this->validate($request,[
            'ingredient' => 'required'
        ]);


        if($ingredient->update(['ingredient' => $request->ingredient])){
            $request->session()->flash('success','تم تحديث المكون الاساسي بنجاح');
            return redirect()->route('ingredient.index');
        }else {
            
            return redirect()->route('ingredient.edit',$ingredient->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        //
    }
}
