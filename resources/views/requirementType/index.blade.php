@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary"> انواع احتياجات المطعم </h3>
        </div>

        <div class="float-left">
            <button class="btn btn-success btn-lg" id="unit_show">  جديد  </button>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> النوع </th>
                <th> عمليات </th>
                
                
                @foreach($requirementType as $item)
                <tr>
                   <td>{{ $item->name }}</td>
                   <td>
                       <a class="btn btn-danger" href="{{ route('requirementType.edit',$item->id) }}">تعديل</a>
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
                <form action="{{ route('requirementType.store') }}" method="post">
                    {{ csrf_field() }} 
                    <div class="form-group">
                        <label> النوع </label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <input type="submit" value="حفظ" class="btn btn-primary">
                </form>
            </div>

        </div>
    </div>
</div>

@endsection