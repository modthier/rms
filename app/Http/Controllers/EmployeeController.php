<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::orderBy('id')->paginate();

        return view('employee.index',['metaTitle' => 'قائمة الموظفين'],compact('employees'));
    }

    public function getEmployee(Request $request)
    {

        $today = date('Y-m-d');

       if($request->search == ''){
        $employees = Employee::limit(5)->get();
       }else {
        $employees = Employee::where('name','like','%'.$request->search.'%')->get();
       }

       $response = array();

       foreach ($employees as $employee) {
           $response[] = array(
              'id' => $employee->id ,
              'text' => $employee->name
           );
       }

       echo json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.create',['metaTitle' => 'موظف جديد']);
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
            'name' => 'required' ,
            'salary' => 'required' ,
            'day_salary' => 'required' ,
            'hire_date' => 'required|before_or_equal:today' 

        ]);

        $employee = new Employee;

        $employee->name = $request->name;
        $employee->salary = $request->salary;
        $employee->day_salary = $request->day_salary;
        $employee->hire_date = $request->hire_date;

        if($employee->save()){
            $request->session()->flash('success','تم حفظ الموظف بنجاح');
            return redirect()->route('employee.index');
        }else {
            
            return redirect()->route('employee.create');
        }
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit',['metaTitle' => 'تحديث بيانات الموظف'],compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request,[
            'name' => 'required' ,
            'salary' => 'required' ,
            'day_salary' => 'required' ,
            'hire_date' => 'required' 

        ]);

        $data = [
            'name' => $request->name,
            'salary' => $request->salary,
            'day_salary' => $request->day_salary,
            'hire_date' => $request->hire_date
        ];

        

        if($employee->update($data)){
            $request->session()->flash('success','تم تحديث بيانات العميل بنجاح');
            return redirect()->route('employee.index');
        }else {
            
            return redirect()->route('employee.edit',$employee->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }


    public function calculateSalary()
    {
        $now = Carbon::now();
        $currentYear = $now->year;
        $currentMonth = $now->format('M');

        $employee = new Employee;


        $salaries = DB::table('employees as e')
                    ->select(['e.id','e.name','e.day_salary',
                        DB::raw('count(a.employee_id) as attendance')])
                    ->leftJoin('attendances as a','a.employee_id','=','e.id')
                    ->where('a.month',$currentMonth)
                    ->where('a.year',$currentYear)
                    ->groupBy('e.id')
                    ->get();
        $sa = [];
        foreach ($salaries as $salary) {
            $sa[] = [
                'name' => $salary->name ,
                'attendance' => $salary->attendance ,
                'advance' => $employee->getAdvance($salary->id) ,
                'day_salary' => $salary->day_salary
            ];

            
        }
        
        
       
        
        $now = Carbon::now();
        $currentMonth = $now->format('M');
        

        return view('employee.calculateSalary')
                ->with([
                    'salaries' => $sa ,
                    'currentMonth' => $currentMonth 
                ]);

    }
}
