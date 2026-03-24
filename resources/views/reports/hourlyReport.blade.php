@extends('layouts.main')

@section('content')
@include('reports.partials.report-styles')
<div class="report-page">

<div class="card report-page-header">
    <div class="card-header">
        <div class="card-title">
            <h1 class="text-center"> نتيجة البحث  </h1>
        </div>
    </div>
</div>

<div class="row">
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
                          <input type="date" name="start_date" value="{{$start_date}}" class="form-control" required>
                      </div>
                  </div>
                  <div class="col-lg-6">
                      <div class="form-group">
                          <label>من الوقت</label>
                          <input type="time" name="start_time"  value="{{$start_time}}" class="form-control" required>
                      </div>
                  </div>

                   <div class="col-lg-6">
                      <div class="form-group">
                          <label>الي الوقت</label>
                          <input type="time" name="end_time"     value="{{$end_time}}" class="form-control" required>
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
          <div class="card report-result-card">
            <div class="card-header">
              <div class="card-title">
                <h3 class="mb-0">   مجموع مبيعات المستخدم ({{$user->name}}) </h3>
              </div>
            </div>
            <div class="card-body">
                <h3>{{ number_format($total, 2) }} جنيه</h3>
            </div>
          </div>
      </div>
 
</div>
</div>
@endsection