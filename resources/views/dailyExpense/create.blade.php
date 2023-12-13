@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> منصرف جديد </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('dailyExpense.store') }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
            <div class="form-group">
	            <label> المنصرف </label>
	            <input type="text" class="form-control" name="title"  required>
            </div>

            <div class="form-group">
              <label> القيمة </label>
              <input type="number" class="form-control" name="amount"  required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> حفظ </button>
        </form>

    </div>
</div>


@endsection