<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Rules\AttendanceExiestRule;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();
        
        $attendances = Attendance::whereDate('created_at',$today)
                    ->orderBy('created_at')->paginate();

        
        return view('attendance.index',['metaTitle' => 'قائمة الحضور'])
            ->with('attendances',$attendances);
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
            'employee_id' => ['required', new AttendanceExiestRule()]
        ]);

        $now = Carbon::now();
        $currentYear = $now->year;
        $currentMonth = $now->format('M');

        

        $attendance = new  Attendance;

        $employee = Employee::findOrFail($request->employee_id);

        $attendance->employee()->associate($employee);
        $attendance->month = $currentMonth;
        $attendance->year = $currentYear;

        if($attendance->save()){
            $request->session()->flash('success','تم تسجيل الحضور بنجاح');
            return redirect()->route('attendance.index');
        }else {
             return redirect()->route('attendance.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
