@extends('layouts.main')

@section('content')

<div class="card mb-3">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> اضافة  فاتورة شراء  </h3>
      </div>
    </div>

    <div class="card-body">
        
          <div class="row">
          <div class="col-lg-12 form-group">
              <label> الصنف </label>
              <select class="form-control sel" name="ingredient_id" id="ingredient_id" required="">
                  <option></option>
                  @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}">{{ $ingredient->ingredient }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          
          
            <button class="btn btn-primary btn-lg add_item_btn" id="add_item_btn">  إضافة صنف </button>
       

    </div>
</div>
<div class="card">
  <form class="form" action="{{ route('purchaseOrders.store') }}" role="form" autocomplete="off" method="POST"  >
        	{{ csrf_field() }} 
    <div class="card-body">

        <div class="row mb-3">
              <div class="col-lg-6 form-group">
                <label> رقم الفاتورة (اختياري) </label>
                <input type="number" class="form-control invoice_number" id="invoice_number" name="invoice_number">
              </div>

              <div class="col-lg-6 form-group">
                  <label> اسم المورد </label>
                  <select class="form-control sel" name="supplier_id" id="supplier_id" required="">
                      <option></option>
                      @foreach($suppliers as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
              </div>
        </div>
        <div id="area">

        </div>

        <h3 style="padding: .75rem 1.25rem;">المجموع : <span class="purchase_total"></span></h3>
        <input type="hidden" id="purchase_total_all" name="total">
    </div>

    <div class="card-footer">
          
      <button type="submit" id="purchaseBtn" disabled class="btn btn-primary btn-lg">حفظ</button> 
          
    </div>
  </form>
</div>

@endsection
@push('js')
<script>
   $('#add_item_btn').on('click',function (e) {

        e.preventDefault();
        var id = $('#ingredient_id').val();
        var name = $('#ingredient_id').find(':selected').text();
        var html = ` 
        <div class="row" id="item_block_${id}">

          <div class="form-group col-lg-4">
              <label> اسم الصنف </label>
              <input type="text" class="form-control" 
              readonly value="${name}"
              required="">
            </div>

            <div class="form-group col-lg-4">
              <label> اختر وحدة القياس </label>
              <select class="form-control unit" name="unit_id_${id}" id="unit_id_${id}" required="">
                  <option></option>
                  @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                  @endforeach
              </select>
            </div>
           <div class="form-group col-lg-4">
              <label> الكمية </label>
              <input type="number" class="form-control p_quantity" id="p_quantity_${id}" name="items[${id}][quantity]"
              data-id="${id}"
              required="">
            </div>

            
            <div class="form-group col-lg-4">
              <label>  المجموع </label>
              <input type="number" class="form-control subtotal" min="0" value="0" id="subtotal_${id}" name="subtotal_${id}"  required="">
            </div>

            <div class="col-lg-4 form-group" style="display: flex;align-items: end;">
              <button type="button" data-id="${id}"
                 class="btn btn-danger delete-item">
                حذف
              </button>
       </div>
        </div>
        `;

        if($('#p_quantity_'+id).length == 0){
     
        $('#area').append(html);
        calc();
        }
    });

    $('.sel').select2();

    $('body').on('click','.delete-item',function(e){

      e.preventDefault();		
      var id = $(this).data('id');

      $('#item_block_'+id).remove();
      calc();

    });

    $('body').on('change','.subtotal',function(e){
      calc();

    });

    function calc() {
    var price = 0.0;
    $('#area .subtotal').each(function(index){
      
      price += parseFloat($(this).val());
      
    });

    $('.purchase_total').html(price.toFixed(2));
    $('#purchase_total_all').val(price.toFixed(2));
    
    if (price > 0) {
		$('#purchaseBtn').attr('disabled',false);
    }else {
      $('#purchaseBtn').attr('disabled','disabled');
    }
}
</script>
@endpush