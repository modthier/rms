<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ExpenseType;
use App\Models\DailyExpense;
use Illuminate\Http\Request;
use App\Models\ExpenseChange;
use Illuminate\Support\Facades\DB;

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
        $expenseTypes = ExpenseType::all();    
        return view('dailyExpense.index',['metaTitle' => 'المنصرفات '])->with([
            'dailyExpenses'=>  $dailyExpenses,
            'expenseTypes'=>  $expenseTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expenseTypes = ExpenseType::all();
        return view('dailyExpense.create',['metaTitle' => 'منصرف جديد'],compact('expenseTypes'));
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
            'expense_type_id' => 'required' ,
            'amount' => 'required',
        ]);


        $dailyExpense = new  DailyExpense;

        $user = User::findOrFail(Auth::id());

        $dailyExpense->user()->associate($user);
        $dailyExpense->expense_type_id = $request->expense_type_id;
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
        $expenseTypes = ExpenseType::all();
        return view('dailyExpense.edit',['metaTitle' => 'تعديل منصرف'])->with([
            'dailyExpense'=> $dailyExpense,
            'expenseTypes'=> $expenseTypes,
        ]);
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
            'expense_type_id' => 'required' ,
            'amount' => 'required'
        ]);
        
        $user = User::findOrFail(Auth::id());

        $change =  [
            'daily_expense_id' => $dailyExpense->id,
            'expense_type_id' => $dailyExpense->expense_type_id ,
            'amount' => $dailyExpense->amount,
            'user_id' => $user->id,
        ];

        ExpenseChange::create($change);


        $data = [
            'expense_type_id' => $request->expense_type_id ,
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

    public function change($id)
    {
        $DailyExpense = DailyExpense::find($id);
       
        $DailyExpenseChange = ExpenseChange::where('daily_expense_id',$DailyExpense->id)
                ->orderBy('id','desc')
                ->get();
        
        $view = view('dailyExpense.change')
        ->with([
             'DailyExpense' => $DailyExpense ,
             'DailyExpenseChange' => $DailyExpenseChange
        ])->render();

        echo $view;
    }

    public function showExpenseReport(){

        $dailyExpenses = DailyExpense::orderBy('created_at','desc')->paginate();

        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $expenseTypes = ExpenseType::all(); 
        $today = Carbon::today();

        $total = DB::table('daily_expenses')->where('deleted_at',null)->sum('amount');

        $total_today = DB::table('daily_expenses')->where('deleted_at',null)->whereDate('created_at',$today)->sum('amount');
        
        $total_week = DB::table('daily_expenses')->where('deleted_at',null)->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('amount');

        $total_month = DB::table('daily_expenses')->where('deleted_at',null)->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->sum('amount');
        return view('dailyExpense.report',['metaTitle' => 'تقرير المنصرفات'])->with([
                'dailyExpenses'=> $dailyExpenses,
                'total'=> $total,
                'total_today'=> $total_today,
                'total_week'=> $total_week,
                'total_month'=> $total_month,
                'expenseTypes'=>  $expenseTypes,
        ]);
    }

    public function search(Request $request)
    {
        $dailyExpenses = new DailyExpense;
        $dailyExpenses = $dailyExpenses->where('expense_type_id',$request->expense_type_id)
        ->whereRaw('Date(created_at) between ? and ?',[$request->date_from,$request->date_to]);
        $total = $dailyExpenses->sum('amount');
        $dailyExpenses = $dailyExpenses->paginate(20);
        
        $expenseTypes = ExpenseType::all(); 
       
        return view('dailyExpense.search',['metaTitle' => 'نتيجة البحث'])
                ->with([
                    'dailyExpenses' => $dailyExpenses ,
                    'expenseTypes'=>  $expenseTypes,
                    'total'=>  $total,   
                ]);
    }
}
