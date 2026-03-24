@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> اضافة  احتياجات  </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('requirement.store') }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
           <div class="form-group">
              <label> النوع </label>
              <select class="form-control" name="requirement_type_id" required="">
                  <option></option>
                  @foreach($requirementTypes as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label> اختر وحدة القياس </label>
              <select class="form-control" name="unit_id" required="">
                  <option></option>
                  @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label> الكمية </label>
              <input type="text" class="form-control" name="quantity"  required="">
            </div>

            <div class="form-group">
              <label> السعر الكلي </label>
              <input type="text" class="form-control" name="total_price"  required="">
            </div>


          
            <button type="submit" class="btn btn-primary btn-lg"> حفظ </button>
        </form>

    </div>
</div>


@endsection