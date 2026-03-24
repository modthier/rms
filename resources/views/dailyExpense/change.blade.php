@if($DailyExpense->expenseChange()->count())
<h3 class="text-center">{{ $DailyExpense->title }}</h3>
<div id="priceChangeTable">
<table class="table table-hovered table-bordered">
    <thead>
        <th> المنصرف </th>
        <th> القيمة </th>
        <th> اسم المستخدم </th>
        <th> التاريخ </th>
    </thead>
    <tbody>
        @foreach ($DailyExpenseChange as $item)
            <tr>
                <td>{{ $item->expenseType->name }}</td>
                <td>{{ $item->amount }}</td>
                <td>{{ $item->user->name }}</td>
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
