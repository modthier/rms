@extends('layouts.cashier')

@section('content')

@include('cashier/nav')


<div class="container">
	<div class="row">
		<div class="col-lg-9">
			<div class="card mb-2">
				<div class="card-header">
					<div class="card-title">
						<h3 class="text-primary"> قائمة المبيعات   ({{ Auth::user()->name }})</h3>
					</div>
				</div>

				<div class="card-body p-0">
					<table class="table table-hovered  table-lg">
						<th> رقم الفاتورة </th>
						<th> المجموع </th>
						<th>عدد الاصناف</th>
						<th>  نوع الطلب </th>
						<th> طريقة الدفع </th>
						<th>حالة الطلب</th>
						<th> عمليات </th>
						@foreach($orders as $order)
						<tr>
							<td>{{ $order->id }}</td>
							<td>{{ $order->total_price }}</td>
							<td>{{ $order->total_items }}</td>
							<td>{{ $order->orderType->name }}</td>
							<td>{{ $order->payment->method }}</td>
							<td>
								@if($order->returned == 0)
								فعال
								@else
								ملغي
								@endif
							</td>
							<td>
								<a class="float-right btn btn-success" href="{{ route('cashier.showSales',$order->id) }}">عرض</a>

								<a class="btn btn-danger"  onclick="event.preventDefault();
                                  var r = confirm('هل انت متاكد ؟');
                                  if (r == true) {document.getElementById('delete_order_{{ $order->id }}').submit();}">
                                  	الغاء الطلب
                                </a>

								<form style="display: none;" action="{{ route('order.cancelOrder',$order->id) }}"
				                       method="post" id="delete_order_{{ $order->id }}" class="float-right mr-1">
				                        @csrf

				                        {{ method_field('PUT') }}

				                         
				               </form>
							</td>
						</tr>
						@endforeach
					</table>
				</div>

				<div class="card-footer">
					{{ $orders->links() }}
				</div>

			</div>
		</div>

		<div class="col-lg-3">
		   <div class="row">
				 <div class="col-lg-12">
	        
				        <div class="small-box bg-white">
				          <div class="inner">
				            <h3>{{ number_format($total_today,2) }} جنيه</h3>

				            <p><strong> مجموع اليوم </strong></p>
				          </div>
				          
				        </div>
				 </div>
				 <div class="col-lg-12">
	        
				        <div class="small-box bg-white">
				          <div class="inner">
				            <h3>{{ number_format($total_today_canceled,2) }} جنيه</h3>

				            <p><strong> مجموع الطلبات الملغية اليوم </strong></p>
				          </div>
				          
				        </div>
				 </div>
        
				 <div class="col-lg-12">
				            <!-- small box -->
				        <div class="small-box bg-white">
				          <div class="inner">
				            <h3>{{ number_format($total_week,2) }} جنيه</h3>

				            <p><strong>مجموع ا الاسبوع</strong></p>
				          </div>
				          
				        </div>
				 </div>

				 <div class="col-lg-12">
				            <!-- small box -->
				        <div class="small-box bg-white">
				          <div class="inner">
				            <h3>{{ number_format($total_month,2) }} جنيه</h3>

				            <p><strong> مجموع الشهر</strong></p>
				          </div>
				          
				        </div>
				 </div>

			</div>
		</div>
	</div>
</div>


@endsection