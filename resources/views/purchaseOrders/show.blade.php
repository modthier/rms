@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="text-primary"> اسم المورد :  {{$purchaseOrder->supplier->name}}  </h3>
    </div>
</div>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="card-title">
            <h3 class="text-primary"> تفاصيل الفاتورة</h3>
        </div>
		<div>
			<a class="btn btn-primary" href="{{route('purchaseOrders.index')}}"> رجوع </a>
		</div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> اسم الصنف</th>
                <th>الكمية</th>
                <th>سعر الوحدة</th>
                <th>السعر الكلي</th>
                <th> التاريخ </th>
                

                @foreach($details as $po)
                <tr>
                    <td>{{ $po->ingredient }}</td>
                    <td>{{ $po->quantity }} {{ $po->unit }}</td>
                    <td>{{ number_format($po->subtotal/$po->quantity,2) }}</td>
                    <td>{{ number_format($po->subtotal,2) }}</td>
                    <td>{{ $po->created_at }}</td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
             مجموع الفاتورة :    {{$purchaseOrder->total_price}}
    </div>
</div>


</div>	

@endsection