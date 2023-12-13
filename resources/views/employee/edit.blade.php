@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> تحديث بيانات الموظف </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('employee.update',$employee->id) }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }}
          {{ method_field('PUT') }} 
            <div class="form-group">
	            <label> اسم الموظف </label>
	            <input type="text" class="form-control"  name="name" value="{{ $employee->name }}"  required>
            </div>

            <div class="form-group">
              <label> المرتي الشهري </label>
              <input type="number" class="form-control" name="salary" value="{{ $employee->salary }}"  required>
            </div>

            <div class="form-group">
              <label> قيمة المرتب في اليوم </label>
              <input type="number" class="form-control" name="day_salary" value="{{ $employee->day_salary }}" required>
            </div>

            <div class="form-group">
              <label>تاريخ التعيين</label>
              <input type="date" name="hire_date" class="form-control" value="{{ $employee->hire_date }}" required>
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> تحديث </button>
        </form>

    </div>
</div>


@endsection