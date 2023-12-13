@extends('layouts.cashier')

@section('content')

@include('cashier/nav')

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="accordion" id="accordionExample">
				 @foreach($types as $type)
				 <div class="accordion-item">
				    <h2 class="accordion-header" id="headingOne">
				      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#cat_{{ $type->id }}" aria-expanded="true" aria-controls="cat_{{ $type->id }}">
				        {{ $type->label }}
				      </button>
				    </h2>
				    <div id="cat_{{ $type->id }}" class="accordion-collapse collapse @if ($loop->first) show @endif" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
				      <div class="accordion-body bg-white">
				      	 <div class="d-flex products">
				      	 	@foreach($type->items as $item)
				      	 	<div class="item border" data-name="{{ $item->name }}"
				      	 		 data-price="{{ $item->price }}" data-id="{{ $item->id }}">
					          <img src="{{ asset('storage/images/items/'.$item->icon) }}">
					          <span class="text-center"> {{ $item->name }} </span>
					        </div>
					        @endforeach
				      	 </div>
				      </div>

				    </div>

                </div>
                @endforeach
			</div>

		</div>
	

	<div class="col-lg-6">
	  <div class="card" id="salesPoint">    
     
      <form id="myForm" action="{{ route('cashier.store') }}" method="post">


        {{ csrf_field() }} 

        <div class="form-group mb-3 p-2">
        	<label class="mb-2"> طريقة الدفع </label>
        	<select name="payment_id" class="form-control" required>
        		@foreach($payments as $payment)
        		<option value="{{ $payment->id }}">{{ $payment->method }}</option>
        		@endforeach
        	</select>
        </div>
        
        <div class="card-body table-responsive p-0">
          <table class="table table-hovered">
              <thead>
                  <th> اسم الصنف </th>
                  <th>الكمية</th>
                  <th>السعر</th>
                  <th>عمليات</th>
              </thead>

              <tbody class="order_list">
                
              </tbody>
          </table>

          
            <h3 style="padding: .75rem 1.25rem;">المجموع : <span class="total"></span></h3>
            <input type="hidden" id="total_all" name="total">
        </div>
         <div class="card-footer">
          
              <button type="submit" id="orderBtn" disabled class="btn btn-primary btn-lg">حفظ</button> 
          
         </div>
      </form>
           

      </div>

      <div id="printArea">
      	
      </div>
      
	</div>

</div>
</div>


@endsection