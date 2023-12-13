@extends('layouts.main')

@section('content')

<div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="text-primary">مستخدم جديد</h3>
            </div>
        </div>


        <div class="card-body">
            
                <form class="form" action="{{ route('management.store') }}" role="form" autocomplete="off" id="formLogin" novalidate="" method="POST">

                {{ csrf_field() }}

                <div class="row">
                    <div class="col-lg-6">
                         <div class="form-group">
                         <label for="email">اسم المستخدم</label>
                         <input type="text" class="form-control" name="name" id="uname1" required="">
                        
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="email">البريد الالكتروني</label>
                        <input type="email" class="form-control" name="email" id="uname2" required="">
                        </div>
                    </div>

                    <div class="col-lg-6">
                         <div class="form-group">
                         <label>كلمة المرور</label>
                         <input type="password" name="password" class="form-control" id="pwd1" required="" autocomplete="new-password">
                        
                         </div>
                    </div>

                    <div class="col-lg-6">
                         <div class="form-group">
                         <label>تأكيد كلمة المرور</label>
                         <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required="">
                        
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                        <label>نوع المستخدم</label>
                        <select name="role_id" class="form-control" required>
                            <option></option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">
                                @if($role->role == 'admin')
                                مدير
                                @elseif($role->role == 'stockeeper')
                                امين مخزون
                                @elseif($role->role == 'user')
                                كاشير
                                @endif
                            </option>
                            @endforeach
                        </select>
                        
                        </div>

                    </div>

                </div>
               
              
                <button type="submit" class="btn btn-primary btn-lg" id="btnLogin">تسجيل</button>
               
                </form>

        </div>
    </div>



@endsection