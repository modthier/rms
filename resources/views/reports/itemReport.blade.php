 @extends('layouts.main')

@section('content')
@include('reports.partials.report-styles')
<div class="report-page">

<div class="card report-page-header">
    <div class="card-header">
        <div class="card-title">
            <h1 class="text-center">   تقرير مبيعات بالمنتج </h1>
        </div>
    </div>
</div>

<div class="row">
      <div class="col-lg-12">
          <div class="card report-table-card">
            <div class="card-header">
              <div class="card-title mb-0">
                <h3 class="mb-0">تفاصيل الصنف</h3>
              </div>
            </div>
            <div class="card-body p-0">
              @if($report->count() > 0)
              <table class="table table-hover table-lg mb-0">
                <thead><tr>
                  <th>اسم الصنف</th>
                  <th>عدد مرات البيع</th>
                  <th>المجموع</th>
                </tr></thead>
                <tbody>
                 <tr>
                  <td>{{ $report->first()->name }}</td>
                  <td>{{ $report->first()->frequancy }}</td>
                  <td>{{ number_format($report->first()->total_price,2) }} جنيه</td>
                 </tr>
                </tbody>
              </table>
              @else
                <div class="report-empty-state text-center p-4 m-3">
                  <h3 class="mb-0">لا يوجد بيانات في هذا التاريخ</h3>
                </div>
              @endif
            </div>
          </div>
      </div>
</div>
</div>
@endsection