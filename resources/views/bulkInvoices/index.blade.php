@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="text-primary mb-0">فواتير الشركات</h3>
        <a href="{{ route('bulkInvoices.create') }}" class="btn btn-success">إنشاء فاتورة</a>
    </div>
    <div class="card-body border-bottom">
        <form action="{{ route('bulkInvoices.index') }}" method="GET" class="form-row align-items-end">
            <div class="form-group col-md-4">
                <label for="date_from">من تاريخ</label>
                <input id="date_from" type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="date_to">إلى تاريخ</label>
                <input id="date_to" type="date" name="date_to" value="{{ $dateTo }}" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-primary">عرض الفواتير</button>
                @if($dateFrom || $dateTo)
                    <a href="{{ route('bulkInvoices.index') }}" class="btn btn-secondary">إلغاء التصفية</a>
                @endif
            </div>
        </form>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>رقم الفاتورة</th>
                    <th>الشركة</th>
                    <th>التاريخ</th>
                    <th>الإجمالي</th>
                    <th>المدفوع</th>
                    <th>المتبقي</th>
                    <th>الحالة</th>
                    <th>التفاصيل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->company->name }}</td>
                        <td>{{ $invoice->issued_on->format('Y-m-d') }}</td>
                        <td>{{ number_format((float) $invoice->total, 2) }}</td>
                        <td>{{ number_format((float) $invoice->paid_amount, 2) }}</td>
                        <td>{{ number_format((float) $invoice->balance_due, 2) }}</td>
                        <td>
                            @if($invoice->payment_status === 'paid')
                                مدفوعة
                            @elseif($invoice->payment_status === 'partial')
                                مدفوعة جزئياً
                            @else
                                غير مدفوعة
                            @endif
                        </td>
                        <td><a href="{{ route('bulkInvoices.show', $invoice) }}" class="btn btn-sm btn-primary">عرض</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">لا توجد فواتير مسجلة.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $invoices->links() }}</div>
</div>
@endsection
