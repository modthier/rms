<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-100">
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
	@livewireStyles
	@stack('styles')
</head>
<body class="cashier-layout">

<div class="cashier-shell d-flex flex-column min-vh-100">
	@include('cashier.nav')

	<main class="cashier-main flex-grow-1">
		@yield('content')
	</main>

	<footer class="cashier-footer mt-auto">
		<span>{{ config('app.name') }}</span>
		<span class="cashier-footer-year">© {{ date('Y') }}</span>
	</footer>
</div>

<script type="text/javascript"
  src="{{ asset('cashier/js/jquery.min.js') }}"></script>

  @vite('resources/js/app.js')
    @livewireScripts
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/printThis.js') }}"></script>
<script type="text/javascript">



	$('body').on('click','.close',function () {

		$('#printArea').html('');
		$('#printArea').hide();
		$('#salesPoint').show();
		// After receipt: cart is empty — keep حفظ disabled until items are added again.
		calulate_total();

	});
	$('body').on('click','.print',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#print'+id).printThis({
		importCSS: true
	});

    });

     $('.leftmenutrigger').on('click', function(e) {
     e.preventDefault();
     $('.side-nav').toggleClass('open');
     $('.cashier-sidebar-backdrop').toggleClass('is-visible', $('.side-nav').hasClass('open'));
     });

    $('.cashier-sidebar-backdrop').on('click', function () {
        $('.side-nav').removeClass('open');
        $(this).removeClass('is-visible');
    });


	$("#myForm").on("submit", function(event){
		        event.preventDefault();
				$('#orderBtn').attr('disabled','disabled');
		 		$.ajaxSetup({
					headers:{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					}
				});
		        var formValues= $(this).serialize();


		        $.ajax({
					url : '{{ route('cashier.store') }}',
					type : 'post',
					data : formValues,
					dataType: 'html',
					success:function(result){
						if (!result || !String(result).trim()) {
							alert('لم يُرجع الخادم محتوى الإيصال. تحقق من السجلات.');
							return;
						}
						$('#salesPoint').hide();
						$('.order_list').html('');
						$('.total').html('');
		                $('#total_all').val('');
		                $('#printArea').show();
		                $('#printArea').html(result);
					},
					error: function(xhr){
						if (xhr.status === 429) {
							var message = 'تم إرسال طلبات كثيرة بسرعة. الرجاء الانتظار قليلاً ثم إعادة المحاولة.';
							if (xhr.responseJSON && xhr.responseJSON.message) {
								message = xhr.responseJSON.message;
							}
							alert(message);
						} else if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
							var msgs = [];
							$.each(xhr.responseJSON.errors, function (k, v) {
								if ($.isArray(v)) { msgs = msgs.concat(v); } else { msgs.push(v); }
							});
							alert(msgs.length ? msgs.join('\n') : 'بيانات الطلب غير صالحة.');
						} else if (xhr.status === 500) {
							alert('فشل حفظ الطلب على الخادم. حاول مرة أخرى.');
						} else {
							alert('حدث خطأ أثناء حفظ الطلب. حاول مرة أخرى.');
						}
					},
					complete: function (xhr, textStatus) {
						if (textStatus === 'success') {
							// Successful save clears cart — disable حفظ until new lines exist.
							calulate_total();
							return;
						}
						// Errors / 429 / etc.: re-enable so cashier can retry.
						$('#orderBtn').attr('disabled', false);
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
@stack('scripts')

</body>
</html>
