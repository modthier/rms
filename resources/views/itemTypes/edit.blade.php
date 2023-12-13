@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> تحديث نوع الصنف </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('itemType.update',$itemType->id) }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
          {{ method_field('PUT') }} 
            <div class="form-group">
	            <label>  نوع الصنف </label>
	            <input type="text" class="form-control" name="type" value="{{ $itemType->type  }}" required="">
            </div>

            <div class="form-group">
              <label>  إسم مجموعة الصنف </label>
              <input type="text" class="form-control" name="label" value="{{ $itemType->label  }}" required="">
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> تحديث </button>
        </form>

    </div>
</div>


@endsection