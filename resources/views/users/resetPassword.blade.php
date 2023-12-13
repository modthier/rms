@extends('layouts.main')

@section('content')

<div class="card"> 
      <div class="card-header">
          <div class="card-title">
              <h3> تحديث كلمة المرور </h3>
          </div>
      </div>   
      <form action="{{ route('management.resetPassword',$user->id) }}" method="post">
        {{ csrf_field() }} 
        <div class="card-body">
          <div class="row">
              

               <div class="col-sm-12">
                  <div class="form-group">
                      <label> كلمة المرور الجديدة </label>
                      <input type="password" name="password" 
                        class="form-control" required>
                  </div>
              </div>

               <div class="col-sm-12">
                  <div class="form-group">
                      <label> تأكيد كلمة المرور </label>
                      <input type="password" name="confirm_password" 
                        class="form-control" required>
                  </div>
              </div>


          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="تحديث" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>

@endsection