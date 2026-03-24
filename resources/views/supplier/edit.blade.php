@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary">  تحديث بيانات  المورد   </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('suppliers.update',$supplier->id) }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
          {{ method_field('PUT') }} 
            <div class="form-group">
	            <label> اسم المورد </label>
	            <input type="text" class="form-control" name="name" value="{{ $supplier->name }}"  required="">
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> تحديث </button>
        </form>

    </div>
</div>


@endsection