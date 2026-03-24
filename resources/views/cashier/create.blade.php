@extends('layouts.cashier')

@section('content')

<div class="container-fluid">
	<div class="row g-3">
		<div class="col-lg-6">
			<div class="accordion cashier-accordion" id="accordionExample">
				@foreach($types as $type)
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingOne">
							<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#cat_{{ $type->id }}" aria-expanded="true" aria-controls="cat_{{ $type->id }}">
								{{ $type->label }}
							</button>
						</h2>
						<div id="cat_{{ $type->id }}" class="accordion-collapse collapse @if ($loop->first) show @endif" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<div class="d-flex cashier-product-grid products">
									@foreach($type->items as $item)
										<div class="item cashier-item-tile border-0" data-name="{{ $item->name }}"
										     data-price="{{ $item->price }}" data-id="{{ $item->id }}">
											<img src="{{ asset('storage/images/items/'.$item->icon) }}" alt="">
											<span class="text-center">{{ $item->name }}</span>
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
			<div class="cashier-card" id="salesPoint">
				<div class="cashier-card-header">
					<h2 class="cashier-card-title mb-0">سلة الطلب</h2>
				</div>

				<form id="myForm" class="cashier-pos-form" action="{{ route('cashier.store') }}" method="post">
					{{ csrf_field() }}
					<div class="row p-3 g-2">
						<div class="form-group col-lg-6 mb-2 mb-lg-0">
							<label class="mb-2 d-block">طريقة الدفع</label>
							<select name="payment_id" class="form-control" required>
								@foreach($payments as $payment)
									<option value="{{ $payment->id }}">{{ $payment->method }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-lg-6 mb-0">
							<label class="mb-2 d-block">نوع الطلب</label>
							<select name="order_type_id" class="form-control" required>
								@foreach($order_types as $item)
									<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="cashier-card-body table-responsive">
						<table class="cashier-table table table-hovered mb-0">
							<thead>
								<tr>
									<th>اسم الصنف</th>
									<th>الكمية</th>
									<th>السعر</th>
									<th class="text-end">عمليات</th>
								</tr>
							</thead>
							<tbody class="order_list"></tbody>
						</table>

						<p class="cashier-total-bar mb-0">المجموع: <span class="total"></span></p>
						<input type="hidden" id="total_all" name="total">
					</div>

					<div class="cashier-card-footer text-end">
						<button type="submit" id="orderBtn" disabled class="btn btn-primary btn-lg">حفظ</button>
					</div>
				</form>
			</div>

			<div id="printArea"></div>
		</div>
	</div>
</div>

@endsection
