@extends('layouts.cashier')

@section('content')

@include('cashier/nav')

<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<div class="card mb-2">
				<div class="card-header">
					<div class="card-title">
						<h3 class="text-primary"> تفاصيل المعاملة </h3>
					</div>
				</div>

				<div class="card-body p-0">
					<table class="table table-hovered table-lg">
						<th> اسم الصنف </th>
						<th> سعر الصنف </th>
						<th> الكمية </th>
						<th> المجموع </th>

						@foreach($order->items as $item)
							<tr>
								<td>{{ $item->name }}</td>
								<td>
									{{ $item->pivot->price / $item->pivot->quantity }}
								</td>
								<td>{{ $item->pivot->quantity }}</td>
								<td>{{ $item->pivot->price }}</td>
							</tr>
						@endforeach
					</table>
				</div>

			</div>
		</div>

		<div class="col-lg-4">
			<div class="small-box bg-white">
		          <div class="inner">
		            <h3>{{ number_format($order->total_price,2) }} جنيه</h3>

		            <p><strong> المجموع </strong></p>
		          </div>
		          
		    </div>
	   </div>
	</div>

    <h1 class="mt-3">طباعة الفاتورة</h1>
	@if($order->items->count() > 1)
	<div class="row mb-3">
		 @foreach($order->items as $item)
	     <div class="col-lg-4">
		   <div class="card">
				<div class="card-body" id="print{{ $item->pivot->id }}">
					<h3 style="text-align: center;" class="text-center">{{ $name->name }}</h3>
					<table class="table table-bordered" style="direction: rtl;">
						<th>اسم الصنف</th>
						<th>الكمية</th>
						<th>السعر</th>

						<tr>
							<td>{{ $item->name }}</td>
							<td>{{ $item->pivot->quantity }}</td>
							<td>{{ $item->pivot->price }}</td>
						</tr>
						
					</table>
					<div style="direction: rtl; text-align: right;">التاريخ : {{ $item->pivot->created_at }}</div>
				</div>
				<div class="card-footer">
					<button class="print btn btn-success" data-id="{{ $item->pivot->id }}">طباعة</button>
				</div>
		  </div>
	    </div>
	    @endforeach
	</div>
	@else 
	<div class="row mb-3">
		@foreach($order->items as $item)
		<div class="col-lg-4">
			<div class="card">
				<div class="card-body" id="print{{ $item->pivot->id }}">
					<h3 style="text-align: center;" class="text-center">{{ $name->name }}</h3>
					<table class="table table-bordered" style="direction: rtl;">
						<th>اسم الصنف</th>
						<th>الكمية</th>
						<th>السعر</th>
						
						<tr>
							<td>{{ $item->name }}</td>
							<td>{{ $item->pivot->quantity }}</td>
							<td>{{ $item->pivot->price }}</td>
						</tr>
						
					</table>
					<div style="direction: rtl; text-align: right;">التاريخ : {{ $item->pivot->created_at }}</div>
				</div>

				<div class="card-footer">
					<button class="print btn btn-success" data-id="{{ $item->pivot->id }}">طباعة</button>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	@endif
</div>


@endsection