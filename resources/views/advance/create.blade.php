@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> سلفية </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('advance.store') }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
            <div class="form-group">
	            <label> اسم الموظف </label>
	            <select class="form-control" name="employee_id">
                  <option></option>
                  @foreach($employees as $employee)
                  <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
                <label> قيمة السلفية </label>
                <input type="number" name="amount" class="form-control" required>
            </div>

            <div class="form-group">
              <label> اختر الشهر </label>
              <select name="month" class="form-control" required>
                  <option></option>
                  <option value="Jan">يناير</option>
                  <option value="Feb">فبراير</option>
                  <option value="Mar">مارس</option>
                  <option value="Apr">أبريل</option>
                  <option value="May">مايو</option>
                  <option value="Jun">يونيو </option>
                  <option value="Jul">يوليو</option>
                  <option value="Aug">أغسطس</option>
                  <option value="Sep">سبتمبر</option>
                  <option value="Oct">أكتوبر</option>
                  <option value="Nov">نوفمبر</option>
                  <option value="Dec">ديسمبر  </option>
              </select>
            </div>

            <div class="form-group">
              <label> اختر السنة </label>
              <select class="form-control" name="year" required>
                <option></option>
                <option value="{{ $currentYear }}">{{ $currentYear }}</option>
              </select>
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> حفظ </button>
        </form>

    </div>
</div>


@endsection