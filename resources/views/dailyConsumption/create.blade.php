@extends('layouts.main')

@section('content')

@if(session('errs'))
  <section class="col-lg-12">

    @foreach(session('errs') as $err)
    <div class="alert alert-danger" role="alert">
      {{ $err }}
    </div>
    @endforeach

  </section>
  @endif

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary"> سحب من المخزون </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('dailyConsumption.store') }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 

            <div class="form-group">
              <label> اختر المخزون </label>
              <select id="dailyConsumption" class="form-control" name="stock_id" required>
                  <option></option>
                  @foreach($stocks as $stock)
                  <option data-quantity="{{ $stock->quantity }}" value="{{ $stock->id }}">{{ $stock->ingredient->ingredient }} - {{ date_format($stock->created_at,'d/m/Y') }} </option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
	            <label> الكمية المتوفرة </label>
	            <input type="text" id="remaining_quantity" class="form-control" name="remaining_quantity"  required>
            </div>

            <div class="form-group">
              <label> الكمية المطلوبة </label>
              <input type="number" class="form-control quantity" id="requested_quantity" name="quantity"  required>
            </div>
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> سحب من المخزون </button>
        </form>

    </div>
</div>


@endsection