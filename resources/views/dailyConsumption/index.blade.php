@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   الاستهلاك اليومي  </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('dailyConsumption.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> الصنف </th>
                <th> الكمية </th>
                <th> القيمة </th>
                <th> التاريخ </th>
                <th>عمليات</th>

                @foreach($dailies as $daily)
                <tr>
                    <td>{{ $daily->stock->ingredient->ingredient }} {{ date_format($daily->stock->created_at,'d/m/Y') }}</td>
                    <td>{{ $daily->quantity }}</td>
                    <td>{{ number_format($daily->stock->unit_price *  $daily->quantity,2) }}</td>
                    <td>{{ $daily->created_at }}</td>
                    <td>
                       
                        

                        <a href="#"  onclick="event.preventDefault();
                          var r = confirm('هل انت متاكد ؟');
                                if (r == true) {document.getElementById('delete_daily_{{ $daily->id }}').submit();}">
                                <svg style="width: 30px; height: 30px;">
                              	<use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}"></use>
                               </svg>
                        </a>

						<form style="display: none;" action="{{ route('dailyConsumption.destroy',$daily->id) }}"
		                       method="post" id="delete_daily_{{ $daily->id }}" class="float-right mr-1">
		                        @csrf

		                        {{ method_field('DELETE') }}

		                         
		               </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        {{ $dailies->links() }}
    </div>
</div>

@endsection