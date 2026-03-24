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
	
</div>


@endsection