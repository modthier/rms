@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
		<h3>ابحث في فواتير المشتريات</h3>
	</div>
	<div class="card-body">
	<form action="{{route('purchaseOrders.search')}}" method="get">
	<div class="row mb-3">
		
		<div class="col-lg-6 form-group">
		<label> رقم الفاتورة </label>
		<input type="number" class="form-control invoice_number" id="invoice_number" name="invoice_number">
		</div>

		<div class="col-lg-6 form-group">
			<label> اسم المورد </label>
			<select class="form-control sel" name="supplier_id" id="supplier_id"    >
				<option></option>
				@foreach($suppliers as $item)
				<option value="{{ $item->id }}">{{ $item->name }}</option>
				@endforeach
			</select>
		</div>
    </div>
    <input type="submit" value="بحث" class="btn btn-lg btn-success">
	</form>
	</div>
  </div>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="card-title">
            <h3 class="text-primary">   قائمة  المشتريات</h3>
        </div>
		<div>
			<a class="btn btn-primary" href="{{route('purchaseOrders.create')}}">فاتورة شراء جديدة</a>
		</div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
        <table class="table  table-hover table-lg">
				<th>رقم فاتورة النظام</th>
				<th>رقم فاتورة الشراء</th>
                <th> اسم المورد </th>
                <th>مجموع كمية المشتريات</th>
                <th>السعر الكلي</th>
                <th> التاريخ </th>
                <th>عمليات</th>

                @foreach($pos as $po)
                <tr>
					<td>{{$po->id}}#</td>
					<td>{{$po->invoice_number}}#</td>
                    <td>{{ $po->supplier->name }}</td>
                    <td>{{ $po->quantity }}</td>
                    <td>{{ number_format($po->total_price,2) }}</td>
                    <td>{{ $po->created_at }}</td>
					<td>
						<a class="btn btn-sm btn-primary" href="{{route('purchaseOrders.show',$po->id)}}">عرض</a>
						<a class="btn btn-sm btn-warning" href="{{route('purchaseOrders.edit',$po->id)}}">تعديل</a>
					</td>
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