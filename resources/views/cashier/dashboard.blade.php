@extends('layouts.cashier')

@section('content')

<div class="cashier-welcome">
	<div class="cashier-card">
		<div class="cashier-card-header">
			<div>
				<h2 class="cashier-card-title">بوفية الشباب</h2>
				<span class="cashier-card-title-muted">لوحة الكاشير</span>
			</div>
		</div>
		<div class="cashier-card-body cashier-card-body--padded">
			<p class="mb-0 text-secondary">اختر إجراءً للمتابعة.</p>
			<div class="cashier-welcome-actions">
				<a class="btn btn-primary" href="{{ route('cashier.create') }}">
					<i class="fas fa-cash-register ms-1" aria-hidden="true"></i>
					نقطة البيع
				</a>
				<a class="btn btn-outline-dark" href="{{ route('cashier.sales') }}">
					<i class="fas fa-receipt ms-1" aria-hidden="true"></i>
					المبيعات
				</a>
			</div>
		</div>
	</div>
</div>

@endsection
