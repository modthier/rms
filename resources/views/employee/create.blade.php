@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> موظف جديد </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('employee.store') }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
            <div class="form-group">
	            <label> اسم الموظف </label>
	            <input type="text" class="form-control" name="name"  required>
            </div>

            <div class="form-group">
              <label> المرتي الشهري </label>
              <input type="number" class="form-control" name="salary"  required>
            </div>

            <div class="form-group">
              <label> قيمة المرتب في اليوم </label>
              <input type="number" class="form-control" name="day_salary"  required>
            </div>

            <div class="form-group">
              <label>تاريخ التعيين</label>
              <input type="date" name="hire_date" class="form-control" required>
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> حفظ </button>
        </form>

    </div>
</div>


@endsection