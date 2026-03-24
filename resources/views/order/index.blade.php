@extends('layouts.main')

@section('content')

  <div class="row">
  	  <div class="col-lg-3">
  	  		<div class="card text-white bg-gradient-primary">
  	  			<div class="card-body">
  	  				<h3> المجموع الكلي</h3>
  	  				{{ number_format($total,2) }} جنيه
  	  			</div>

  	  		</div>
  	  </div>

  	  <div class="col-lg-3">
  	  		<div class="card text-white bg-gradient-info">
  	  			<div class="card-body">
  	  				<h3> مجموع اليوم </h3>
  	  				{{ number_format($total_today,2) }} جنيه
  	  			</div>

  	  		</div>
  	  </div>


  	  <div class="col-lg-3">
  	  		<div class="card text-white bg-gradient-warning">
  	  			<div class="card-body">
  	  				<h3> مجموع  الاسبوع </h3>
  	  				{{ number_format($total_week,2) }} جنيه
  	  			</div>

  	  		</div>
  	  </div>


  	  <div class="col-lg-3">
  	  		<div class="card text-white bg-gradient-danger">
  	  			<div class="card-body">
  	  				<h3> مجموع  الشهر </h3>
  	  				{{ number_format($total_month,2) }} جنيه
  	  			</div>

  	  		</div>
  	  </div>
  </div>

  	<div class="card">
  			<div class="card-header">
  					تقرير بالمنتج
  			</div>
  		 <div class="col-lg-12">	<div class="card-body">
  					<form action="{{ route('order.productReport') }}" method="get">
              <div class="row">
              	  <div class="col-lg-12">
              	  	 <div class="form-group">
                          <label>اسم المنتج</label>
                          <select class="form-control" name="item_id" required>
                          	  @foreach($items as $item)
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
		<div class="card-header">
			<div class="card-title">
				<h3 class="text-primary"> قائمة  المبيعات </h3>
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

				@foreach($orders as $order)
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
			{{ $orders->links() }}
		</div>

</div>
@endsection
