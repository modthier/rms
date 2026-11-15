@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="text-primary mb-0">تعديل بيانات الشركة</h3></div>
    <div class="card-body">
        @include('companies.form', ['action' => route('companies.update', $company), 'method' => 'PUT'])
    </div>
</div>
@endsection
