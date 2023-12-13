@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> تحديث السلفية </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('advance.update',$advance->id) }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
            {{ method_field('PUT') }}
            <div class="form-group">
	            <label> اسم الموظف </label>
	            <select class="form-control" name="employee_id">
                  <option></option>
                  @foreach($employees as $employee)
                  <option value="{{ $employee->id }}" @if($advance->employee_id == $employee->id) selected @endif>{{ $employee->name }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
                <label> قيمة السلفية </label>
                <input type="number" name="amount" value="{{ $advance->amount }}" class="form-control" required>
            </div>

            <div class="form-group">
              <label> اختر الشهر </label>
              <select name="month" class="form-control" required>
                  <option></option>
                  <option value="Jan" @if($advance->month == "Jan") selected @endif>يناير</option>
                  <option value="Feb" @if($advance->month == "Feb") selected @endif>فبراير</option>
                  <option value="Mar" @if($advance->month == "Mar") selected @endif>مارس</option>
                  <option value="Apr" @if($advance->month == "Apr") selected @endif>أبريل</option>
                  <option value="May" @if($advance->month == "May") selected @endif>مايو</option>
                  <option value="Jun" @if($advance->month == "Jun") selected @endif>يونيو </option>
                  <option value="Jul" @if($advance->month == "Jul") selected @endif>يوليو</option>
                  <option value="Aug" @if($advance->month == "Aug") selected @endif>أغسطس</option>
                  <option value="Sep" @if($advance->month == "Sep") selected @endif>سبتمبر</option>
                  <option value="Oct" @if($advance->month == "Oct") selected @endif>أكتوبر</option>
                  <option value="Nov" @if($advance->month == "Nov") selected @endif>نوفمبر</option>
                  <option value="Dec" @if($advance->month == "Dec") selected @endif>ديسمبر  </option>
              </select>
            </div>

            <div class="form-group">
              <label> اختر السنة </label>
              <select class="form-control" name="year" required>
                <option></option>
                <option value="{{ $currentYear }}" @if($advance->year == $currentYear) selected @endif>{{ $currentYear }}</option>
              </select>
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> تحديث </button>
        </form>

    </div>
</div>


@endsection