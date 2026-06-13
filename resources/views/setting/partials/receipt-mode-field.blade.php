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
