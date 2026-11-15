@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="text-primary mb-0">إنشاء فاتورة شركة</h3></div>
    <div class="card-body">
        @if($companies->isEmpty())
            <div class="alert alert-info">
                أضف شركة أولاً لإنشاء فاتورة.
                <a href="{{ route('companies.create') }}">إضافة شركة</a>
            </div>
        @elseif($items->isEmpty())
            <div class="alert alert-info">أضف أصنافاً إلى القائمة أولاً لإنشاء فاتورة.</div>
        @else
            <form action="{{ route('bulkInvoices.store') }}" method="POST" id="invoice-form">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="company_id">الشركة *</label>
                        <select id="company_id" name="company_id" class="form-control" required>
                            <option value="">اختر الشركة</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" @selected(old('company_id', request('company_id')) == $company->id)>{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="issued_on">تاريخ الفاتورة *</label>
                        <input id="issued_on" name="issued_on" type="date" class="form-control" value="{{ old('issued_on', now()->toDateString()) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="due_on">تاريخ الاستحقاق</label>
                        <input id="due_on" name="due_on" type="date" class="form-control" value="{{ old('due_on') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">الأصناف</h5>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-line">إضافة صنف</button>
                </div>
                <div id="invoice-lines"></div>
                <template id="invoice-line-template">
                    <div class="form-row align-items-end invoice-line border-bottom pb-3 mb-3">
                        <div class="form-group col-md-5">
                            <label>الصنف *</label>
                            <select class="form-control item-select" required>
                                <option value="">اختر الصنف</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" data-price="{{ number_format((float) $item->price, 2, '.', '') }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>الكمية *</label>
                            <input class="form-control quantity-input" type="number" min="1" value="1" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label>سعر الوحدة *</label>
                            <input class="form-control price-input" type="number" min="0.01" step="0.01" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label>الإجمالي</label>
                            <output class="line-total form-control">0.00</output>
                        </div>
                        <div class="form-group col-md-1">
                            <button type="button" class="btn btn-outline-danger remove-line" aria-label="حذف الصنف">×</button>
                        </div>
                    </div>
                </template>
                <div class="text-left mb-3">
                    <strong>إجمالي الفاتورة: <span id="invoice-total">0.00</span></strong>
                </div>
                <div class="form-group">
                    <label for="notes">ملاحظات</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3" maxlength="2000">{{ old('notes') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">إنشاء الفاتورة</button>
                <a href="{{ route('bulkInvoices.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
    (function () {
        const lines = document.getElementById('invoice-lines');
        const template = document.getElementById('invoice-line-template');
        const total = document.getElementById('invoice-total');
        let nextIndex = 0;

        function updateTotals() {
            let invoiceTotal = 0;
            lines.querySelectorAll('.invoice-line').forEach(function (line) {
                const quantity = Number(line.querySelector('.quantity-input').value) || 0;
                const price = Number(line.querySelector('.price-input').value) || 0;
                const lineTotal = quantity * price;
                line.querySelector('.line-total').textContent = lineTotal.toFixed(2);
                invoiceTotal += lineTotal;
            });
            total.textContent = invoiceTotal.toFixed(2);
        }

        function addLine() {
            const fragment = template.content.cloneNode(true);
            const line = fragment.querySelector('.invoice-line');
            line.querySelector('.item-select').name = 'items[' + nextIndex + '][item_id]';
            line.querySelector('.quantity-input').name = 'items[' + nextIndex + '][quantity]';
            line.querySelector('.price-input').name = 'items[' + nextIndex + '][unit_price]';
            nextIndex += 1;
            lines.appendChild(fragment);
        }

        document.getElementById('add-line').addEventListener('click', addLine);
        lines.addEventListener('change', function (event) {
            if (event.target.matches('.item-select')) {
                const option = event.target.selectedOptions[0];
                const priceInput = event.target.closest('.invoice-line').querySelector('.price-input');
                if (option.value) {
                    priceInput.value = option.dataset.price;
                }
            }
            updateTotals();
        });
        lines.addEventListener('input', updateTotals);
        lines.addEventListener('click', function (event) {
            if (event.target.matches('.remove-line')) {
                event.target.closest('.invoice-line').remove();
                updateTotals();
            }
        });

        addLine();
    })();
</script>
@endpush
