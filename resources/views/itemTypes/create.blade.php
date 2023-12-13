@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> نوع صنف جديد </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('itemType.store') }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
            <div class="form-group">
	            <label>  نوع الصنف </label>
	            <input type="text" class="form-control" name="type"  required="">
            </div>

            <div class="form-group">
              <label>  إسم مجموعة الصنف </label>
              <input type="text" class="form-control" name="label"  required="">
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> حفظ </button>
        </form>

    </div>
</div>


@endsection