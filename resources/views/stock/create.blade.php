@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> اضافة  للمخزون  </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('stock.store') }}" role="form" autocomplete="off" method="POST" enctype="multipart/form-data">
        	{{ csrf_field() }} 
           <div class="form-group">
              <label> الصنف </label>
              <select class="form-control" name="ingredient_id" required="">
                  <option></option>
                  @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}">{{ $ingredient->ingredient }}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label> الكمية </label>
              <input type="number" class="form-control" id="create_quantity" name="quantity"  required="">
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
              <label> السعر الكلي </label>
              <input type="number" class="form-control" id="create_total_price" name="total_price"  required="">
            </div>
            <div class="form-group">
              <label> سعر الوحدة </label>
              <input type="text" class="form-control" id="create_unit_price" name="unit_price"  required="">
            </div>

           


          
            <button type="submit" class="btn btn-primary btn-lg"> حفظ </button>
        </form>

    </div>
</div>


@endsection
@push('js')
<script>
   $('#create_total_price').on('change keyup',function (e) {

		
        var create_total_price = $(this).val();
        var create_quantity = $('#create_quantity').val();
        var total = create_total_price / create_quantity;
        $('#create_unit_price').val(total);
    });
</script>
@endpush