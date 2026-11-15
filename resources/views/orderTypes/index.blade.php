@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary mb-0">أنواع الطلبات</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('orderType.store') }}" method="POST" class="form">
                @csrf
                <div class="form-group">
                    <label for="order-type-name">اسم نوع الطلب</label>
                    <input
                        id="order-type-name"
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        maxlength="255"
                        required
                    >
                </div>
                <button type="submit" class="btn btn-primary">إضافة نوع الطلب</button>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>نوع الطلب</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orderTypes as $orderType)
                        <tr>
                            <td>{{ $orderType->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-muted">لا توجد أنواع طلبات مضافة بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $orderTypes->links() }}
        </div>
    </div>
@endsection
