<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif
    <div class="form-group">
        <label for="name">اسم الشركة *</label>
        <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $company->name ?? '') }}" maxlength="255" required>
    </div>
    <div class="form-group">
        <label for="contact_name">اسم جهة الاتصال</label>
        <input id="contact_name" name="contact_name" type="text" class="form-control" value="{{ old('contact_name', $company->contact_name ?? '') }}" maxlength="255">
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">البريد الإلكتروني</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $company->email ?? '') }}" maxlength="255">
        </div>
        <div class="form-group col-md-6">
            <label for="phone">الهاتف</label>
            <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone', $company->phone ?? '') }}" maxlength="50">
        </div>
    </div>
    <div class="form-group">
        <label for="tax_number">الرقم الضريبي</label>
        <input id="tax_number" name="tax_number" type="text" class="form-control" value="{{ old('tax_number', $company->tax_number ?? '') }}" maxlength="100">
    </div>
    <div class="form-group">
        <label for="address">العنوان</label>
        <textarea id="address" name="address" class="form-control" rows="3" maxlength="2000">{{ old('address', $company->address ?? '') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">حفظ</button>
    <a href="{{ route('companies.index') }}" class="btn btn-secondary">إلغاء</a>
</form>
