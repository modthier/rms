@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">  انواع الأصناف  </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('itemType.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> نوع الصنف </th>
                <th> إسم مجموعة الصنف </th>
                <th>عمليات</th>

                @foreach($itemTypes as $itemType)
                <tr>
                    <td>{{ $itemType->type }}</td>
                    <td>{{ $itemType->label }}</td>
                    <td>
                       
                        <a href="{{ route('itemType.edit',$itemType->id) }}" class="btn float-right">
                            <svg style="width: 30px; height: 30px;">
                              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-highlighter') }}"></use>
                            </svg>
                              
                        </a>


                         <!--
                         <form class="float-right"  id="delete_ingredient_{{ $itemType->id }}"  action="{{ route('itemType.destroy',$itemType->id) }}"
                                method="post">
                                  @csrf

                              {{ method_field('DELETE') }}
                              <button  class="btn" onclick="event.preventDefault();
                                  var r = confirm(' هل انت متاكد ؟ ');
                                  if (r == true) {document.getElementById('delete_itemType_{{ $itemType->id }}').submit();}"><svg style="width: 30px; height: 30px;">
                                      <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}"></use>
                                    </svg>
                              </button>
                  
                        </form>
                        -->

                    </td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        {{ $itemTypes->links() }}
    </div>
</div>


</div>	

@endsection