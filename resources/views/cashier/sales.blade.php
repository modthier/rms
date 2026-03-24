@extends('layouts.cashier')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-lg-9">
			<div class="cashier-card mb-2">
				<div class="cashier-card-header">
					<div>
						<h2 class="cashier-card-title">قائمة المبيعات</h2>
						<span class="cashier-card-title-muted">{{ Auth::user()->name }}</span>
					</div>
				</div>

				<div class="cashier-card-body">
					<div class="cashier-table-wrap">
						<table class="cashier-table table table-lg mb-0">
							<thead>
								<tr>
									<th>رقم الفاتورة</th>
									<th>المجموع</th>
									<th>عدد الأصناف</th>
									<th>نوع الطلب</th>
									<th>طريقة الدفع</th>
									<th>حالة الطلب</th>
									<th class="text-end">عمليات</th>
								</tr>
							</thead>
							<tbody>
								@foreach($orders as $order)
									<tr>
										<td><strong>#{{ $order->id }}</strong></td>
										<td>{{ $order->total_price }}</td>
										<td>{{ $order->total_items }}</td>
										<td>{{ $order->orderType->name }}</td>
										<td>{{ $order->payment->method }}</td>
										<td>
											@if($order->returned == 0)
												<span class="cashier-badge cashier-badge--ok">فعال</span>
											@else
												<span class="cashier-badge cashier-badge--void">ملغي</span>
											@endif
										</td>
										<td>
											<div class="cashier-actions">
												<a class="btn btn-success btn-sm" href="{{ route('cashier.showSales',$order->id) }}">عرض</a>
												<a class="btn btn-danger btn-sm" href="#"
												   onclick="event.preventDefault();
												   var r = confirm('هل انت متاكد ؟');
												   if (r == true) {document.getElementById('delete_order_{{ $order->id }}').submit();}">
													إلغاء الطلب
												</a>
												<form style="display: none;" action="{{ route('order.cancelOrder',$order->id) }}"
												      method="post" id="delete_order_{{ $order->id }}">
													@csrf
													{{ method_field('PUT') }}
												</form>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

				<div class="cashier-card-footer">
					{{ $orders->links() }}
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="cashier-stat-card cashier-stat-card--today">
				<div class="cashier-stat-card__accent" aria-hidden="true"></div>
				<div class="cashier-stat-card__inner">
					<div class="cashier-stat-card__icon"><i class="fas fa-sun" aria-hidden="true"></i></div>
					<div>
						<span class="cashier-stat-card__value">{{ number_format($total_today, 2) }}</span>
						<span class="cashier-stat-card__unit">جنيه</span>
					</div>
					<span class="cashier-stat-card__label">مجموع اليوم</span>
				</div>
			</div>

			<div class="cashier-stat-card cashier-stat-card--canceled">
				<div class="cashier-stat-card__accent" aria-hidden="true"></div>
				<div class="cashier-stat-card__inner">
					<div class="cashier-stat-card__icon"><i class="fas fa-ban" aria-hidden="true"></i></div>
					<div>
						<span class="cashier-stat-card__value">{{ number_format($total_today_canceled, 2) }}</span>
						<span class="cashier-stat-card__unit">جنيه</span>
					</div>
					<span class="cashier-stat-card__label">مجموع الطلبات الملغاة اليوم</span>
				</div>
			</div>

			<div class="cashier-stat-card cashier-stat-card--week">
				<div class="cashier-stat-card__accent" aria-hidden="true"></div>
				<div class="cashier-stat-card__inner">
					<div class="cashier-stat-card__icon"><i class="fas fa-calendar-week" aria-hidden="true"></i></div>
					<div>
						<span class="cashier-stat-card__value">{{ number_format($total_week, 2) }}</span>
						<span class="cashier-stat-card__unit">جنيه</span>
					</div>
					<span class="cashier-stat-card__label">مجموع الأسبوع</span>
				</div>
			</div>

			<div class="cashier-stat-card cashier-stat-card--month">
				<div class="cashier-stat-card__accent" aria-hidden="true"></div>
				<div class="cashier-stat-card__inner">
					<div class="cashier-stat-card__icon"><i class="fas fa-calendar-alt" aria-hidden="true"></i></div>
					<div>
						<span class="cashier-stat-card__value">{{ number_format($total_month, 2) }}</span>
						<span class="cashier-stat-card__unit">جنيه</span>
					</div>
					<span class="cashier-stat-card__label">مجموع الشهر</span>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
