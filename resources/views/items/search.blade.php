@extends('layouts.main')

@section('content')

      <div class="col-lg-12">
  	<div class="card">
  			<div class="card-header">
  					بحث في المنتجات 
			</div>
  			<div class="card-body p-2">
  					<form action="{{ route('item.search') }}" method="get">
              <div class="row">
              	  <div class="col-lg-12">
              	  	 <div class="form-group">
                          <label> اسم المنتج  </label>
                          <input type="text" class="form-control" name="q" required>
                      </div>
              	  </div>
              </div>

              <div class="form-group">
                  <input type="submit" value="بحث" class="btn btn-success btn-lg">
              </div>
          </form>
  			</div>
  	</div>
 
<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">    نتيجة البحث  </h3>
        </div>

        <div class="float-left">
            <a href="{{ route('item.create') }}" class="btn btn-success btn-lg">  جديد  </a>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                
                <th> اسم الصنف </th>
                <th> سعر الصنف </th>
                <th> نوع الصنف </th>
                <th> المكون الاساسي </th>
                <th> صورة الصنف </th>
                <th>عمليات</th>
                

                @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->price,2) }}</td>
                   
                    <td>{{ $item->itemType->type }}</td>
                    <td>{{ $item->ingredient?->ingredient ?? '—' }}</td>
                    <td><img class="img-fluid item-img-index" src="{{ asset('storage/images/items/'.$item->icon) }}"></td>
                    <td>
                       
                        <a href="{{ route('item.edit',$item->id) }}" class="btn float-right">
                            <svg style="width: 30px; height: 30px;">
                              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-highlighter') }}"></use>
                            </svg>
                              
                        </a>


                         <!--
                         <form class="float-right"  id="delete_item_{{ $item->id }}"  action="{{ route('item.destroy',$item->id) }}"
                                method="post">
                                  @csrf

                              {{ method_field('DELETE') }}
                              <button  class="btn" onclick="event.preventDefault();
                                  var r = confirm(' هل انت متاكد ؟ ');
                                  if (r == true) {document.getElementById('delete_item_{{ $item->id }}').submit();}"><svg style="width: 30px; height: 30px;">
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
        {{ $items->links() }}
    </div>
</div>


</div>	
</div>
@endsection