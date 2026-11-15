@extends('layouts.main')

@section('content')
<div class="card mb-4" id="invoice-print">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="text-primary mb-0">فاتورة {{ $invoice->invoice_number }}</h3>
        <button type="button" class="btn btn-outline-secondary no-print" onclick="window.print()">طباعة</button>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>بيانات الشركة</h5>
                <div>{{ $invoice->company->name }}</div>
                @if($invoice->company->contact_name)<div>{{ $invoice->company->contact_name }}</div>@endif
                @if($invoice->company->phone)<div>{{ $invoice->company->phone }}</div>@endif
                @if($invoice->company->email)<div>{{ $invoice->company->email }}</div>@endif
                @if($invoice->company->tax_number)<div>الرقم الضريبي: {{ $invoice->company->tax_number }}</div>@endif
                @if($invoice->company->address)<div>{{ $invoice->company->address }}</div>@endif
            </div>
            <div class="col-md-6">
                <div>تاريخ الفاتورة: {{ $invoice->issued_on->format('Y-m-d') }}</div>
                <div>تاريخ الاستحقاق: {{ $invoice->due_on?->format('Y-m-d') ?? '—' }}</div>
                <div>أنشأها: {{ $invoice->user->name ?? '—' }}</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr><th>الصنف</th><th>الكمية</th><th>سعر الوحدة</th><th>الإجمالي</th></tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $line)
                        <tr>
                            <td>{{ $line->item_name }}</td>
                            <td>{{ $line->quantity }}</td>
                            <td>{{ number_format((float) $line->unit_price, 2) }}</td>
                            <td>{{ number_format((float) $line->line_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr><th colspan="3">الإجمالي</th><th>{{ number_format((float) $invoice->total, 2) }}</th></tr>
                    <tr><th colspan="3">المدفوع</th><th>{{ number_format((float) $invoice->paid_amount, 2) }}</th></tr>
                    <tr><th colspan="3">المتبقي</th><th>{{ number_format((float) $invoice->balance_due, 2) }}</th></tr>
                </tfoot>
            </table>
        </div>
        @if($invoice->notes)<p><strong>ملاحظات:</strong> {{ $invoice->notes }}</p>@endif
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h4 class="mb-0">سجل الدفعات</h4></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead><tr><th>التاريخ</th><th>المبلغ</th><th>طريقة الدفع</th><th>سجلها</th><th>ملاحظات</th></tr></thead>
            <tbody>
                @forelse($invoice->payments as $payment)
                    <tr>
                        <td>{{ $payment->paid_on->format('Y-m-d') }}</td>
                        <td>{{ number_format((float) $payment->amount, 2) }}</td>
                        <td>{{ $payment->payment_method ?: '—' }}</td>
                        <td>{{ $payment->user->name ?? '—' }}</td>
                        <td>{{ $payment->notes ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">لم يتم تسجيل دفعات بعد.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if((float) $invoice->balance_due > 0)
    <div class="card no-print">
        <div class="card-header"><h4 class="mb-0">تسجيل دفعة</h4></div>
        <div class="card-body">
            <form action="{{ route('bulkInvoices.payments.store', $invoice) }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="amount">المبلغ *</label>
                        <input id="amount" name="amount" type="number" min="0.01" max="{{ $invoice->balance_due }}" step="0.01" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="paid_on">تاريخ الدفع *</label>
                        <input id="paid_on" name="paid_on" type="date" value="{{ now()->toDateString() }}" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="payment_method">طريقة الدفع</label>
                        <input id="payment_method" name="payment_method" type="text" maxlength="100" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="payment_notes">ملاحظات</label>
                        <input id="payment_notes" name="notes" type="text" maxlength="2000" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">حفظ الدفعة</button>
            </form>
        </div>
    </div>
@endif
<a href="{{ route('bulkInvoices.index') }}" class="btn btn-secondary mt-3 no-print">العودة إلى الفواتير</a>
@endsection

@push('js')
<style>
    @media print {
        body * { visibility: hidden; }
        #invoice-print, #invoice-print * { visibility: visible; }
        #invoice-print { position: absolute; inset: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>
@endpush
