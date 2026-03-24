@extends('layouts.main')

@section('content')
<div class="row">
  	  <div class="col-lg-3">
  	  		<div class="card text-white bg-gradient-primary">
  	  			<div class="card-body">
  	  				<h3> المجموع الكلي</h3>
  	  				{{ number_format($total,2) }} جنيه
  	  			</div>
  	  			
  	  		</div>
  	  </div>

  	  <div class="col-lg-3">
  	  		<div class="card text-white bg-gradient-info">
  	  			<div class="card-body">
  	  				<h3> مجموع اليوم </h3>
  	  				{{ number_format($total_today,2) }} جنيه
  	  			</div>
  	  			
  	  		</div>
  	  </div>


  	  <div class="col-lg-3">
  	  		<div class="card text-white bg-gradient-warning">
  	  			<div class="card-body">
  	  				<h3> مجموع  الاسبوع </h3>
  	  				{{ number_format($total_week,2) }} جنيه
  	  			</div>
  	  			
  	  		</div>
  	  </div>


  	  <div class="col-lg-3">
  	  		<div class="card text-white bg-gradient-danger">
  	  			<div class="card-body">
  	  				<h3> مجموع  الشهر </h3>
  	  				{{ number_format($total_month,2) }} جنيه
  	  			</div>
  	  			
  	  		</div>
  	  </div>
  </div>
<div class="card">
    <div class="card-header">
        <div class="card-title float-right">
            <h3 class="text-primary">   قائمة  الاحتياجات </h3>
        </div>

        
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table  table-hover table-lg">
                <th> النوع </th>
                <th>الكمية</th>
                <th>السعر الكلي</th>
                <th> التاريخ </th>
                <th>عمليات</th>

                @foreach($requirements as $item)
                <tr>
                    <td>{{ $item->requirementType->name }}</td>
                    <td>{{ $item->quantity }} {{ $item->unit->unit }}</td>
                    <td>{{ number_format($item->total_price,2) }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                       
                        
                        @if($item->requirementChange()->count())
                        <a class="btn  req_change" data-id="{{ $item->id }}">
                        <svg style="width: 30px; height: 30px;">
                              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-history') }}"></use>
                            </svg>
                         </a>
                        @endif
                        

                    </td>
                </tr>
                @endforeach
            </table>
        </div>


    </div>

    <div class="card-footer">
        {{ $requirements->links() }}
    </div>
</div>


</div>	

<div id="modal-area">
  
</div>

@endsection
@push('js')
<script>
    $('body').on('click','.req_change',function () {
        var id = $(this).data('id');
         var html = `
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="price_change">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="exampleModalLongTitle"> عرض  التغيير  </h5>
                       
                        
                    </div>
                    <div class="modal-body" id="loadPriceChangeForm">
                       <div id="overlay" style="height:100px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="clsBtnFooter" data-dismiss="modal">إغلاق</button>
                        
                    </div>
                </div>
            </div>
       </div>
        `;

        $.ajax({
            url : '/reqChange/'+id,
            type : 'get',
            success:function(result){
               $('#modal-area').html(html);
               $('#loadPriceChangeForm').html(result);
               $('#price_change').modal('show');
            }
        });
    });
</script>
@endpush