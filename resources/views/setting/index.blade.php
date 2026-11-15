@extends('layouts.main')

@section('content')

<div class="card">
        @if($setting->count() > 0)
        <div class="card-body table-responsive p-0">

            <table class="table table-hover">
                <thead>
                   
                    <th>اسم المطعم</th>
                    <th>نوع الفاتورة</th>
                    <th>طابعة العميل</th>
                    <th>طابعة المطبخ</th>
                    <th>عمليات</th>
                </thead>

                <tbody>
                  @foreach ($setting as $name)
                  <tr>
                    <td>{{ $name->name }}</td>
                    <td>{{ $name->receiptModeLabel() }}</td>
                    <td>{{ $name->customer_printer ?: 'غير محددة' }}</td>
                    <td>{{ $name->kitchen_printer ?: 'غير محددة' }}</td>
                    <td>
                       
                      <a href="{{ route('setting.edit',$name->id) }}" class="btn btn-success">تعديل</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        @else
        <h3 class="text-center text-danger mt-3 p-5"> لم يتم تعيين اسم المطعم بعد  </h3>
        <div class="text-center pb-4">
            <a href="{{ route('setting.create') }}" class="btn btn-primary">تعيين اسم المطعم</a>
        </div>
        @endif
    </div>

@endsection