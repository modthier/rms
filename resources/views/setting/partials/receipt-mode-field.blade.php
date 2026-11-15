@php
    use App\Models\Setting;
@endphp

<div class="form-group">
    <label>نوع الفاتورة</label>
    <div class="d-flex flex-column gap-2">
        <label class="d-flex align-items-center gap-2 mb-0">
            <input type="radio" name="receipt_mode" value="{{ Setting::RECEIPT_MODE_DUAL }}"
                {{ old('receipt_mode', $selectedReceiptMode ?? Setting::RECEIPT_MODE_DUAL) === Setting::RECEIPT_MODE_DUAL ? 'checked' : '' }}>
            <span>فاتورتان منفصلتان (مطبخ وعميل)</span>
        </label>
        <label class="d-flex align-items-center gap-2 mb-0">
            <input type="radio" name="receipt_mode" value="{{ Setting::RECEIPT_MODE_SINGLE }}"
                {{ old('receipt_mode', $selectedReceiptMode ?? Setting::RECEIPT_MODE_DUAL) === Setting::RECEIPT_MODE_SINGLE ? 'checked' : '' }}>
            <span>فاتورة واحدة عامة للمطبخ والعميل</span>
        </label>
    </div>
</div>

<div class="form-group mt-4" data-qz-printer-settings>
    <label>طابعات الفواتير (QZ Tray)</label>
    <p class="text-muted">اكتشف الطابعات بعد تشغيل QZ Tray على هذا الجهاز، ثم اختر أسماء الطابعات كما تظهر في النظام.</p>
    <datalist id="qz-printer-list"></datalist>
    <div class="form-group">
        <label for="customer_printer">طابعة نسخة العميل</label>
        <input id="customer_printer" name="customer_printer" type="text" class="form-control"
            list="qz-printer-list" maxlength="255"
            value="{{ old('customer_printer', $customerPrinter ?? '') }}">
    </div>
    <div class="form-group">
        <label for="kitchen_printer">طابعة نسخة المطبخ</label>
        <input id="kitchen_printer" name="kitchen_printer" type="text" class="form-control"
            list="qz-printer-list" maxlength="255"
            value="{{ old('kitchen_printer', $kitchenPrinter ?? '') }}">
    </div>
    <button type="button" class="btn btn-outline-secondary" data-qz-discover-printers>اكتشاف الطابعات</button>
    <span class="ml-2" data-qz-printer-status aria-live="polite"></span>
</div>

<div class="form-group mt-4">
    <label for="receipt_font_size">حجم نص الفاتورة</label>
    <div class="d-flex align-items-center">
        <input id="receipt_font_size" name="receipt_font_size" type="range"
            class="form-control-range flex-grow-1" min="8" max="24" step="1"
            value="{{ old('receipt_font_size', $receiptFontSize ?? Setting::DEFAULT_RECEIPT_FONT_SIZE) }}"
            aria-describedby="receipt-font-size-value">
        <output id="receipt-font-size-value" class="ml-3" for="receipt_font_size">
            {{ old('receipt_font_size', $receiptFontSize ?? Setting::DEFAULT_RECEIPT_FONT_SIZE) }}px
        </output>
    </div>
    <small class="form-text text-muted">اسحب المؤشر لمعاينة حجم النص قبل حفظ الإعداد.</small>
</div>

<div class="form-group">
    <label>معاينة الفاتورة</label>
    <div class="bg-light p-3">
        <div class="receipt-paper" id="receipt-size-preview"
            style="--receipt-font-size: {{ (int) old('receipt_font_size', $receiptFontSize ?? Setting::DEFAULT_RECEIPT_FONT_SIZE) }}px">
            <div class="receipt-header">
                <h3 class="receipt-title" id="receipt-preview-name">مطعمك</h3>
                <div class="receipt-meta">
                    <div>رقم الفاتورة : ١٢٣</div>
                    <div>نوع الطلب : سفري</div>
                    <div>طريقة الدفع : نقداً</div>
                    <div>التاريخ : ٢٠٢٦/١١/١٥ &nbsp; الوقت : ١٢:٣٠</div>
                </div>
            </div>
            <div class="receipt-section-label">نسخة العميل</div>
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th class="text-right">اسم الصنف</th>
                        <th class="text-center">الكمية</th>
                        <th class="text-left">السعر</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>قهوة عربية</td>
                        <td class="text-center">٢</td>
                        <td class="text-left">١٠٫٠٠</td>
                    </tr>
                </tbody>
            </table>
            <div class="receipt-totals">
                <div class="receipt-total-row grand">اجمالي الفاتورة : ١٠٫٠٠</div>
            </div>
            <div class="receipt-footer">
                عدد الأصناف : ٢<br>
                شكراً لزيارتكم
            </div>
        </div>
    </div>
</div>

@include('cashier.partials.receipt-styles')

@push('js')
    @vite('resources/js/qz-printer-settings.js')
    <script>
        (function () {
            var sizeInput = document.getElementById('receipt_font_size');
            var preview = document.getElementById('receipt-size-preview');
            var sizeValue = document.getElementById('receipt-font-size-value');
            var nameInput = document.getElementById('setting-name');
            var previewName = document.getElementById('receipt-preview-name');

            if (sizeInput && preview && sizeValue) {
                sizeInput.addEventListener('input', function () {
                    preview.style.setProperty('--receipt-font-size', sizeInput.value + 'px');
                    sizeValue.textContent = sizeInput.value + 'px';
                });
            }

            if (nameInput && previewName) {
                nameInput.addEventListener('input', function () {
                    previewName.textContent = nameInput.value || 'مطعمك';
                });
            }
        })();
    </script>
@endpush
