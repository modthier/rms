<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('cashier/css/bootstrap/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cashier/css/style.css') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $metaTitle ?? config('app.name') }}</title>
</head>
<body class="bg-primary intro">
<div class="container">  
     <h1 class="text-white text-center intro-title font-1 mb-5"> بوفية الشباب </h1>

     <div class="inner-intro">
         
         <a href="{{ route('login') }}" class="btn btn-lg btn-warning mb-3">  تسجيل الدخول </a>
       
     </div>
     
</div>

<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>
</html>