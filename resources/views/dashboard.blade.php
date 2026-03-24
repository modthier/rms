@extends('layouts.main')

@section('content')
@php
  $total_today = (float) ($total_today ?? 0);
  $daily_expenses = (float) ($daily_expenses ?? 0);
  $net_today = $total_today - $daily_expenses;
  $payment_methods_count = $total_by_payments->count();
  $topItems = $total_by_items->take(3);
  $targetValue = max($total_today + max($daily_expenses, 1), 1);
  $targetPercent = (int) max(0, min(100, round(($total_today / $targetValue) * 100)));
  if (! is_finite($targetPercent)) {
      $targetPercent = 0;
  }
  $arMonths = ['', 'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
  $todayAr = now()->day . ' ' . $arMonths[(int) now()->format('n')] . ' ' . now()->year;
@endphp

  <div class="admin-hero mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between">
      <div>
        <h2 class="admin-page-title mb-1">لوحة القيادة</h2>
        <p class="admin-page-subtitle mb-0">نظرة سريعة على أداء المطعم اليوم</p>
      </div>
      <div class="admin-date-chip">
        <i class="fa fa-calendar-alt ml-2"></i>
        {{ $todayAr }}
      </div>
    </div>
  </div>

  <div class="admin-kpi-row row">
    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
      <div class="admin-kpi-card kpi-sales d-flex align-items-start">
        <div class="kpi-icon-wrap mr-3"><i class="fa fa-shopping-bag fa-lg"></i></div>
        <div>
          <div class="kpi-label">مبيعات اليوم</div>
          <div class="kpi-value">{{ number_format($total_today, 0) }} <small class="text-muted">جنيه</small></div>
        </div>
        <div class="kpi-sparkline"></div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
      <div class="admin-kpi-card kpi-expenses d-flex align-items-start">
        <div class="kpi-icon-wrap mr-3"><i class="fa fa-users fa-lg"></i></div>
        <div>
          <div class="kpi-label">مصروفات اليوم</div>
          <div class="kpi-value">{{ number_format($daily_expenses, 0) }} <small class="text-muted">جنيه</small></div>
        </div>
        <div class="kpi-sparkline"></div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
      <div class="admin-kpi-card kpi-net d-flex align-items-start">
        <div class="kpi-icon-wrap mr-3"><i class="fa fa-utensils fa-lg"></i></div>
        <div>
          <div class="kpi-label">صافي اليوم</div>
          <div class="kpi-value">{{ number_format($net_today, 0) }} <small class="text-muted">جنيه</small></div>
        </div>
        <div class="kpi-sparkline"></div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
      <div class="admin-kpi-card d-flex align-items-start">
        <div class="kpi-icon-wrap mr-3"><i class="fa fa-wallet fa-lg"></i></div>
        <div>
          <div class="kpi-label">طرق الدفع (اليوم)</div>
          <div class="kpi-value">{{ $payment_methods_count }}</div>
        </div>
        <div class="kpi-sparkline"></div>
      </div>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-lg-8 mb-3 mb-lg-0">
      <div class="card sales-figure-card h-100">
        <div class="card-header">
          <h5 class="mb-0">مؤشر المبيعات</h5>
        </div>
        <div class="card-body p-0">
          <div class="admin-fake-chart">
            <div class="admin-fake-bars">
              @foreach([35, 52, 78, 59, 43, 66, 41, 57, 38, 64, 48, 80] as $height)
                <span style="height: {{ $height }}%"></span>
              @endforeach
            </div>
            <div class="admin-fake-months">
              @foreach(['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'] as $month)
                <span>{{ $month }}</span>
              @endforeach
            </div>
          </div>
          <div class="table-responsive px-3 pb-3">
            <table class="table table-hover mb-0 admin-compact-table">
              <thead>
                <tr>
                  <th>طريقة الدفع</th>
                  <th>عدد الأصناف</th>
                  <th>المجموع</th>
                </tr>
              </thead>
              <tbody>
                @forelse($total_by_payments as $total)
                <tr>
                  <td>{{ $total->method }}</td>
                  <td>{{ $total->total_items }}</td>
                  <td>{{ number_format($total->total_price, 2) }} جنيه</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">لا توجد مبيعات اليوم</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">تقدّم الهدف اليومي</h5>
          <span class="text-muted small">اليوم</span>
        </div>
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <div class="admin-progress-ring" style="--p: {{ $targetPercent }};">
            <div class="ring-inner">
              <strong>{{ $targetPercent }}%</strong>
              <span>الهدف</span>
            </div>
          </div>
          <div class="mt-3 text-center">
            <div class="font-weight-bold">{{ number_format($total_today, 2) }} جنيه</div>
            <small class="text-muted">من مبيعات اليوم</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-7 mb-3 mb-lg-0">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="mb-0">أكثر الأصناف مبيعاً</h5>
        </div>
        <div class="card-body">
          <div class="row">
            @forelse($topItems as $item)
            <div class="col-md-4 col-sm-6 mb-3">
              <div class="fav-item-card h-100">
                <div class="fav-item-thumb">
                  <i class="fa fa-hamburger"></i>
                </div>
                <div class="fav-item-name">{{ $item->name }}</div>
                <div class="fav-item-price">{{ number_format($item->total_price, 2) }} جنيه</div>
                <small class="text-muted">الكمية: {{ $item->total_quantity }}</small>
              </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-4">لا توجد أصناف مباعة اليوم</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="mb-0">تفصيل الأصناف</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0 admin-compact-table">
              <thead>
                <tr>
                  <th>الصنف</th>
                  <th>الكمية</th>
                  <th>المجموع</th>
                </tr>
              </thead>
              <tbody>
                @forelse($total_by_items as $t)
                <tr>
                  <td>{{ $t->name }}</td>
                  <td>{{ $t->total_quantity }}</td>
                  <td>{{ number_format($t->total_price, 2) }} جنيه</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">لا توجد مبيعات اليوم</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
