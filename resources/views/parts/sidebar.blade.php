@php
    $openProducts = request()->routeIs(
        'cashier.*',
        'order.realtime',
        'item.*',
        'itemType.*',
        'ingredient.*',
    );
    $openStock = request()->routeIs(
        'purchaseOrders.*',
        'suppliers.*',
        'stock.*',
        'dailyConsumption.*',
        'order.dailyReport',
    );
    $openExpense = request()->routeIs(
        'requirement.*',
        'requirementType.*',
        'dailyExpense.*',
        'expenseType.*',
        'expense.change',
    );
    $openHr = request()->routeIs('employee.*', 'advance.*', 'attendance.*', 'employee.calculateSalary');
    $openUsers = request()->routeIs('management.*');
    $openReports = request()->routeIs(
        'order.index',
        'order.show',
        'order.edit',
        'order.create',
        'order.store',
        'order.update',
        'order.destroy',
        'order.canceledOrder',
        'order.canceledSearch',
        'order.weeklyReport',
        'order.monthlyReport',
        'order.exportWeekReport',
        'order.exporMonthReport',
        'order.productReport',
        'order.hourlySearch',
        'requirement.showReqReport',
        'dailyExpense.showExpenseReport',
        'dailyExpense.search',
        'summary.*',
    );
    $openSettings = request()->routeIs('unit.*', 'setting.*', 'payment.*');
@endphp

<aside id="ta-sidebar" class="ta-sidebar px-4 pb-6 pt-5" aria-label="القائمة الجانبية">
    <div class="ta-brand-row mb-6 flex items-center justify-between gap-2">
        <a href="{{ Auth::user()->can('admin_only') ? route('admin.dashboard') : route('home') }}"
           class="ta-sb-logo-full flex items-center gap-2 no-underline">
            <span class="text-lg font-semibold text-gray-800">{{ config('app.name') }}</span>
        </a>
        <span class="ta-sb-logo-icon h-9 w-9 rounded-lg bg-brand-50 text-brand-600">
            <i class="fa fa-utensils"></i>
        </span>
        <button type="button" data-ta-collapse-sidebar
                class="ta-sb-label hidden h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 xl:inline-flex"
                title="طي القائمة">
            <i class="fa fa-angle-double-right"></i>
        </button>
    </div>

    <div class="mb-4 flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50/80 p-3">
        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('img/placeholder-face-big.png') }}" alt="">
        <div class="ta-sb-label min-w-0 flex-1 text-right">
            <div class="truncate text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? '' }}</div>
            <a href="{{ Auth::user()->can('admin_only') ? route('admin.dashboard') : route('home') }}"
               class="text-xs text-gray-500 hover:text-brand-600">لوحة سريعة</a>
        </div>
    </div>

    <nav class="custom-scrollbar flex flex-1 flex-col overflow-y-auto no-scrollbar">
        <p class="ta-nav-section-title mb-3 text-xs font-semibold uppercase tracking-wide text-gray-400">القائمة</p>
        <ul class="flex flex-col gap-1">
            <li>
                @if (Auth::user()->can('admin_only'))
                    <a href="{{ route('admin.dashboard') }}"
                       class="menu-item {{ request()->routeIs('admin.dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}">
                        <i class="fa fa-tachometer-alt w-5 shrink-0 text-center text-sm"></i>
                        <span class="ta-sb-label">لوحة القيادة</span>
                    </a>
                @else
                    <a href="{{ route('home') }}"
                       class="menu-item {{ request()->routeIs('home') ? 'menu-item-active' : 'menu-item-inactive' }}">
                        <i class="fa fa-home w-5 shrink-0 text-center text-sm"></i>
                        <span class="ta-sb-label">الرئيسية</span>
                    </a>
                @endif
            </li>

            @can('admin_only')
                <li>
                    <details class="ta-nav-details" @if ($openProducts) open @endif>
                        <summary
                            class="menu-item cursor-pointer select-none {{ $openProducts ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <i class="fa fa-box-open w-5 shrink-0 text-center text-sm"></i>
                            <span class="ta-sb-label">الأصناف</span>
                            <i class="fa fa-chevron-down ta-chevron ta-sb-chevron text-xs"></i>
                        </summary>
                        <ul class="ta-nav-sub mr-9 mt-1 space-y-0.5 border-r border-gray-100 pr-2">
                            <li><a class="menu-dropdown-item {{ request()->routeIs('cashier.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   target="_blank" rel="noopener" href="{{ route('cashier.create') }}"><i
                                        class="fa fa-external-link-alt ml-1 text-xs opacity-60"></i>نقطة البيع</a></li>
                            <li><a class="menu-dropdown-item {{ request()->routeIs('order.realtime') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   target="_blank" rel="noopener" href="{{ route('order.realtime') }}"><i
                                        class="fa fa-external-link-alt ml-1 text-xs opacity-60"></i>قائمة الطلبات</a></li>
                            <li><a class="menu-dropdown-item {{ request()->routeIs('item.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('item.index') }}">قائمة الأصناف</a></li>
                            <li><a class="menu-dropdown-item {{ request()->routeIs('itemType.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('itemType.index') }}">أنواع الأصناف</a></li>
                            <li><a class="menu-dropdown-item {{ request()->routeIs('ingredient.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('ingredient.index') }}">المكونات الأساسية</a></li>
                        </ul>
                    </details>
                </li>
            @endcan

            <li>
                <details class="ta-nav-details" @if ($openStock) open @endif>
                    <summary
                        class="menu-item cursor-pointer select-none {{ $openStock ? 'menu-item-active' : 'menu-item-inactive' }}">
                        <i class="fa fa-warehouse w-5 shrink-0 text-center text-sm"></i>
                        <span class="ta-sb-label">إدارة المخزون</span>
                        <i class="fa fa-chevron-down ta-chevron ta-sb-chevron text-xs"></i>
                    </summary>
                    <ul class="ta-nav-sub mr-9 mt-1 space-y-0.5 border-r border-gray-100 pr-2">
                        <li><a class="menu-dropdown-item {{ request()->routeIs('purchaseOrders.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('purchaseOrders.index') }}">قائمة المشتريات</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('suppliers.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('suppliers.index') }}">قائمة الموردين</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('stock.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('stock.index') }}">قائمة المخزون</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('dailyConsumption.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('dailyConsumption.index') }}">الاستهلاك اليومي</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('order.dailyReport') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('order.dailyReport') }}">التقرير اليومي</a></li>
                    </ul>
                </details>
            </li>

            <li>
                <details class="ta-nav-details" @if ($openExpense) open @endif>
                    <summary
                        class="menu-item cursor-pointer select-none {{ $openExpense ? 'menu-item-active' : 'menu-item-inactive' }}">
                        <i class="fa fa-wallet w-5 shrink-0 text-center text-sm"></i>
                        <span class="ta-sb-label">إدارة المصروفات</span>
                        <i class="fa fa-chevron-down ta-chevron ta-sb-chevron text-xs"></i>
                    </summary>
                    <ul class="ta-nav-sub mr-9 mt-1 space-y-0.5 border-r border-gray-100 pr-2">
                        <li><a class="menu-dropdown-item {{ request()->routeIs('requirement.index', 'requirement.create', 'requirement.edit', 'requirement.store', 'requirement.update', 'requirement.destroy', 'requirement.change') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('requirement.index') }}">الاحتياجات اليومية</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('requirementType.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('requirementType.index') }}">أنواع الاحتياجات</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('dailyExpense.index', 'dailyExpense.create', 'dailyExpense.edit', 'dailyExpense.store', 'dailyExpense.update', 'dailyExpense.destroy') || request()->routeIs('expense.change') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('dailyExpense.index') }}">المنصرفات</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('expenseType.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('expenseType.index') }}">أنواع المنصرفات</a></li>
                    </ul>
                </details>
            </li>

            @can('admin_only')
                <li>
                    <details class="ta-nav-details" @if ($openHr) open @endif>
                        <summary
                            class="menu-item cursor-pointer select-none {{ $openHr ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <i class="fa fa-user-tie w-5 shrink-0 text-center text-sm"></i>
                            <span class="ta-sb-label">شؤون الموظفين</span>
                            <i class="fa fa-chevron-down ta-chevron ta-sb-chevron text-xs"></i>
                        </summary>
                        <ul class="ta-nav-sub mr-9 mt-1 space-y-0.5 border-r border-gray-100 pr-2">
                            <li><a class="menu-dropdown-item {{ request()->routeIs('employee.index', 'employee.create', 'employee.edit', 'employee.store', 'employee.update', 'employee.destroy') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('employee.index') }}">قائمة الموظفين</a></li>
                            <li><a class="menu-dropdown-item {{ request()->routeIs('advance.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('advance.index') }}">السلفيات</a></li>
                            <li><a class="menu-dropdown-item {{ request()->routeIs('attendance.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('attendance.index') }}">قائمة الحضور</a></li>
                            <li><a class="menu-dropdown-item {{ request()->routeIs('employee.calculateSalary') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('employee.calculateSalary') }}">كشف الرواتب</a></li>
                        </ul>
                    </details>
                </li>
            @endcan

            <li>
                <details class="ta-nav-details" @if ($openUsers) open @endif>
                    <summary
                        class="menu-item cursor-pointer select-none {{ $openUsers ? 'menu-item-active' : 'menu-item-inactive' }}">
                        <i class="fa fa-users w-5 shrink-0 text-center text-sm"></i>
                        <span class="ta-sb-label">المستخدمون</span>
                        <i class="fa fa-chevron-down ta-chevron ta-sb-chevron text-xs"></i>
                    </summary>
                    <ul class="ta-nav-sub mr-9 mt-1 space-y-0.5 border-r border-gray-100 pr-2">
                        <li><a class="menu-dropdown-item {{ request()->routeIs('management.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('management.index') }}">قائمة المستخدمين</a></li>
                    </ul>
                </details>
            </li>

            <li>
                <details class="ta-nav-details" @if ($openReports) open @endif>
                    <summary
                        class="menu-item cursor-pointer select-none {{ $openReports ? 'menu-item-active' : 'menu-item-inactive' }}">
                        <i class="fa fa-chart-bar w-5 shrink-0 text-center text-sm"></i>
                        <span class="ta-sb-label">التقارير</span>
                        <i class="fa fa-chevron-down ta-chevron ta-sb-chevron text-xs"></i>
                    </summary>
                    <ul class="ta-nav-sub mr-9 mt-1 space-y-0.5 border-r border-gray-100 pr-2">
                        <li><a class="menu-dropdown-item {{ request()->routeIs('order.index', 'order.show', 'order.edit', 'order.create') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('order.index') }}">تقرير المبيعات</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('order.canceledOrder', 'order.canceledSearch') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('order.canceledOrder') }}">الطلبات الملغاة</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('requirement.showReqReport') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('requirement.showReqReport') }}">تقرير الاحتياجات</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('dailyExpense.showExpenseReport', 'dailyExpense.search') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('dailyExpense.showExpenseReport') }}">تقرير المنصرفات</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('order.dailyReport') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('order.dailyReport') }}">التقرير اليومي</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('order.weeklyReport', 'order.exportWeekReport') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('order.weeklyReport') }}">التقرير الأسبوعي</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('order.monthlyReport', 'order.exporMonthReport') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('order.monthlyReport') }}">التقرير الشهري</a></li>
                        <li><a class="menu-dropdown-item {{ request()->routeIs('summary.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                               href="{{ route('summary.index') }}">التقرير الملخص</a></li>
                    </ul>
                </details>
            </li>

            @can('admin_only')
                <li>
                    <details class="ta-nav-details" @if ($openSettings) open @endif>
                        <summary
                            class="menu-item cursor-pointer select-none {{ $openSettings ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <i class="fa fa-cog w-5 shrink-0 text-center text-sm"></i>
                            <span class="ta-sb-label">الضبط</span>
                            <i class="fa fa-chevron-down ta-chevron ta-sb-chevron text-xs"></i>
                        </summary>
                        <ul class="ta-nav-sub mr-9 mt-1 space-y-0.5 border-r border-gray-100 pr-2">
                            <li><a class="menu-dropdown-item {{ request()->routeIs('unit.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('unit.index') }}">وحدات القياس</a></li>
                            <li><a class="menu-dropdown-item {{ request()->routeIs('setting.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('setting.index') }}">ضبط النظام</a></li>
                            <li><a class="menu-dropdown-item {{ request()->routeIs('payment.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                                   href="{{ route('payment.index') }}">طرق الدفع</a></li>
                        </ul>
                    </details>
                </li>
            @endcan
        </ul>
    </nav>
</aside>
