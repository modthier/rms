@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> إضافة طريقة دفع </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('payment.store') }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
            <div class="form-group">
	            <label> طريقة الدفع </label>
	            <input type="text" class="form-control" name="method"  required="">
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> حفظ </button>
        </form>

    </div>
</div>


@endsection