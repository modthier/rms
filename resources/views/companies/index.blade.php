@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="text-primary mb-0">الشركات</h3>
        <a href="{{ route('companies.create') }}" class="btn btn-success">إضافة شركة</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>اسم الشركة</th>
                    <th>جهة الاتصال</th>
                    <th>الهاتف</th>
                    <th>عدد الفواتير</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->contact_name ?: '—' }}</td>
                        <td>{{ $company->phone ?: '—' }}</td>
                        <td>{{ $company->bulk_invoices_count }}</td>
                        <td>
                            <a href="{{ route('companies.edit', $company) }}" class="btn btn-sm btn-warning">تعديل</a>
                            <a href="{{ route('bulkInvoices.create', ['company_id' => $company->id]) }}" class="btn btn-sm btn-primary">فاتورة جديدة</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">لا توجد شركات مسجلة.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $companies->links() }}</div>
</div>
@endsection
