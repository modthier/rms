@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">  وحدات القياس  </h3>
        </div>

        <div class="float-left">
            <button class="btn btn-success btn-lg" id="unit_show">  جديد  </button>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> الوحدة </th>
                <th> عمليات </th>
                
                
                @foreach($units as $unit)
                <tr>
                   <td>{{ $unit->unit }}</td>
                   <td>
                       <a class="btn btn-danger" href="{{ route('unit.edit',$unit->id) }}">تعديل</a>
                   </td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        
    </div>
</div>


<div class="modal  fade"  id="unit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog   modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('unit.store') }}" method="post">
                    {{ csrf_field() }} 
                    <div class="form-group">
                        <label> الوحدة </label>
                        <input type="text" name="unit" class="form-control" required>
                    </div>

                    <input type="submit" value="حفظ" class="btn btn-primary">
                </form>
            </div>

        </div>
    </div>
</div>

@endsection