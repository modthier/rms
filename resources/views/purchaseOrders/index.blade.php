@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h3 class="text-primary">   قائمة  المشتريات</h3>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> الصنف </th>
                <th>الكمية</th>
                <th>السعر الكلي</th>
                <th> التاريخ </th>
                

                @foreach($pos as $po)
                <tr>
                    <td>{{ $po->stock->ingredient->ingredient }}</td>
                    <td>{{ $po->quantity }} {{ $po->stock->unit->unit }}</td>
                    <td>{{ number_format($po->total_price,2) }}</td>
                    <td>{{ $po->created_at }}</td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        {{ $pos->links() }}
    </div>
</div>


</div>	

@endsection