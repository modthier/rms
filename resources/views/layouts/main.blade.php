<!DOCTYPE html>
<html dir='rtl'>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <meta property='og:title' content='{{ $metaTitle ?? config('app.name') }}'/>
  <base href="./">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $metaTitle ?? config('app.name') }}</title>
    <!-- 
    <link rel="icon" type="image/png" sizes="80x80" href="{{ asset('img/kpms.png') }}">
    -->
  <meta name="theme-color" content="#ffffff">
    <!-- Main styles for this application-->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/select2.min.css') }}">
  <link rel="stylesheet" type="text/css"
     href="{{ asset('cashier/css/fontawesome-free/css/all.css') }}">
  <style type="text/css">
    .form-control {
      font-size: 1.1em;
    }
    .item-img-index {
      max-width: 100%;
    }
    @media screen and (min-width : 992px) {
      .item-img-index {
        width: 100px;
        height: 100px;
      }
    }
  </style>
    <!-- Global site tag (gtag.js) - Google Analytics-->
   
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    // Shared ID
    gtag('config', 'UA-118965717-3');
    // Bootstrap ID
    gtag('config', 'UA-118965717-5');
  </script>
</head>
<body class='c-app'>
@include('parts.sidebar')

@include('parts.nav')

<div class="c-body">
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">

         @if($errors->any())
            @foreach($errors->all() as $error)
              <section class="col-lg-12">
                  <div class="alert alert-danger">
                      {{$error}}
                  </div>
              </section>
            @endforeach
          @endif

          @include('parts/alerts')

         @yield('content')

         
       
      </div>
    </div>
  </main>


  <footer class="c-footer">
    <div><a href="https://coreui.io">CoreUI</a> © 2020 creativeLabs.</div>
    <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
  </footer>

</div>

@include('parts/buttom')

<script type="text/javascript">

    $('body').on('click','.new',function(e){
        e.preventDefault();
        $('#myModal').modal('show');
        
    });

    

    $('#show').on('click',function(e){
        e.preventDefault();
        $('#resturnat').modal('show');
        
    });


    $('#unit_show').on('click',function(e){
        e.preventDefault();
        $('#unit').modal('show');
        
    });

    $('#dailyConsumption').on('change',function () {
        
        var selected = $(this).find('option:selected');
        var remaining_quantity = selected.data('quantity');

        $('#remaining_quantity').val(remaining_quantity);
        $('#requested_quantity').val('');
    });

    $('body').on('change','.quantity',function(){
        var remaining_quantity = parseInt($('#remaining_quantity').val());
        var requested_quantity = parseInt($(this).val());

        if(remaining_quantity){
          if(requested_quantity > remaining_quantity) {
            alert('لا يمكنك سحب كمية اكثر من الموجودة بالمخزون');
              $('#requested_quantity').val(remaining_quantity);
           }
        }else {
          alert('رجاء قم باختيار مخزون اولا');
        }
    });

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $('#employee').select2({
          dropdownParent: $('#myModal'),
           ajax : {
              url: "{{ route('employee.getEmployee') }}",
              type : "post" ,
              dataType : "json",
              data : function (params) {
                 return {
                    _token : CSRF_TOKEN ,
                    search : params.term
                 };
              } ,
              processResults: function (response) {
                
                return{
                  results : response
                };
              },
              cache: true
            }

        });
        
    });


  </script>
</body>
</html>