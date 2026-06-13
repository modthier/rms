@extends('layouts.main')

@section('content')

<div class="card">
   <div class="card-header">
      <div class="card-title">
                <h3 class="text-primary">  تعديل اسم المطعم </h3>
      </div>
    </div>

    <div class="card-body">
        
        <form class="form" action="{{ route('setting.update',$setting->id) }}" role="form" autocomplete="off" method="POST">
        	{{ csrf_field() }} 
          {{ method_field('PUT') }}
            <div class="form-group">
	            <label> اسن المطعم </label>
	            <input type="text" class="form-control" name="name" value="{{ $setting->name }}" required="">
            </div>

            @include('setting.partials.receipt-mode-field', [
                'selectedReceiptMode' => $setting->receipt_mode ?? \App\Models\Setting::RECEIPT_MODE_DUAL,
            ])
          
            <button type="submit" class="btn btn-primary btn-lg" id="btnLogin"> تعديل </button>
        </form>

    </div>
</div>


@endsection