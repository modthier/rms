<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ExpenseType;
use App\Models\DailyExpense;
use Illuminate\Http\Request;
use App\Models\ExpenseChange;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Requests\DailyExpenseSearchRequest;

class DailyExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', DailyExpense::class);
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
        $this->authorize('create', DailyExpense::class);
        $expenseTypes = ExpenseType::all();
        return view('dailyExpense.create',['metaTitle' => 'منصرف جديد'],compact('expenseTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseRequest $request)
    {
        $this->authorize('create', DailyExpense::class);
        try {
            DB::transaction(function () use ($request) {
                $dailyExpense = new DailyExpense;
                $user = User::findOrFail(Auth::id());
                $dailyExpense->user()->associate($user);
                $dailyExpense->expense_type_id = $request->expense_type_id;
                $dailyExpense->amount = $request->amount;
                $dailyExpense->save();
            });
            $request->session()->flash('success','تم حفظ المنصرف بنجاح');
            return redirect()->route('dailyExpense.index');
        } catch (Exception $e) {
            Log::error('Daily expense store failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            $request->session()->flash('error', 'حدث خطأ أثناء حفظ المنصرف');
            return redirect()->route('dailyExpense.create');
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
        $this->authorize('update', $dailyExpense);
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
    public function update(UpdateExpenseRequest $request, DailyExpense $dailyExpense)
    {
        $this->authorize('update', $dailyExpense);
        try {
            DB::transaction(function () use ($request, $dailyExpense) {
                $user = User::findOrFail(Auth::id());

                $change = [
                    'daily_expense_id' => $dailyExpense->id,
                    'expense_type_id' => $dailyExpense->expense_type_id,
                    'amount' => $dailyExpense->amount,
                    'user_id' => $user->id,
                ];
                ExpenseChange::create($change);

                $dailyExpense->update([
                    'expense_type_id' => $request->expense_type_id,
                    'amount' => $request->amount,
                ]);
            });
            $request->session()->flash('success','تم تحديث المنصرف بنجاح');
            return redirect()->route('dailyExpense.index');
        } catch (Exception $e) {
            Log::error('Daily expense update failed', [
                'daily_expense_id' => $dailyExpense->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            $request->session()->flash('error', 'حدث خطأ أثناء تحديث المنصرف');
            return redirect()->route('dailyExpense.edit', $dailyExpense->id);
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
        $this->authorize('delete', $dailyExpense);
        try {
            DB::transaction(function () use ($dailyExpense) {
                $dailyExpense->delete();
            });
        } catch (Exception $e) {
            Log::error('Daily expense delete failed', [
                'daily_expense_id' => $dailyExpense->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('dailyExpense.index')->with('error', 'تعذر حذف المنصرف');
        }

        return redirect()->route('dailyExpense.index');
    }

    public function change($id)
    {
        $DailyExpense = DailyExpense::findOrFail($id);
        $this->authorize('view', $DailyExpense);
       
        $DailyExpenseChange = ExpenseChange::where('daily_expense_id',$DailyExpense->id)
                ->orderBy('id','desc')
                ->get();
        
        return view('dailyExpense.change')->with([
            'DailyExpense' => $DailyExpense,
            'DailyExpenseChange' => $DailyExpenseChange,
        ]);
    }

    public function showExpenseReport()
    {
        $this->authorize('viewAny', DailyExpense::class);
        $dailyExpenses = DailyExpense::orderBy('created_at', 'desc')->paginate();

        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $expenseTypes = ExpenseType::all();
        $today = Carbon::today();
        $todayStart = $today->copy()->startOfDay();
        $todayEnd = $today->copy()->endOfDay();

        $total = DailyExpense::sum('amount');
        $total_today = DailyExpense::whereBetween('created_at', [$todayStart, $todayEnd])->sum('amount');
        $total_week = DailyExpense::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
        $total_month = DailyExpense::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('amount');

        return view('dailyExpense.report', ['metaTitle' => 'تقرير المنصرفات'])->with([
            'dailyExpenses' => $dailyExpenses,
            'total' => $total,
            'total_today' => $total_today,
            'total_week' => $total_week,
            'total_month' => $total_month,
            'expenseTypes' => $expenseTypes,
        ]);
    }

    public function search(DailyExpenseSearchRequest $request)
    {
        $this->authorize('viewAny', DailyExpense::class);
        $from = Carbon::parse($request->date_from)->startOfDay();
        $to = Carbon::parse($request->date_to)->endOfDay();
        $dailyExpenses = new DailyExpense;
        $dailyExpenses = $dailyExpenses->where('expense_type_id',$request->expense_type_id)
        ->whereBetween('created_at', [$from, $to]);
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
