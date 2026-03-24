<header
    class="sticky top-0 z-[99999] flex w-full flex-col border-b border-gray-200 bg-white shadow-theme-xs xl:flex-row xl:items-center xl:justify-between xl:px-6">
    <div
        class="flex w-full flex-wrap items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 sm:gap-3 xl:border-b-0 xl:px-0 xl:py-4">
        <div class="flex items-center gap-2">
            <button type="button" data-ta-toggle-sidebar
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 xl:h-11 xl:w-11"
                    aria-label="فتح أو طي القائمة">
                <i class="fa fa-bars"></i>
            </button>
            <a class="text-base font-semibold text-gray-800 no-underline xl:hidden"
               href="{{ Auth::user()->can('admin_only') ? route('admin.dashboard') : route('home') }}">{{ config('app.name') }}</a>
        </div>

        <div class="hidden min-w-0 flex-1 px-2 xl:block xl:max-w-xl xl:px-4">
            <div class="relative">
                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fa fa-search text-sm"></i>
                </span>
                <input data-ta-search type="search" placeholder="بحث سريع… (Ctrl+K)"
                       class="h-11 w-full rounded-lg border border-gray-200 bg-white py-2.5 pr-10 pl-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-4 focus:ring-brand-500/10"
                       aria-label="بحث">
            </div>
        </div>

        <div class="flex items-center gap-1 sm:gap-2">
            <span class="hidden max-w-[200px] truncate text-sm font-medium text-gray-600 md:inline">{{ $metaTitle ?? 'لوحة التحكم' }}</span>

            <div class="dropdown">
                <a class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100"
                   data-toggle="dropdown" href="#" role="button" title="الإشعارات">
                    <i class="fa fa-bell"></i>
                    <span class="sr-only">الإشعارات</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-0 text-right shadow-theme-md">
                    <div class="border-b border-gray-100 bg-gray-50 px-3 py-2 text-xs font-semibold text-gray-600">الإشعارات</div>
                    <span class="dropdown-item-text block px-3 py-4 text-center text-sm text-gray-400">لا توجد إشعارات</span>
                </div>
            </div>

            <a class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100"
               href="{{ route('setting.index') }}" title="الإعدادات">
                <i class="fa fa-cog"></i>
            </a>

            <div class="dropdown">
                <a class="flex items-center gap-2 rounded-lg py-1 pr-2 pl-1 hover:bg-gray-50" data-toggle="dropdown" href="#"
                   role="button">
                    <img class="h-9 w-9 rounded-full object-cover" src="{{ asset('img/placeholder-face-big.png') }}"
                         alt="{{ Auth::user()->name ?? '' }}">
                    <span class="hidden max-w-[120px] truncate text-sm font-medium text-gray-700 md:inline">{{ Auth::user()->name ?? '' }}</span>
                    <i class="fa fa-chevron-down text-xs text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right min-w-[10rem] py-1 text-right shadow-theme-md">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="dropdown-item flex items-center justify-end gap-2">
                        <span>{{ __('Logout') }}</span>
                        <i class="fa fa-sign-out-alt text-gray-400"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</header>
