@extends('layouts.main')

@section('content')
  
  <div class="row">
  	  <div class="col-lg-6">
  	  		<div class="card text-white bg-gradient-primary">
  	  			<div class="card-body">
  	  				<h3> مجموع مبيعات اليوم </h3>
  	  				{{ number_format($total_today,2) }} جنيه
  	  			</div>
  	  			
  	  		</div>
  	  </div>

  	  <div class="col-lg-6">
  	  		<div class="card text-white bg-gradient-info">
  	  			<div class="card-body">
  	  				<h3> مجموع منصرفات اليوم </h3>
  	  				{{ number_format($daily_expenses,2) }} جنيه
  	  			</div>
  	  			
  	  		</div>
  	  </div>


  	  <div class="col-lg-12">
  	  		<div class="card text-white bg-gradient-warning">
  	  			<div class="card-body">
  	  				<h3 class="mb-3"> مجموع مبيعات اليوم حسب طريقة الدفع </h3>
  	  				<table class="table table-bordered">
  	  					<th>طريقة الدفع</th>
  	  					<th>عدد الاصناف</th>
  	  					<th>المجموع</th>
  	  					@foreach($total_by_payments as $total)
  	  					 <tr>
  	  					 	<td class="text-white">{{ $total->method }}</td>
  	  					 	<td class="text-white">{{ $total->total_items }}</td>
  	  					 	<td class="text-white">{{ number_format($total->total_price,2) }} جنيه</td>
  	  					 </tr>
  	  					@endforeach
  	  				</table>
  	  				
  	  			</div>
  	  			
  	  		</div>
  	  </div>


  	  <div class="col-lg-12">
  	  		<div class="card">
  	  			<div class="card-header">
  	  				<div class="card-title">
  	  					<h3 class="mb-3"> مجموع  مبيعات اليوم حسب الاصناف </h3>
  	  				</div>
  	  			</div>
  	  			<div class="card-body p-0">
  	  				
  	  				<table class="table table-hovered table-lg">
  	  					<th> الصنف </th>
  	  					<th>عدد الاصناف</th>
  	  					<th>المجموع</th>
  	  					@foreach($total_by_items as $t)
  	  					 <tr>
  	  					 	<td>{{ $t->name }}</td>
  	  					 	<td>{{ $t->total_quantity }}</td>
  	  					 	<td>{{ number_format($t->total_price,2) }} جنيه</td>
  	  					 </tr>
  	  					@endforeach
  	  				</table>
  	  				
  	  			</div>
  	  			
  	  		</div>
  	  </div>


  	 
  </div>

@endsection