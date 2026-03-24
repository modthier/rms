@extends('layouts.guest')

@section('title', 'تسجيل الدخول — ' . config('app.name'))

@section('content')
<div class="relative min-h-screen overflow-hidden">
    {{-- Background --}}
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-bl from-brand-100/80 via-white to-gray-100"></div>
    <div class="pointer-events-none absolute -left-32 top-1/4 h-96 w-96 rounded-full bg-brand-400/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-brand-600/10 blur-3xl"></div>

    <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-10 sm:px-6">
        <div class="mb-8 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 rounded-2xl no-underline">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-500 text-white shadow-theme-lg ring-4 ring-brand-500/15">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </span>
                <span class="text-right">
                    <span class="block text-lg font-bold text-gray-900">{{ config('app.name', 'RMS') }}</span>
                    <span class="text-theme-sm text-gray-500">نظام إدارة المطعم</span>
                </span>
            </a>
        </div>

        <div class="w-full max-w-[420px] rounded-2xl border border-gray-200/80 bg-white/90 p-8 shadow-theme-xl backdrop-blur-sm sm:p-10">
            <h1 class="text-center text-title-sm font-bold text-gray-900">تسجيل الدخول</h1>
            <p class="mt-2 text-center text-theme-sm text-gray-500">أدخل بياناتك للمتابعة إلى لوحة التحكم</p>

            @if ($errors->any())
                <div class="mt-6 rounded-xl border border-error-500/20 bg-error-500/5 px-4 py-3 text-theme-sm text-error-600" role="alert">
                    <ul class="m-0 list-none space-y-1 p-0 text-right">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-right text-theme-sm font-medium text-gray-700">البريد الإلكتروني</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-right text-theme-sm text-gray-900 shadow-theme-xs transition placeholder:text-gray-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 @error('email') border-error-500 ring-2 ring-error-500/20 @enderror"
                        placeholder="name@example.com"
                    >
                    @error('email')
                        <p class="mt-1.5 text-right text-theme-xs text-error-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-right text-theme-sm font-medium text-gray-700">كلمة المرور</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-right text-theme-sm text-gray-900 shadow-theme-xs transition placeholder:text-gray-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 @error('password') border-error-500 ring-2 ring-error-500/20 @enderror"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-1.5 text-right text-theme-xs text-error-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <label class="flex cursor-pointer items-center gap-2 text-theme-sm text-gray-600">
                        <input type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500/30">
                        <span>تذكرني</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-theme-sm font-medium text-brand-600 no-underline hover:text-brand-700">
                            نسيت كلمة المرور؟
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full rounded-xl bg-brand-500 px-4 py-3.5 text-base font-semibold text-white shadow-theme-md transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 active:scale-[0.99]">
                    دخول
                </button>
            </form>

            @if (Route::has('register'))
                <p class="mt-8 border-t border-gray-200 pt-6 text-center text-theme-sm text-gray-500">
                    ليس لديك حساب؟
                    <a href="{{ route('register') }}" class="font-semibold text-brand-600 no-underline hover:text-brand-700">إنشاء حساب</a>
                </p>
            @endif
        </div>

        <p class="mt-8 text-center text-theme-xs text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </p>
    </div>
</div>
@endsection
