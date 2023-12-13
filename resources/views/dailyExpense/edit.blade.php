@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> تعديل منصرف </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('dailyExpense.update',$dailyExpense->id) }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
          {{ method_field('PUT') }} 
            <div class="form-group">
	            <label> المنصرف </label>
	            <input type="text" class="form-control" name="title" 
               value="{{ $dailyExpense->title }}" required>
            </div>

            <div class="form-group">
              <label> القيمة </label>
              <input type="number" class="form-control" name="amount"  
               value="{{ $dailyExpense->amount }}" required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> تحديث </button>
        </form>

    </div>
</div>


@endsection