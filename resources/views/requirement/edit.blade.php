@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> تحديث  احتياجات  </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('requirement.update',$requirement->id) }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
          @method('PUT')
           <div class="form-group">
              <label> النوع </label>
              <select class="form-control" name="requirement_type_id" required="">
                  <option></option>
                  @foreach($requirementTypes as $item)
                    <option value="{{ $item->id }}" @if($requirement->requirement_type_id == $item->id ) selected @endif>{{ $item->name }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label> اختر وحدة القياس </label>
              <select class="form-control" name="unit_id" required="">
                  <option></option>
                  @foreach($units as $unit)
                    <option value="{{ $unit->id }}" @if($requirement->unit_id == $unit->id ) selected @endif>{{ $unit->unit }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label> الكمية </label>
              <input type="text" class="form-control" name="quantity" value="{{$requirement->quantity}}" required="">
            </div>

            <div class="form-group">
              <label> السعر الكلي </label>
              <input type="text" class="form-control" name="total_price" value="{{$requirement->total_price}}" required="">
            </div>


          
            <button type="submit" class="btn btn-primary btn-lg"> تحديث </button>
        </form>

    </div>
</div>


@endsection