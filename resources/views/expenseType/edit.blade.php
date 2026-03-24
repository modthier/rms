@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> تعديل نوع منصرف  </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('expenseType.update',$expenseType->id) }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
            @method('PUT')
            <div class="form-group">
                <label> النوع </label>
                <input type="text" name="name" value="{{$expenseType->name}}"  class="form-control" required>
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg"> تحديث </button>
        </form>

    </div>
</div>


@endsection