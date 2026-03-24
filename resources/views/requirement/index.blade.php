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
        <div class="card-title float-right">
            <h3 class="text-primary">   قائمة  الاحتياجات </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('requirement.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> النوع </th>
                <th>الكمية</th>
                <th>السعر الكلي</th>
                <th> التاريخ </th>
                <th>عمليات</th>

                @foreach($requirements as $item)
                <tr>
                    <td>{{ $item->requirementType->name }}</td>
                    <td>{{ $item->quantity }} {{ $item->unit->unit }}</td>
                    <td>{{ number_format($item->total_price,2) }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                       
                        <a href="{{ route('requirement.edit',$item->id) }}" class="btn float-right">
                            <svg style="width: 30px; height: 30px;">
                              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-highlighter') }}"></use>
                            </svg>
                              
                        </a>
                        @can('admin_only')
                         <form class="float-right"  id="delete_requirement_{{ $item->id }}"  action="{{ route('requirement.destroy',$item->id) }}"
                                method="post">
                                  @csrf

                              {{ method_field('DELETE') }}
                              <button  class="btn" onclick="event.preventDefault();
                                  var r = confirm(' هل انت متاكد ؟ ');
                                  if (r == true) {document.getElementById('delete_requirement_{{ $item->id }}').submit();}"><svg style="width: 30px; height: 30px;">
                                      <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}"></use>
                                    </svg>
                              </button>
                  
                        </form>
                        @endcan

                    </td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        {{ $requirements->links() }}
    </div>
</div>


</div>	

@endsection