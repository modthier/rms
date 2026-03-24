@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   المنصرفات   </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('dailyExpense.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> المنصرف </th>
                <th> القيمة </th>
                <th> اسم المستخدم </th>
                <th> التاريخ </th>
                <th>عمليات</th>

                @foreach($dailyExpenses as $dailyExpense)
                <tr>
                    <td>@if($dailyExpense->expenseType){{ $dailyExpense->expenseType->name }}@endif</td>
                    <td>{{ $dailyExpense->amount }}</td>
                    <td>{{ $dailyExpense->user->name }}</td>
                    <td>{{ $dailyExpense->created_at }}</td>
                    <td>
                       
                        <a href="{{ route('dailyExpense.edit',$dailyExpense->id) }}" class="btn float-right">
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
        {{ $dailyExpenses->links() }}
    </div>
</div>

@endsection