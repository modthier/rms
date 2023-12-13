<button class="btn btn-danger close mb-3">رجوع</button>
@if($order->items->count() == 1)
<div class="row">
	 @foreach($order->items as $item)
     <div class="col-lg-4">
	   <div class="card">
			<div class="card-body" id="print{{ $item->pivot->id }}">
				<h3 style="text-align: center;" class="text-center">{{ $name->name }}</h3>
				<div> <h6>رقم الفاتورة  :  {{ $order->id }}#</h6></div>
				<table class="table table-bordered" style="direction: rtl;">
					<th>اسم الصنف</th>
					<th>الكمية</th>
					<th>السعر</th>

					<tr>
						<td>{{ $item->name }}</td>
						<td>{{ $item->pivot->quantity }}</td>
						<td>{{ $item->pivot->price }}</td>
					</tr>
					
				</table>
				<div style="direction: rtl; text-align: right;">التاريخ : {{ $item->pivot->created_at }}</div>
			</div>
			<div class="card-footer">
				<button class="print btn btn-success" data-id="{{ $item->pivot->id }}">طباعة</button>
			</div>
	  </div>
    </div>
    @endforeach
</div>
@else 
<div class="row">
	
	@foreach($types as $type)
	<div class="col-lg-5 mb-2">
		<div class="card">
			<div class="card-body" id="print{{ $type->item_type_id }}">
				<h3 style="text-align: center;" class="text-center">{{ $name->name }}</h3>
				<div> <h6>رقم الفاتورة  :  {{ $order->id }}#</h6></div>
				<table class="table table-bordered" style="direction: rtl;">
					<th>اسم الصنف</th>
					<th>الكمية</th>
					<th>السعر</th>
					@foreach($order->getItemsByTypes($type->item_type_id) as $item)
					<tr>
						
						<td>{{ $item->name }}</td>
						<td>{{ $item->quantity }}</td>
						<td>{{ $item->price }}</td>
						
					</tr>
					@endforeach
				</table>
				<div style="direction: rtl; text-align: right;">التاريخ : {{ $item->created_at }}</div>
			</div>

			<div class="card-footer">
				<button class="print btn btn-success" data-id="{{ $type->item_type_id }}">طباعة</button>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endif




