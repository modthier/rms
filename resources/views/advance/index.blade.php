@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   السلفيات  </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('advance.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> اسم  الموظف </th>
                <th>  قيمة السلفية </th>
                <th> سلفية لشهر  </th>
                <th> سنة </th>
                <th> التاريخ </th>
                <th>عمليات</th>

                @foreach($advances as $advance)
                <tr>
                    <td>{{ $advance->employee->name }}</td>
                    <td>{{ $advance->amount }}</td>
                    <td>
                        @if($advance->month == 'Jan')
                        يناير
                        @elseif ($advance->month == 'Feb')
                        فبراير

                        @elseif ($advance->month == 'Mar')
                        مارس
                        @elseif ($advance->month == 'Apr')
                        أبريل

                        @elseif ($advance->month == 'May')
                        مايو

                        @elseif ($advance->month == 'Jun')
                        يونيو

                        @elseif ($advance->month == 'Jul')
                        يوليو

                        @elseif ($advance->month == 'Aug')
                        أغسطس

                        @elseif ($advance->month == 'Sep')
                        سبتمبر

                        @elseif ($advance->month == 'Oct')
                        أكتوبر

                        @elseif ($advance->month == 'Nov')
                        نوفمبر

                        @elseif ($advance->month == 'Dec')
                        ديسمبر

                        @endif
                    </td>
                    <td>{{ $advance->year }}</td>
                    <td>{{ $advance->created_at }}</td>
                    <td>
                       
                        <a href="{{ route('advance.edit',$advance->id) }}" class="btn float-right">
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
        {{ $advances->links() }}
    </div>
</div>


</div>	

@endsection