@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">المستخدمين</h3>
        </div>

        <div class="float-left">
            <a href="{{ route('management.create') }}" class="btn btn-success">مستخدم جديد</a>
        </div>

        
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-lg">
                <th>  اسم المستخدم </th>
                <th> البريد الالكتروني </th>
                <th>نوع المستخدم</th>
                <th> عمليات </th>

                @foreach($users as $user)
                <tr>

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role->role == 'admin')
                                مدير
                        @elseif($user->role->role == 'stockeeper')
                                امين مخزون
                        @elseif($user->role->role == 'user')
                                كاشير
                        @endif
                    </td>
                    <td>

                        <a href="{{ route('management.resetPasswordForm',$user->id) }}" class="btn btn-primary mb-1">
                            تحديث كلمة المرور
                        </a>

                        @if($user->active == 1)
                        <a href="{{ route('management.disableUser',$user->id) }}" class="btn btn-warning mb-1"> تعطيل المستخدم </a>
                        @else 
                        <a href="{{ route('management.enableUser',$user->id) }}" class="btn btn-success mb-1"> تفعيل المستخدم </a>
                        @endif
                        <a href="{{ route('user.dailyTotal',$user->id) }}" class="btn btn-danger">
                            عرض تقرير المبيعات
                        </a>
                    </td>
                </tr>
                @endforeach
               
            </table>
        </div>
    </div>

    <div class="card-footer">

    </div>
</div>

@endsection