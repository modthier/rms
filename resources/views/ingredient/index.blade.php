@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   المكونات الاساسية  </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('ingredient.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                <th> المكون الاساسي </th>
                <th>عمليات</th>

                @foreach($ingredients as $ingredient)
                <tr>
                    <td>{{ $ingredient->ingredient }}</td>
                    <td>
                       
                        <a href="{{ route('ingredient.edit',$ingredient->id) }}" class="btn float-right">
                            <svg style="width: 30px; height: 30px;">
                              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-highlighter') }}"></use>
                            </svg>
                              
                        </a>


                         <!--
                         <form class="float-right"  id="delete_ingredient_{{ $ingredient->id }}"  action="{{ route('ingredient.destroy',$ingredient->id) }}"
                                method="post">
                                  @csrf

                              {{ method_field('DELETE') }}
                              <button  class="btn" onclick="event.preventDefault();
                                  var r = confirm(' هل انت متاكد ؟ ');
                                  if (r == true) {document.getElementById('delete_ingredient_{{ $ingredient->id }}').submit();}"><svg style="width: 30px; height: 30px;">
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
        {{ $ingredients->links() }}
    </div>
</div>


</div>	

@endsection