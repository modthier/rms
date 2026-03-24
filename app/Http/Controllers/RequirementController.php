<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Requirement;
use Illuminate\Http\Request;
use App\Models\RequirementType;
use App\Models\RequirmentChange;
use App\Http\Requests\RequirmentFormRequest;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requirements = Requirement::orderBy('id','desc')->paginate(20);
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $today = Carbon::today();
        $todayStart = $today->copy()->startOfDay();
        $todayEnd = $today->copy()->endOfDay();

        $total = Requirement::sum('total_price');
        $total_today = Requirement::whereBetween('created_at', [$todayStart, $todayEnd])->sum('total_price');
        $total_week = Requirement::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_price');
        $total_month = Requirement::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('total_price');

        return view('requirement.index',['metaTitle' => ' احتياجات المطعم'])->with([
            'requirements' => $requirements,
            'total' => $total ,
            'total_today' => $total_today ,
            'total_week' => $total_week ,
            'total_month' => $total_month,   
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requirementTypes = RequirementType::all();
        $units = Unit::all();
        return view('requirement.create',compact('requirementTypes','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequirmentFormRequest $request)
    {
        if(Requirement::create($request->validated())){
            $request->session()->flash('success','تم حفظ الاحتياجات بنجاح');
            return redirect()->route('requirement.index');
        }else {
            return redirect()->route('requirement.create')->withInputs();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function show(Requirement $requirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function edit(Requirement $requirement)
    {
        $requirementTypes = RequirementType::all();
        $units = Unit::all();
        return view('requirement.edit',compact('requirement','requirementTypes','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function update(RequirmentFormRequest $request, Requirement $requirement)
    {
        $data =  [
            'requirement_id' => $requirement->id,
            'quantity' => $requirement->quantity,
            'total_price' => $requirement->total_price,
            'requirement_type_id' => $requirement->requirement_type_id,
            'unit_id' => $requirement->unit_id,
        ];

        RequirmentChange::create($data);

        if($requirement->update($request->validated())){
            $request->session()->flash('success','تم تحديث الاحتياجات بنجاح');
            return redirect()->route('requirement.index');
        }else {
            return redirect()->route('requirement.edit',$requirement->id)->withInputs();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requirement $requirement,Request $request)
    {
        $requirement->delete();
        $request->session()->flash('success','تم حذف الاحتياجات بنجاح');
        return back();
    }


    public function change($id)
    {
        $requirement = Requirement::find($id);
       
        $requirementChange = RequirmentChange::where('requirement_id',$requirement->id)
                ->orderBy('id','desc')
                ->get();
        
        $view = view('requirement.change')
        ->with([
             'requirement' => $requirement ,
             'requirementChange' => $requirementChange
        ])->render();

        echo $view;
    }

    public function showReqReport(){
        $requirements = Requirement::orderBy('id','desc')->paginate(20);
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $today = Carbon::today();
        $todayStart = $today->copy()->startOfDay();
        $todayEnd = $today->copy()->endOfDay();

        $total = Requirement::sum('total_price');
        $total_today = Requirement::whereBetween('created_at', [$todayStart, $todayEnd])->sum('total_price');
        $total_week = Requirement::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_price');
        $total_month = Requirement::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('total_price');

        return view('requirement.report',['metaTitle' => 'تقرير الاحتياجات'])->with([
            'requirements' => $requirements,
            'total' => $total ,
            'total_today' => $total_today ,
            'total_week' => $total_week ,
            'total_month' => $total_month,   
        ]);
    }
}
