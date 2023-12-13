@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   قائمة الموظفين  </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('employee.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> اسم  الموظف </th>
                <th> المرتب الشهري </th>
                <th>قيمة مرتب  يوم</th>
                <th>تاؤيخ التعيين</th>
                <th>عمليات</th>

                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->salary }}</td>
                    <td>{{ $employee->day_salary }}</td>
                    <td>{{ $employee->hire_date }}</td>
                    <td>
                       
                        <a href="{{ route('employee.edit',$employee->id) }}" class="btn float-right">
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
        {{ $employees->links() }}
    </div>
</div>




@endsection