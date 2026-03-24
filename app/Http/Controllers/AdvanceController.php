<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Rules\AdvanceMonthRule;
use App\Rules\AdvanceExiestRule;

class AdvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advances = Advance::orderBy('created_at','desc')->paginate();

        return view('advance.index',['metaTitle' => 'السلفيات'])->with('advances',$advances);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $now = Carbon::now();
        $currentYear = $now->year;
        $employees = Employee::all();




        return view('advance.create',['metaTitle' => 'إضافة سلفية'])
                ->with(['employees' => $employees , 'currentYear' => $currentYear]);
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
            'employee_id' => 'required',
            'amount' => 'required',
            'month' => 'required',
            'year' => 'required',
        ]);


        $data = [
            'employee_id' => $request->employee_id,
            'amount' => $request->amount,
            'month' => $request->month,
            'year' => $request->year,
        ];
        

        if (Advance::create($data)) {
            $request->session()->flash('success','تم تحديث السلفية بنجاح');
            return redirect()->route('advance.index');
        }else {
            return redirect()->route('advance.edit',$advance->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function show(Advance $advance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function edit(Advance $advance)
    {
        $now = Carbon::now();
        $currentYear = $now->year;
        $employees = Employee::all();

        return view('advance.edit',['metaTitle' => 'تعديل سلفية'])
                ->with(
                    ['employees' => $employees ,
                     'currentYear' => $currentYear , 
                     'advance' => $advance ]
                );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advance $advance)
    {
        $this->validate($request,[
            'employee_id' => 'required',
            'amount' => 'required',
            'month' => 'required',
            'year' => 'required',
        ]);


        $data = [
            'employee_id' => $request->employee_id,
            'amount' => $request->amount,
            'month' => $request->month,
            'year' => $request->year,
        ];
        

        if ($advance->update($data)) {
            $request->session()->flash('success','تم تحديث السلفية بنجاح');
            return redirect()->route('advance.index');
        }else {
            return redirect()->route('advance.edit',$advance->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advance $advance)
    {
        //
    }
}
