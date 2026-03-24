@extends('layouts.main')



@section('content')
<!-- Content Header (Page header) -->
<div class="row">
 <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
          <div class="card-title">
              تقرير بين تاريخين
          </div>
      </div>
      <div class="card-body">  
        <form action="{{ route('summary.search') }}" method="get">
              <div class="row">
                  <div class="col-lg-6">
                      <div class="form-group">
                          <label>   من تاريخ  </label>
                          <input type="date" name="date_from" class="form-control" required>
                      </div>
                  </div>

                   <div class="col-lg-6">
                      <div class="form-group">
                          <label>    الي تاريخ   </label>
                          <input type="date" name="date_to" class="form-control" required>
                      </div>
                  </div>
              </div>

              <div class="form-group">
                  <input type="submit" value="Search" class="btn btn-success">
              </div>
          </form>
       </div>
    </div>
</div></div>
  <div class="row">
 <div class="col-lg-6 col-md-6 col-sm-12">
  <!-- small box -->
      <div class="card">
      <div class="card-body">
        <strong>الملخص الشامل</strong>
        <hr>
        
        

        <h4>مجموع المبيعات : {{ number_format($total,2) }}</h4>
        <h4>مجموع المشتريات : {{ number_format($po_total,2) }}</h4>

        <h4>مجموع المنصرفات : {{ number_format($expense_total,2) }}</h4>
        <h4>مجموع الاحتياجات : {{ number_format($requirement_total,2) }}</h4>
      

        <h4>صافي الربح : {{ number_format( $net_profit_year ,2) }}</h4>

      
      </div>

     </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12">
  <!-- small box -->
      <div class="card">
      <div class="card-body">
        <strong>ملخص اليوم</strong>
        <hr>
        <h4>مجموع المبيعات : {{ number_format($total_today,2) }}</h4>
        <h4>مجموع المشتريات : {{ number_format($po_today,2) }}</h4>

        <h4>مجموع المنصرفات : {{ number_format($expense_today,2) }}</h4>
        <h4>مجموع الاحتياجات : {{ number_format($requirement_today,2) }}</h4>
      

        <h4>صافي الربح : {{ number_format($net_profit_today ,2) }}</h4>
      </div>

     </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12">
  <!-- small box -->
      <div class="card">
      <div class="card-body">
        <strong>ملخص الاسبوع</strong>
        <hr>
        <h4>مجموع المبيعات : {{ number_format($total_week,2) }}</h4>
        <h4>مجموع المشتريات : {{ number_format($po_week,2) }}</h4>

        <h4>مجموع المنصرفات : {{ number_format($expense_week,2) }}</h4>
        <h4>مجموع الاحتياجات : {{ number_format($requirement_week,2) }}</h4>
      

        <h4>صافي الربح : {{ number_format($net_profit_week ,2) }}</h4>
      </div>

     </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12">
  <!-- small box -->
      <div class="card">
      <div class="card-body">
        <strong> ملخص الشهر </strong>
        <hr>
        <h4>مجموع المبيعات : {{ number_format($total_month,2) }}</h4>
        <h4>مجموع المشتريات : {{ number_format($po_month,2) }}</h4>

        <h4>مجموع المنصرفات : {{ number_format($expense_month,2) }}</h4>
        <h4>مجموع الاحتياجات : {{ number_format($requirement_month,2) }}</h4>
      

        <h4>صافي الربح : {{ number_format($net_profit_month ,2) }}</h4>
      </div>

     </div>
</div>

</div>



@endsection