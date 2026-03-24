@if($requirement->requirementChange()->count())
<h3 class="text-center">{{ $requirement->requirementType->name }}</h3>
<div id="priceChangeTable">
<table class="table table-hovered table-bordered">
    <thead>
        
        <th>الكمية</th>
        <th>السعر الكلي</th>
        <th> التاريخ </th>
    </thead>
    <tbody>
        @foreach ($requirementChange as $item)
            <tr>
                
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->total_price }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
        @endforeach
        <tr>

        </tr>
    </tbody>
</table>
</div>
@else 
<h1 class="text-danger mb-3 mt-3 text-center">   لا يوجد تغيير  </h1>
@endif
