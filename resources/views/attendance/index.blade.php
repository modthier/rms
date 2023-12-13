@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">  قائمة الحضور  </h3>
        </div>

        <div class="float-left">
            <button class="btn btn-success btn-lg new">  جديد  </button>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> اسم  الموظف </th>
                <th> الحضور لشهر </th>
                <th> سنة </th>
                <th> زمن وتاريخ الحضور </th>
                
                @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->employee->name }}</td>
                    
                    <td>
                        @if($attendance->month == 'Jan')
                        يناير
                        @elseif ($attendance->month == 'Feb')
                        فبراير

                        @elseif ($attendance->month == 'Mar')
                        مارس
                        @elseif ($attendance->month == 'Apr')
                        أبريل

                        @elseif ($attendance->month == 'May')
                        مايو

                        @elseif ($attendance->month == 'Jun')
                        يونيو

                        @elseif ($attendance->month == 'Jul')
                        يوليو

                        @elseif ($attendance->month == 'Aug')
                        أغسطس

                        @elseif ($attendance->month == 'Sep')
                        سبتمبر

                        @elseif ($attendance->month == 'Oct')
                        أكتوبر

                        @elseif ($attendance->month == 'Nov')
                        نوفمبر

                        @elseif ($attendance->month == 'Dec')
                        ديسمبر

                        @endif
                    </td>
                    <td>{{ $attendance->year }}</td>
                    <td>{{ $attendance->created_at }}</td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        {{ $attendances->links() }}
    </div>
</div>


<div class="modal  fade"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog   modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('attendance.store') }}" method="post">
                    {{ csrf_field() }} 
                    <div class="form-group">
                        <label> اسم الموظف </label>
                        <select id="employee" style="width: 100%;" class="form-control" name="employee_id">
                            <option></option>
                        </select>
                    </div>

                    <input type="submit" value="تسجيل الحضور" class="btn btn-primary">
                </form>
            </div>

        </div>
    </div>
</div>

@endsection