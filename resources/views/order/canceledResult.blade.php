@extends('layouts.main')

@section('content')
  

  <div class="col-lg-12">
  	<div class="card">
  			<div class="card-header">
  					بحث في الطلبات الملغية حسب المستخدم
  			</div
  			<div class="card-body p-2">
  					<form action="{{ route('order.canceledSearch') }}" method="get">
              <div class="row">
              	  <div class="col-lg-12">
              	  	 <div class="form-group">
                          <label>اسم المستخدم</label>
                          <select class="form-control" name="user_id" required>
                          	  @foreach($users as $item)
                          		<option value="{{ $item->id }}">{{ $item->name }}</option>
                          		@endforeach
                          </select>
                      </div>
              	  </div>
                  <div class="col-lg-6">
                      <div class="form-group">
                          <label>من تاريخ</label>
                          <input type="date" name="date_from" class="form-control" required>
                      </div>
                  </div>

                   <div class="col-lg-6">
                      <div class="form-group">
                          <label>الي تاريخ</label>
                          <input type="date" name="date_to" class="form-control" required>
                      </div>
                  </div>
              </div>

              <div class="form-group">
                  <input type="submit" value="بحث" class="btn btn-success btn-lg">
              </div>
          </form>
  			</div>
  	</div>
  </div>
  <div class="card mb-2">
		<div class="card-header d-flex justify-content-between align-items-center">
			<div class="card-title">
				<h3 class="text-primary"> قائمة  المبيعات </h3>
			</div>
            <div>
                المجموع : {{number_format($total_price)}}
            </div>
		</div>

		<div class="card-body p-0">
			<table class="table table-hovered table-lg">
				<th> اسم المستخدم </th>
				<th> عدد الاصناف </th>
				<th>  نوع الطلب </th>
        		<th> طريقة الدفع </th>
				<th> المجموع </th>
				<th> التاريخ </th>
				<th> عمليات </th>

				@foreach($report as $order)
					<tr>
						<td>{{ $order->user->name }}</td>
						<td>
							{{ $order->total_items }}
						</td>
						<td>
							{{ $order->orderType->name }}
						</td>
            <td>{{ $order->payment->method }}</td>
						<td>{{ $order->total_price }}</td>

						<td>{{ $order->created_at }}</td>
						<td>
							<a class="float-right btn btn-success ml-3" href="{{ route('order.show',$order->id) }}">عرض</a>

								
						</td>
					</tr>
				@endforeach
			</table>
		</div>

		<div class="card-footer">
			{{ $report->links() }}
		</div>

</div>
@endsection