@php
    $venueName = ($name ?? null)?->name ?? config('app.name');
    $salesActive = request()->routeIs('cashier.sales', 'cashier.showSales');
    $posActive = request()->routeIs('cashier.create');
    $dashActive = request()->routeIs('cashier.Dashboard');
    $liveActive = request()->routeIs('order.realtime');
@endphp

<header class="cashier-topbar">
	<div class="cashier-topbar-inner">
		<button type="button" class="cashier-menu-btn leftmenutrigger" aria-expanded="false" aria-controls="cashierDrawer" aria-label="فتح القائمة">
			<span class="cashier-menu-bars" aria-hidden="true"></span>
		</button>
		<div class="cashier-brand">
			<span class="cashier-brand-mark" aria-hidden="true"><i class="fas fa-store"></i></span>
			<span class="cashier-brand-text">{{ $venueName }}</span>
		</div>
		@auth
			<div class="cashier-user-pill d-none d-sm-flex">
				<i class="fas fa-user-circle ms-1" aria-hidden="true"></i>
				<span>{{ Auth::user()->name }}</span>
			</div>
		@endauth
	</div>
</header>

<div class="cashier-sidebar-backdrop" aria-hidden="true"></div>

<aside class="side-nav cashier-drawer animate" id="cashierDrawer" aria-label="قائمة الكاشير">
	<div class="cashier-drawer-head">
		<span class="cashier-drawer-title">التنقّل</span>
	</div>
	<nav class="cashier-drawer-nav">
		
		<a class="cashier-nav-item {{ $posActive ? 'is-active' : '' }}" href="{{ route('cashier.create') }}">
			<i class="fas fa-cash-register" aria-hidden="true"></i>
			<span>نقطة البيع</span>
		</a>
		<a class="cashier-nav-item {{ $salesActive ? 'is-active' : '' }}" href="{{ route('cashier.sales') }}">
			<i class="fas fa-receipt" aria-hidden="true"></i>
			<span>المبيعات</span>
		</a>
		<a class="cashier-nav-item {{ $liveActive ? 'is-active' : '' }}" href="{{ route('order.realtime') }}">
			<i class="fas fa-broadcast-tower" aria-hidden="true"></i>
			<span>الطلبات اللحظية</span>
		</a>
		<hr class="cashier-drawer-rule">
		<a class="cashier-nav-item cashier-nav-item--danger" href="{{ route('logout') }}"
		   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
			<i class="fas fa-sign-out-alt" aria-hidden="true"></i>
			<span>{{ __('Logout') }}</span>
		</a>
	</nav>
</aside>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
	@csrf
</form>
