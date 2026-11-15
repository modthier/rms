@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="text-primary mb-0">إضافة شركة</h3></div>
    <div class="card-body">
        @include('companies.form', ['action' => route('companies.store'), 'method' => 'POST'])
    </div>
</div>
@endsection
