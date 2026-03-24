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
  <meta name="theme-color" content="#465FFF">
  @vite(['resources/css/tailadmin.css', 'resources/js/tailadmin-shell.js'])
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
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

    .select2-container--default .select2-selection--single{
          border-radius: 0.25em;
          width: 100%;
          height: 43.03px;
          padding: 0.375rem 0.75rem;
          font-size: 1rem;
          font-weight: 400;
          line-height: 1.5;
          color: #495057;
         
    }

    @media screen and (min-width : 992px) {
      .item-img-index {
        width: 100px;
        height: 100px;
      }
    }
  </style>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-118965717-3');
    gtag('config', 'UA-118965717-5');
  </script>
</head>
<body id="ta-body" class="ta-shell c-app min-h-screen">
<div id="ta-backdrop" class="hidden" aria-hidden="true"></div>

@include('parts.sidebar')

<div id="ta-main" class="ta-main">
  @include('parts.nav')

  <div class="c-body flex-1">
    <main class="c-main">
      <div class="container-fluid px-4 pb-6 pt-4 md:px-6">
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

    <footer class="c-footer border-t border-gray-100 bg-white/80">
      <div>{{ config('app.name') }} — لوحة إدارة المطعم</div>
      <div class="ml-auto">© {{ date('Y') }}</div>
    </footer>
  </div>
</div>

@include('parts/buttom')

<script type="text/javascript">
    $(document).ready(function () {
        var price = 0.0;
        $('#area .subtotal').each(function(index){
          
          price += parseFloat($(this).val());
          
        });

        $('.purchase_total').html(price.toFixed(2));
        $('#purchase_total_all').val(price.toFixed(2));

        
    });
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
  @stack('js')
</body>
</html>
