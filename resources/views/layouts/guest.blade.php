<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#465FFF">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/tailadmin.css'])
    @stack('head')
</head>
<body class="min-h-screen bg-gray-50 font-outfit text-gray-800 antialiased">
    @yield('content')
    @stack('scripts')
</body>
</html>
