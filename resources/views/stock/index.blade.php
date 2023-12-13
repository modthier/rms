@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   قائمة  المخزون </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('stock.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> الصنف </th>
                <th>الكمية</th>
                <th> سعر الوحدة </th>
                <th>السعر الكلي</th>
                <th> التاريخ </th>
                <th>عمليات</th>

                @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->ingredient->ingredient }}</td>
                    <td>{{ $stock->quantity }} {{ $stock->unit->unit }}</td>
                    <td>{{ number_format($stock->unit_price,2) }}</td>
                    <td>{{ number_format($stock->unit_price * $stock->quantity,2) }}</td>
                    <td>{{ $stock->created_at->diffForHumans() }}</td>
                    <td>
                       
                        <a href="{{ route('stock.edit',$stock->id) }}" class="btn float-right">
                            <svg style="width: 30px; height: 30px;">
                              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-highlighter') }}"></use>
                            </svg>
                              
                        </a>


                    </td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        {{ $stocks->links() }}
    </div>
</div>


</div>	

@endsection