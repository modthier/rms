@extends('layouts.cashier')

@section('content')

<div class="container">
	<div class="row g-3">
		<div class="col-lg-8">
			<div class="cashier-card mb-2">
				<div class="cashier-card-header">
					<h2 class="cashier-card-title mb-0">تفاصيل المعاملة</h2>
				</div>

				<div class="cashier-card-body">
					<div class="cashier-table-wrap">
						<table class="cashier-table table table-lg mb-0">
							<thead>
								<tr>
									<th>اسم الصنف</th>
									<th>سعر الصنف</th>
									<th>الكمية</th>
									<th>المجموع</th>
								</tr>
							</thead>
							<tbody>
								@foreach($order->items as $item)
									<tr>
										<td>{{ $item->name }}</td>
										<td>{{ $item->pivot->price / $item->pivot->quantity }}</td>
										<td>{{ $item->pivot->quantity }}</td>
										<td>{{ $item->pivot->price }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="cashier-stat-card cashier-stat-card--today">
				<div class="cashier-stat-card__accent" aria-hidden="true"></div>
				<div class="cashier-stat-card__inner">
					<div class="cashier-stat-card__icon"><i class="fas fa-receipt" aria-hidden="true"></i></div>
					<div>
						<span class="cashier-stat-card__value">{{ number_format($order->total_price, 2) }}</span>
						<span class="cashier-stat-card__unit">جنيه</span>
					</div>
					<span class="cashier-stat-card__label">إجمالي الفاتورة</span>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
