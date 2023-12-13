 @extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h1 class="text-center">   تقرير مبيعات بالمنتج </h1>
        </div>
    </div>
</div>

<div class="row">
  



     


      <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              
            </div>
            <div class="card-body p-0">
              @if($report->count() > 0)
              <table class="table table-hovered table-lg">
                <th>اسم الصنف</th>
                <th>عدد مرات البيع</th>
                <th>المجموع</th>
                 <tr>
                  <td>{{ $report->first()->name }}</td>
                  <td>{{ $report->first()->frequancy }}</td>
                  <td>{{ number_format($report->first()->total_price,2) }} جنيه</td>
                 </tr>
                
              </table>
              @else 
                <h3 class="text-danger text-center p-3">لا يوجد بيانات في هذا التاريخ</h3>
              @endif
              
            </div>
            
          </div>
      </div>
 
</div>
@endsection