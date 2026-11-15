@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="text-primary mb-0">إضافة اسم المطعم</h3>
        </div>

        <div class="card-body">
            <form class="form" action="{{ route('setting.store') }}" role="form" autocomplete="off" method="POST">
                @csrf
                <div class="form-group">
                    <label for="setting-name">اسم المطعم</label>
                    <input
                        type="text"
                        class="form-control"
                        id="setting-name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                @include('setting.partials.receipt-mode-field')

                <button type="submit" class="btn btn-primary btn-lg">حفظ</button>
            </form>
        </div>
    </div>
@endsection
