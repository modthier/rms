@extends('layouts.main')

@section('content')

<div class="card">
        @if($setting->count() > 0)
        <div class="card-body table-responsive p-0">

            <table class="table table-hover">
                <thead>
                   
                    <th>اسم المطعم</th>
                    <th>عمليات</th>
                </thead>

                <tbody>
                  @foreach ($setting as $name)
                  <tr>
                    <td>{{ $name->name }}</td>
                    <td>
                       
                      <a href="{{ route('setting.edit',$name->id) }}" class="btn btn-success">تعديل</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        @else
        <h3 class="text-center text-danger mt-3 p-5"> لم يتم تعيين اسم المطعم بعد  </h3>
        <button class="btn btn btn-primary" id="show">  تعيين اسم المطعم  </button>
        @endif

        



    </div>	


    <div class="modal  fade"  id="resturnat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog   modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('setting.store') }}" method="post">
                    {{ csrf_field() }} 
                    <div class="form-group">
                        <label> اسم المطعم </label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <input type="submit" value="حفظ" class="btn btn-primary">
                </form>
            </div>

        </div>
    </div>
</div>

@endsection