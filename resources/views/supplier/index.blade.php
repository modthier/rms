@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">    قائمة الموردين  </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('suppliers.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                <th>  اسم المورد </th>
                <th> مجموع قيمة الفواتير </th>
                <th>عمليات</th>

                @foreach($suppliers as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->purchaseOrders()->sum('total_price'),2) }}</td>
                    <td>
                        <a href="{{ route('suppliers.show',$item->id) }}" class="btn btn-primary">
                            عرض
                              
                        </a>
                        <a href="{{ route('suppliers.edit',$item->id) }}" class="btn btn-warning">
                            تعديل
                              
                        </a>

                    </td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        {{ $suppliers->links() }}
    </div>
</div>


</div>	

@endsection