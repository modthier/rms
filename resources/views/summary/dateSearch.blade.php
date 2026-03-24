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
 <section class="col-lg-12">
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body table-responsive p-0">
            
            <table class="table table-hover">
                <thead>
                    <th>مجموع المبيعات </th>
                    <th>مجموع المشتريات </th>
                    <th>مجموع المنصرفات </th>
                    <th>مجموع الاحتياجات </th>
                    <th>صافي الربح </th>
                    
                </thead>

                <tbody>
                
                 <tr>
                    <td>{{ number_format($total,2) }}</td>
                    <td>{{ number_format($po_total,2) }}</td>
                    <td>{{ number_format($expense_total,2) }}</td>
                    <td>{{ number_format($requirement_total,2) }}</td>
                    <td>{{ number_format($net_profit,2) }}</td>
                    
                 </tr>
                </tbody>
            </table>
          
        </div>
       


        <div class="card-footer">
         
        </div>



    </div>
</section>
</div>
@endsection