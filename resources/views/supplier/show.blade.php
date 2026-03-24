@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   ({{$supplier->name}})  عرض فواتير المورد  </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('suppliers.index') }}" class="btn btn-success btn-lg">  رجوع  </a>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                <th> رقم الفاتورة </th>
                <th> مجموع مشتريات الفاتورة </th>
                <th> مجموع قيمة الفاتورة </th>
                <th>تاريخ الفاتورة </th>
                <th>عمليات</th>

                @foreach($supplier->purchaseOrders as $item)
                <tr>
                    <td>{{ $item->invoice_number }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->total_price,2) }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="{{route('purchaseOrders.show',$item->id)}}" class="btn btn-primary">عرض الفاتورة</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        مجموع فواتير المورد : {{$supplier->purchaseOrders()->sum('total_price')}}
    </div>
</div>


</div>	

@endsection