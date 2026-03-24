@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> تحديث بيانات الوحدة </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('unit.update',$unit->id) }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }}
          {{ method_field('PUT') }} 
            <div class="form-group">
	            <label> اسم الوحدة </label>
	            <input type="text" class="form-control"  name="unit" value="{{ $unit->unit }}"  required>
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> تحديث </button>
        </form>

    </div>
</div>


@endsection