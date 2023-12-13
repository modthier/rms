<?php

namespace App\Http\Controllers;

use App\Models\DailyExpense;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class DailyExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dailyExpenses = DailyExpense::orderBy('created_at','desc')->paginate();

        return view('dailyExpense.index',['metaTitle' => 'المنصرفات '])->with('dailyExpenses',$dailyExpenses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dailyExpense.create',['metaTitle' => 'منصرف جديد']);
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
            'title' => 'required' ,
            'amount' => 'required'
        ]);


        $dailyExpense = new  DailyExpense;

        $user = User::findOrFail(Auth::id());

        $dailyExpense->user()->associate($user);
        $dailyExpense->title = $request->title;
        $dailyExpense->amount = $request->amount;

        if($dailyExpense->save()){
            $request->session()->flash('success','تم حفظ المنصرف بنجاح');
            return redirect()->route('dailyExpense.index');
        }else {
             return redirect()->route('dailyExpense.created');
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DailyExpense  $dailyExpense
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyExpense $dailyExpense)
    {
        return view('dailyExpense.edit',['metaTitle' => 'تعديل منصرف'])->with('dailyExpense',$dailyExpense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DailyExpense  $dailyExpense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyExpense $dailyExpense)
    {
        $this->validate($request,[
            'title' => 'required' ,
            'amount' => 'required'
        ]);


        $data = [
            'title' => $request->title ,
            'amount' => $request->amount
        ];


        if($dailyExpense->update($data)){
            $request->session()->flash('success','تم تحديث المنصرف بنجاح');
            return redirect()->route('dailyExpense.index');
        }else {
             return redirect()
             ->route('dailyExpense.edit',$dailyExpense->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DailyExpense  $dailyExpense
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyExpense $dailyExpense)
    {
        $dailyExpense->delete();
        return redirect()->route('dailyExpense.index');
    }
}
