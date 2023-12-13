@extends('layouts.main')

@section('content')
  
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h3 class="text-primary">   كشف المرتبات   (شهر
                        @if($currentMonth == 'Jan')
                        يناير
                        @elseif ($currentMonth == 'Feb')
                        فبراير

                        @elseif ($currentMonth == 'Mar')
                        مارس
                        @elseif ($currentMonth == 'Apr')
                        أبريل

                        @elseif ($currentMonth == 'May')
                        مايو

                        @elseif ($currentMonth == 'Jun')
                        يونيو

                        @elseif ($currentMonth == 'Jul')
                        يوليو

                        @elseif ($currentMonth == 'Aug')
                        أغسطس

                        @elseif ($currentMonth == 'Sep')
                        سبتمبر

                        @elseif ($currentMonth == 'Oct')
                        أكتوبر

                        @elseif ($currentMonth == 'Nov')
                        نوفمبر

                        @elseif ($currentMonth == 'Dec')
                        ديسمبر

                        @endif)</h3>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> اسم  الموظف </th>
                <th> عدد ايام الحضور </th>
                <th> السلفيات </th>
                <th> المرتب </th>
                

                @foreach($salaries as $salay)
                <tr>
                    <td>{{ $salay['name'] }}</td>
                    <td>{{ $salay['attendance'] }}</td>
                    <td>{{ $salay['advance'] }}</td>
                    <td>{{ ($salay['day_salary']  * $salay['attendance'] ) - $salay['advance'] }}</td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        
    </div>
</div>


@endsection