@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> تحديث  للمخزون  </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('stock.update',$stock->id) }}" role="form" autocomplete="off" method="POST" enctype="multipart/form-data">
        	{{ csrf_field() }} 
          {{ method_field('PUT') }} 
           <div class="form-group">
              <label> الصنف </label>
              <select class="form-control" name="ingredient_id" required="">
                  <option></option>
                  @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}" 
                      @if($stock->ingredient->id == $ingredient->id)
                      selected
                      @endif 
                      >{{ $ingredient->ingredient }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label> الكمية </label>
              <input type="number" class="form-control" name="quantity"  
              value="{{ $stock->quantity }}" required="">
            </div>

            <div class="form-group">
              <label> اختر وحدة القياس </label>
              <select class="form-control" name="unit_id" required="">
                  <option></option>
                  @foreach($units as $unit)
                    <option value="{{ $unit->id }}"
                      @if($stock->unit->id == $unit->id)
                      selected
                      @endif 
                      >{{ $unit->unit }}</option>
                  @endforeach
              </select>
            </div>


            <div class="form-group">
              <label> السعر الكلي </label>
              <input type="number" class="form-control" name="total_price" 
              value="{{ $stock->total_price }}"  required="">
            </div>


          
            <button type="submit" class="btn btn-primary btn-lg"> حفظ </button>
        </form>

    </div>
</div>


@endsection