@extends('layouts.main')

@section('content')
@include('reports.partials.report-styles')
<div class="report-page">

<div class="card report-page-header">
    <div class="card-header">
        <div class="card-title">
            <h1 class="text-center"> التقرير اليومي </h1>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-lg-6">
          <div class="card report-stat-sales">
            <div class="card-body">
              <h3> مجموع مبيعات اليوم </h3>
              {{ number_format($total_today,2) }} جنيه
            </div>
          </div>
      </div>
      <div class="col-lg-6">
          <div class="card report-stat-expenses">
            <div class="card-body">
              <h3> مجموع  منصرفات اليوم </h3>
              {{ number_format($daily_expenses,2) }} جنيه
            </div>
          </div>
      </div>

      <div class="col-lg-12">
          <div class="card report-payment-card">
            <div class="card-body">
              <h3 class="mb-3"> مجموع مبيعات اليوم حسب طريقة الدفع </h3>
              <table class="table table-bordered">
                <thead><tr>
                  <th>طريقة الدفع</th>
                  <th>عدد الاصناف</th>
                  <th>المجموع</th>
                </tr></thead>
                <tbody>
                @foreach($total_by_payments as $total)
                 <tr>
                  <td>{{ $total->method }}</td>
                  <td>{{ $total->total_items }}</td>
                  <td>{{ number_format($total->total_price,2) }} جنيه</td>
                 </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
      <div class="col-lg-12">
  	<div class="card report-search-card">
  			<div class="card-header">
  					بحث في المبيعات حسب المستخدم
			</div>
  			<div class="card-body p-2">
  					<form action="{{ route('order.hourlySearch') }}" method="get">
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
                    <div class="col-lg-12">
                      <div class="form-group">
                          <label> التاريخ </label>
                          <input type="date" name="start_date" class="form-control" required>
                      </div>
                  </div>
                  <div class="col-lg-6">
                      <div class="form-group">
                          <label>من الوقت</label>
                          <input type="time" name="start_time" class="form-control" required>
                      </div>
                  </div>

                   <div class="col-lg-6">
                      <div class="form-group">
                          <label>الي الوقت</label>
                          <input type="time" name="end_time" class="form-control" required>
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

      <div class="col-lg-12">
          <div class="card report-table-card">
            <div class="card-header">
              <div class="card-title">
                <h3 class="mb-0"> مجموع  مبيعات اليوم حسب الاصناف </h3>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-hover table-lg mb-0">
                <thead><tr>
                  <th> الصنف </th>
                  <th>عدد الاصناف</th>
                  <th>المجموع</th>
                </tr></thead>
                <tbody>
                @foreach($total_by_items as $t)
                 <tr>
                  <td>{{ $t->name }}</td>
                  <td>{{ $t->total_quantity }}</td>
                  <td>{{ number_format($t->total_price,2) }} جنيه</td>
                 </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
 
</div>
</div>
@endsection