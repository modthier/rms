@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   قائمة  المخزون </h3>
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
                

                @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->ingredient?->ingredient ?? '—' }}</td>
                    <td>{{ $stock->quantity }} {{ $stock->unit->unit }}</td>
                    <td>{{ number_format($stock->unit_price,2) }}</td>
                    <td>{{ number_format($stock->unit_price * $stock->quantity,2) }}</td>
                    <td>{{ $stock->created_at }}</td>
                   
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