<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css"
	   href="{{ asset('cashier/css/fontawesome-free/css/all.css') }}">
	<link rel="stylesheet" type="text/css" 
	   href="{{ asset('cashier/css/bootstrap/bootstrap.rtl.min.css') }}">
	<link rel="stylesheet" type="text/css" 
	  href="{{ asset('cashier/css/style.css') }}">

	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $metaTitle ?? config('app.name') }}</title>
    <style type="text/css">
    	body {
		    font-family: "Changa";
		    background: #eee;
		}
    </style>
	@livewireStyles
	
</head>
<body>


   @yield('content')


<script type="text/javascript" 
  src="{{ asset('cashier/js/jquery.min.js') }}"></script>

  @vite('resources/js/app.js')
    @livewireScripts
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/printThis.js') }}"></script>
<script type="text/javascript">

	

	$('body').on('click','.close',function () {
		console.log('click');
		$('#printArea').html('');
		$('#printArea').hide();
		$('#salesPoint').show();

	});
	$('body').on('click','.print',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#print'+id).printThis({
		importCSS: true
	});
        
    });

     $('.leftmenutrigger').on('click', function(e) {
     $('.side-nav').toggleClass("open");
        e.preventDefault();
     });

    
	$("#myForm").on("submit", function(event){
		        event.preventDefault();
		 		$.ajaxSetup({
					headers:{
						'X-CSRF-TOKEN':$('meta[name="csrf_token"]').attr('content')
					}
				});
		        var formValues= $(this).serialize();
		 
		        
		        $.ajax({
					url : '{{ route('cashier.store') }}',
					type : 'post',
					data : formValues,
					success:function(result){
						$('#salesPoint').hide();
						$('.order_list').html('');	
						$('.total').html('');
		                $('#total_all').val('');
		                $('#printArea').show();
		                $('#printArea').html(result);
					}
				})
	});

	$('.item').on('click',function () {

		var id = $(this).data('id');
		var name = $(this).data('name');
		var price = $(this).data('price');
		var quantity = 0;


		var html = 
		`<tr>
			<td>${name}</td>
			<td><input type="number" name="items[${id}][quantity]" class="form-control input-sm quantity" min-value="1" value="1" data-id="${id}" id="qu${id}"
			    data-price="${price}">
			</td>
			<td><input type="text" class="form-control price" name="price${id}" value="${price}" id="price${id}"></td>
			<td><button class="btn btn-danger delete-item"><span class="fas fa-trash-alt"></span></button></td>
		</tr>`;

		if($('#price'+id).length == 0) {
			$('.order_list').append(html);
		}else {
			quantity = parseFloat($('#qu'+id).val());
			var new_q = quantity + 1;
			$('#qu'+id).val(new_q);
			var total = price * new_q;
			$("#price"+id).val(total.toFixed(2));
		}
	
		calulate_total();

	});

	$('body').on('click','.delete-item',function(e){

		e.preventDefault();		
		
		$(this).closest('tr').remove();

		calulate_total();

	});


	$('body').on('change','.quantity',function (e) {

		
		var id = $(this).data('id');
		var price = parseFloat($(this).data('price'));
        var quantity = parseFloat($(this).val());
       

       
        var total = price * quantity;
        
        $("#price"+id).val(total.toFixed(2));
        calulate_total();
        
	});

	$('#cleanBtn').on('click',function (e) {
		e.preventDefault();

		$('.order_list').html('');
		$('.total').html('0.00');
		$('#sales').slideToggle(1000);
		$('#showBtn').css('display','block');
	});


	$('#showBtn').on('click',function (e) {
		$('#sales').slideToggle(1000);
		$('#showBtn').css('display','none');
	});


	function calulate_total() {
		var price = 0.0;
		$('.order_list .price').each(function(index){
			
			price += parseFloat($(this).val());
			
		});

		$('.total').html(price);
		$('#total_all').val(price);

		if (price > 0) {
			$('#orderBtn').attr('disabled',false);
		}else {
			$('#orderBtn').attr('disabled','disabled');
		}
    }

    
	
	
</script>

</body>
</html>